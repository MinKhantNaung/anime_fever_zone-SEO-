<?php

namespace App\Services;

use App\Mail\WebsiteMail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

final class SubscriberService
{
    protected $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function store($validatedRequest, $token)
    {
        $this->subscriber->create([
            'email' => $validatedRequest['email'],
            'token' => $token,
            'status' => 'Pending'
        ]);
    }

    public function sendMail($validatedRequest, $token)
    {
        // Send email
        $subject = 'Please Comfirm Subscription';
        $verification_link = url('subscriber/verify/' . $token . '/' . $validatedRequest['email']);
        $message = 'Please click on the following link in order to verify as subscriber:<br><br>';

        $message .= '<a href="' . $verification_link . '">';
        $message .= $verification_link;
        $message .= '</a><br><br>';
        $message .= 'If you received this email by mistake, simply delete it. You will not be subscribed if you do not  click the confirmation link above.';

        Mail::to($validatedRequest['email'])->send(new WebsiteMail($subject, $message));
    }
}
