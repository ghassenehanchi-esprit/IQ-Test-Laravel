<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\QuizOrder;
use App\Models\Quizz;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function showPaymentPage($id)
    {
        // Assuming 'GeneralSetting' has a 'quiz_price' column
        $price = GeneralSetting::first()->quiz_price;

        // Check if an order already exists for this quiz and user
        $existingOrder = QuizOrder::where('quizz_id', $id)
            ->first();

        if ($existingOrder) {
            // An order already exists, use the existing order
            $quizOrder = $existingOrder;
        } else {
            // Create a new QuizOrder
            $quizOrder = QuizOrder::create([
                'quizz_id' => $id,
                'is_paid' => 0,
                // Default value
            ]);
        }
        $quiz = Quizz::find($id);
        $quiz->quizz_status = 1;
        $quiz->quizz_score=calculateQuizScore($id);

        $quiz->save();
        // Return the 'order/payment' view with the compacted 'price' and 'quizOrder' variables
        return view('order.payment', compact('price', 'quizOrder'));
    }

    public function showPayment($id)
    {
        // Retrieve the RankBoostOrder based on the provided ID
        $price = GeneralSetting::first()->quiz_price;

        // Set your Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a new Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => $price * 100, // Convert to cents
                        'product_data' => [
                            'name' => 'IQ Test Quiz',
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('order.result', ['id' => $id]),
            'cancel_url' => route('home'),
        ]);

        // Retrieve the session ID
        $sessionId = $session->id;

        // Update the order's stripe_session_id
        $order = QuizOrder::findOrFail($id);
        $order->stripe_session_id = $sessionId;
        $order->save();

        // Redirect the user to the Checkout page
        return redirect()->away($session->url);
    }

    public function showPaypalPayment($id)
    {
        // Retrieve the RankBoostOrder based on the provided ID
        $price = GeneralSetting::first()->quiz_price;

        // Set your PayPal API credentials
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_SECRET');

        // Set up the PayPal API environment
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);

        // Create a new PayPal order request
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'EUR',
                        'value' => $price,
                    ],
                    'description' => 'IQ Test Quiz',
                ],
            ],
            'application_context' => [
                'return_url' => route('order.result', ['id' => $id]),
                'cancel_url' => route('home'),
            ],
        ];

        try {
            // Create the PayPal order
            $response = $client->execute($request);

            // Retrieve the approval URL from the response
            $approvalUrl = null;
            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    $approvalUrl = $link->href;
                    break;
                }
            }

            if ($approvalUrl) {
                // Update the order's paypal_session_id with the PayPal order ID
                $order = QuizOrder::findOrFail($id);
                $order->paypal_session_id = $response->result->id;
                $order->save();

                // Redirect the user to the PayPal approval URL
                return redirect()->away($approvalUrl);
            } else {
                return response()->json(['error' => 'Failed to retrieve PayPal approval URL.'], 500);
            }
        } catch (\Exception $e) {
            // Handle any errors that occurred during the order creation
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}
