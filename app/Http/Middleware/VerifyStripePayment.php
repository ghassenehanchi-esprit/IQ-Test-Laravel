<?php

namespace App\Http\Middleware;

use Closure;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Stripe\Stripe;
use App\Models\QuizOrder;
use Illuminate\Http\Request;
use Stripe\Checkout\Session as StripeSession;

class VerifyStripePayment
{
    public function handle(Request $request, Closure $next)
    {
        // Retrieve the order ID from the route parameter
        $id = $request->route('id');

        // Retrieve the order
        $order = QuizOrder::findOrFail($id);

        // Check if the order has been paid
        if ($order->is_paid) {
            // The order has already been paid
            return $next($request);
        }

        // Check for Stripe payment
        if (!empty($order->stripe_session_id)) {
            // Set Stripe API key
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // Retrieve the Stripe session
            try {
                $stripeSession = StripeSession::retrieve($order->stripe_session_id);

                // Check if the payment was successful
                if ($stripeSession->payment_status == 'paid') {
                    // Set the 'is_paid' attribute to 1
                    $order->is_paid = 1;
                    $order->save();

                    return $next($request);
                }
            } catch (\Exception $e) {
                // Handle the case where the Stripe session retrieval fails
                return response()->view('errors.403', ['message' => 'Invalid Stripe payment session.'], 403);
            }
        }

        // Check for PayPal payment
        if (!empty($order->paypal_session_id)) {
            // Set up the PayPal API environment
            $clientId = env('PAYPAL_CLIENT_ID');
            $clientSecret = env('PAYPAL_SECRET');
            $environment = new SandboxEnvironment($clientId, $clientSecret);
            $client = new PayPalHttpClient($environment);

            // Capture the order after the payer approves the payment
            $request = new OrdersCaptureRequest($order->paypal_session_id);
            $request->prefer('return=representation');

            try {
                // Perform the capture
                $response = $client->execute($request);

                // Check if the capture was successful
                if ($response->statusCode == 201 && $response->result->status == 'COMPLETED') {
                    // Set the 'is_paid' attribute to 1
                    $order->is_paid = 1;
                    $order->save();

                    return $next($request);
                }
            } catch (\Exception $e) {
                // Handle any errors that occurred during the PayPal capture
                return response()->view('errors.403', ['message' => 'Invalid PayPal payment session.'], 403);
            }
        }

        // If neither payment session is valid, return an error
        return response()->view('errors.403', ['message' => 'Payment not completed.'], 403);
    }

}
