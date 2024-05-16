<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\AdminNotification;
use App\Models\Contact;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\User;
use App\Models\UserLogin;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Constants\Status;
use Illuminate\Support\Facades\Http;
use App\Models\Guess;
use App\Models\WinnerAmount;
use Carbon\Carbon;

class AdminController extends Controller {

    public function dashboard() {

        $pageTitle = 'Dashboard';

        // User Info
        $widget['total_users']             = User::count();








        return view('admin.dashboard', compact('pageTitle', 'widget' ));
    }
    public function profile() {
        $pageTitle = 'Profile';
        $admin = auth('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $user = auth('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('adminProfile'), getFileSize('adminProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return to_route('admin.profile')->withNotify($notify);
    }

    public function password() {
        $pageTitle = 'Password Setting';
        $admin = auth('admin')->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request) {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = auth('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('admin.password')->withNotify($notify);
    }

    public function notifications() {
        $notifications = AdminNotification::orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        $pageTitle = 'Notifications';
        return view('admin.notifications', compact('pageTitle', 'notifications'));
    }


    public function notificationRead($id) {
        $notification = AdminNotification::findOrFail($id);
        $notification->is_read  = Status::YES;
        $notification->save();
        $url = $notification->click_url;
        if ($url == '#') {
            $url = url()->previous();
        }
        return redirect($url);
    }

    public function requestReport() {
        $pageTitle = 'Your Listed Report & Request';
        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $url = "https://license.viserlab.com/issue/get?" . http_build_query($arr);
        $response = CurlRequest::curlContent($url);
        $response = json_decode($response);
        if ($response->status == 'error') {
            return to_route('admin.dashboard')->withErrors($response->message);
        }
        $reports = $response->message[0];
        return view('admin.reports', compact('reports', 'pageTitle'));
    }

    public function reportSubmit(Request $request) {
        $request->validate([
            'type' => 'required|in:bug,feature',
            'message' => 'required',
        ]);
        $url = 'https://license.viserlab.com/issue/add';

        $arr['app_name']      = systemDetails()['name'];
        $arr['app_url']       = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $arr['req_type']      = $request->type;
        $arr['message']       = $request->message;

        $response = CurlRequest::curlPostContent($url, $arr);
        $response = json_decode($response);

        if ($response->status == 'error') {
            return back()->withErrors($response->message);
        }
        $notify[] = ['success', $response->message];
        return back()->withNotify($notify);
    }

    public function readAll() {
        AdminNotification::where('is_read', Status::NO)->update([
            'is_read' => Status::YES
        ]);

        $notify[] = ['success', 'Notifications read successfully'];
        return back()->withNotify($notify);
    }

    public function downloadAttachment($fileHash) {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function guessWinner()
    {
        $guess = Guess::latest()->with('user')->get();
        $pageTitle = 'Guess List';

        return view('admin.guess.index',compact('guess','pageTitle'));
    }

    public function selectWinners()
    {

        $currentTime = Carbon::now();
        $twelveHoursAgo = $currentTime->subHours(12);

        $bitcoinPrice = $this->getBitcoinPrice();
        $guesses = Guess::where('created_at','>=',$twelveHoursAgo)->get();

        $differences = [];
        foreach ($guesses as $guess) {
            $differences[$guess->id] = abs($guess->guess - $bitcoinPrice);
        }

       if(!$differences){
           $notify[] = ['error','No guess winner found from last 12 hour'];
           return back()->withNotify($notify);
       }
        $winnerGuessId = array_keys($differences, min($differences));
        foreach($winnerGuessId as $gi)
        {
            $user = Guess::find($gi);

            if($user){
                $winner = $user->user;
                $winner->balance += gs()->winner_bonus;
                $winner->save();

                $wt = new WinnerAmount;
                $wt->user_id = $winner->id;
                $wt->guess_id = $gi;
                $wt->amount = gs()->winner_bonus;
                $wt->save();

                notify($winner, 'WINNER_BONUS', [
                    'amount' => gs()->winner_bonus,
                    'balance' => $winner->balance
                 ]);
            }
        }
        Guess::where('id', $winnerGuessId)->update(['is_winner' => true]);


        $notify[] = ['success', 'Winner selected successfully!'];
        return back()->withNotify($notify);
    }

    public function getBitcoinPrice()
    {
        $response = Http::get('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd');

        if ($response->successful()) {
            $bitcoinPrice = $response->json()['bitcoin']['usd'];
            return $bitcoinPrice;
        } else {
            // Handle error, return default value or throw an exception
            return null;
        }
    }
    public function contactIndex()
    {
        $pageTitle = 'Contacts';

        $contacts = Contact::all(); // Fetch all contacts from the database

        return view('admin.contact.index', compact('contacts','pageTitle'));
    }


}
