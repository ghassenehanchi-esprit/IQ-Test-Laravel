<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Exchange;
use App\Models\Referral;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Models\CommissionLog;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class ExchangeController extends Controller
{
    public function index($scope)
    {
        try {
            $exchanges = Exchange::$scope()->desc()->with('user', 'sendCurrency', 'receivedCurrency')->searchable(['exchange_id'])->filter(['user_id'])->dateFilter()->paginate(getPaginate());
            $pageTitle = formateScope($scope) . ' Exchange';
        } catch (Exception $ex) {
            $notify[] = ['error', "Invalid URL"];
            return to_route('admin.exchange.list', 'list')->withNotify($notify);
        }

        return view('admin.exchange.list', compact('pageTitle', 'exchanges'));
    }

    public function details($id)
    {
        $exchange  = Exchange::findOrFail($id);
        $pageTitle = 'Exchange Details: ' . $exchange->exchange_id;
        return view('admin.exchange.details', compact('pageTitle', 'exchange'));
    }

    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required',
        ]);

        $exchange = Exchange::where('id', $id)->pending()->firstOrFail();

        $exchange->admin_feedback = $request->cancel_reason;
        $exchange->status         = Status::EXCHANGE_CANCEL;
        $exchange->save();

        notify($exchange->user, 'CANCEL_EXCHANGE', [
            'exchange' => $exchange->exchange_id,
            'reason'   => $exchange->cancel_reason
        ]);

        $notify[] = ['success', 'Exchange canceled successfully'];
        return back()->withNotify($notify);
    }

    public function refund(Request $request, $id)
    {
        $request->validate([
            'refund_reason' => 'required',
        ]);

        $exchange = Exchange::where('id', $id)->pending()->firstOrFail();

        $exchange->admin_feedback = $request->refund_reason;
        $exchange->status         = Status::EXCHANGE_REFUND;
        $exchange->save();

        notify($exchange->user, 'EXCHANGE_REFUND', [
            'exchange' => $exchange->exchange_id,
            'currency' => $exchange->sendCurrency->cur_sym,
            'amount'   => showAmount($exchange->user_total_send_amount),
            'method'   => $exchange->sendCurrency->name,
            'reason'   => $exchange->admin_feedback
        ]);

        $notify[] = ['success', 'Exchange refunded successfully'];
        return back()->withNotify($notify);
    }


    public function approve(Request $request, $id)
{
    $request->validate([
        'transaction' => 'required',
    ]);

    $exchange = Exchange::where('id', $id)->pending()->firstOrFail();
    $exchange->status       = Status::EXCHANGE_APPROVED;
    $exchange->admin_trx_no = $request->transaction;
    $exchange->save();

    $user = User::find($exchange->user_id);
    $gs   = gs();

    if ($gs->exchange_commission == 1) {
     $amount = $exchange->buy_rate * $exchange->sending_amount;
      $this->levelCommission($user->id, $amount, 'exchange_commission',$exchange->exchange_id);
    }

    if ($user->ref_by && Exchange::where('user_id', $user->id)->where('status', Status::EXCHANGE_APPROVED)->count() === 1)   
    {
         $referrer = User::find($user->ref_by);
         if ($referrer) {
            $commission = new CommissionLog();
            $commission->user_id = $referrer->id;
            $commission->who = $user->id;
            $commission->level = 'First Exchange Referral Commission';
            $commission->amount = 500;
            $commission->main_amo = $referrer->balance + 500;
            $commission->title = 'First Exchange Fixed Commission';
            $commission->save();
        
            
        
            $commission->trx = $exchange->exchange_id;
            $commission->save();
            $referrer->balance+= 500;
            $referrer->save();
        }
        
}


    //=======reserve subtract
    $sendCurrency          = $exchange->receivedCurrency;
    $sendCurrency->reserve -= ($exchange->receiving_amount - $exchange->receiving_charge);
    $sendCurrency->save();

    //=======reserve added
    $receivedCurrency          = $exchange->sendCurrency;
    $receivedCurrency->reserve += ($exchange->sending_amount + $exchange->sending_charge);
    $receivedCurrency->save();

    notify($user, 'APPROVED_EXCHANGE', [
        'exchange'                 => $exchange->exchange_id,
        'currency'                 => $exchange->receivedCurrency->cur_sym,
        'amount'                   => showAmount($exchange->receiving_amount),
        'method'                   => $exchange->receivedCurrency->name,
        'admin_transaction_number' => $request->transaction
    ]);

    $notify[] = ['success', 'Exchange approved successfully'];
    return back()->withNotify($notify);
}


    public function levelCommission($id, $amount, $commissionType = '',$exchange_id)
    {
        $usr   = $id;
        $i     = 1;
        $level = Referral::count();

        while ($usr != "" || $usr != "0" || $i < $level) {
            $me    = User::find($usr);
            $refer = User::find($me->ref_by);
            if ($refer == "") {
                break;
            }

            $commission = Referral::where('level', $i)->first();
            if ($commission == null) {
                break;
            }

            $com                  = ($amount * $commission->percent) / 100;
            $referWallet          = User::where('id', $refer->id)->first();
            $referWallet->balance +=   $com;
            $referWallet->save();

            $commission = new CommissionLog();
            $commission->user_id = $refer->id;
            $commission->who = $id;
            $commission->level = 'Percentage Referral Commission';
            $commission->amount = $com;
            $commission->main_amo =  $referWallet->balance;
            $commission->title = $commissionType;
            $commission->save();
            
            
            $trx=$exchange_id;
            $commission->trx =$exchange_id;
            $commission->save();
            $newBal=$referWallet->balance;

            notify($refer, 'REFERRAL_COMMISSION', [
                'amount'       => getAmount($com),
                'post_balance' => $newBal,
                'trx'          => $trx,
                'level'        =>  'Percentage level Referral Commission',
            ]);
            $usr = $refer->id;
            $i++;
        }
        return 0;
    }

    public function download($exchangeId)
    {
        $pageTitle = "Download Exchange";
        $exchange  = Exchange::where('status', '!=', Status::EXCHANGE_INITIAL)->where('id', $exchangeId)->with('user')->firstOrFail();
        $user = $exchange->user;
        $pdf       = PDF::loadView('partials.pdf', compact('pageTitle', 'user', 'exchange'));
        $fileName  = $exchange->exchange_id . '_' . time();
        return $pdf->download($fileName . '.pdf');
    }
}
