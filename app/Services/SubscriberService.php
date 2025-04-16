<?php

namespace App\Services;

use App\Models\Post;
use App\Mail\PostMail;
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

    public function sendNewPostMailToAll(Post $post)
    {
        $subject = 'Your Daily Dose of [Anime Fever Zone]: New Post Alert!';
        $new_post_link = url($post->slug . '/post');
        $body = "<p style='font-weight: bolder; font-size: 25px;'>$post->heading</p>";
        $body .= "Click on the following link to read <br>";

        $body .= '<a href="' . $new_post_link . '">';
        $body .= $new_post_link;
        $body .= '</a>';

        $subscribers = Subscriber::where('status', 'Active')->get();

        // $subscribers->chunk(100, function ($batch) use ($subject, $message, $post) {
        //     foreach ($batch as $subscriber) {
        //         Mail::to($subscriber->email)->send(new PostMail($subject, $message, $post->media->url));
        //     }
        // });

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new PostMail($subject, $body, $post->media->url));
        }
    }
}
