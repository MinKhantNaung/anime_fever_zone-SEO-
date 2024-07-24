<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Post;
use Livewire\Component;
use App\Mail\WebsiteMail;
use App\Models\SiteSetting;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class PostShow extends Component
{
    public $slug;
    public $post;
    public $featuredPosts;

    public $email;
    public bool $emailVerifyStatus;

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|string|email|unique:subscribers'
        ]);

        $token = hash('sha256', time());

        Subscriber::create([
            'email' => $this->email,
            'token' => $token,
            'status' => 'Pending'
        ]);

        // Send email
        $subject = 'Please Comfirm Subscription';
        $verification_link = url('subscriber/verify/' . $token . '/' . $this->email);
        $message = 'Please click on the following link in order to verify as subscriber:<br><br>';

        $message .= '<a href="' . $verification_link . '">';
        $message .= $verification_link;
        $message .= '</a><br><br>';
        $message .= 'If you received this email by mistake, simply delete it. You will not be subscribed if you do not  click the confirmation link above.';

        Mail::to($this->email)->send(new WebsiteMail($subject, $message));

        $this->dispatch('subscribed', [
            'title' => 'Thanks, please check your inbox to confirm subscription!',
            'icon' => 'success',
            'iconColor' => 'green'
        ]);
    }

    public function mount()
    {
        $this->post = Post::with('media', 'topic', 'tags', 'sections')
            ->select('id', 'topic_id', 'heading', 'body', 'created_at', 'updated_at')
            ->where('slug', $this->slug)
            ->first();

        $this->featuredPosts = Post::select('id', 'heading', 'slug')
            ->inRandomOrder()
            ->where('id', '!=', $this->post->id)
            ->where('updated_at', '>=', Carbon::now()->subMonth())
            ->where('is_publish', true)
            ->take(5)
            ->get();

        $this->emailVerifyStatus = SiteSetting::first()->email_verify_status;
    }

    public function render()
    {
        return view('livewire.post-show')
            ->title(ucwords(str_replace('-', ' ', $this->slug)) . ' - Anime Fever Zone');
    }
}
