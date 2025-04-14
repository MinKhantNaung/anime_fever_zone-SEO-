<?php

namespace App\Services;

use App\Mail\WebsiteMail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

final class SubscriberService
{
    public function __construct(private Subscriber $subscriber) {}

    public function store(array $attributes, string $token): void
    {
        $this->subscriber->create([
            'email' => $attributes['email'],
            'token' => $token,
            'status' => 'Pending'
        ]);
    }

    public function sendMail(array $attributes, string $token): void
    {
        $subject = 'Please Comfirm Subscription';

        $verificationLink = url('subscriber/verify/' . $token . '/' . $attributes['email']);

        $message = 'Please click on the following link in order to verify as subscriber:<br><br>';
        $message .= '<a href="' . $verificationLink . '">';
        $message .= $verificationLink;
        $message .= '</a><br><br>';
        $message .= 'If you received this email by mistake, simply delete it. You will not be subscribed if you do not  click the confirmation link above.';

        Mail::to($attributes['email'])->send(new WebsiteMail($subject, $message));
    }
}
