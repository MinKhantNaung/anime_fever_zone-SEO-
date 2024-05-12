<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;

class SubscriberController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($token, $email)
    {
        $subscriber = Subscriber::where('token', $token)
            ->where('email', $email)
            ->first();

        if ($subscriber) {
            $subscriber->token = '';
            $subscriber->status = 'Active';
            $subscriber->update();

            return view('subscription_info', ['info' => 'success']);
        } else {
            return view('subscription_info', ['info' => 'error']);
        }
    }
}
