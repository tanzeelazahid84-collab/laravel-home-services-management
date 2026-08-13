<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function success(Request $request, Booking $booking)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($request->query('session_id'));

        if ($session->payment_status === 'paid') {
            Payment::create([
                'booking_id' => $booking->id,
                'customer_id' => $booking->customer_id,
                'amount' => $booking->amount,
                'payment_method' => 'stripe',
                'transaction_id' => $session->payment_intent,
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            $booking->update(['payment_status' => 'paid']);

            return redirect()->route('customer.my-bookings')->with('message', 'Payment successful!');
        }

        return redirect()->route('customer.my-bookings')->with('message', 'Payment could not be verified.');
    }
}