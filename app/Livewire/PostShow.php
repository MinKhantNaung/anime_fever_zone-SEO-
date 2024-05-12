<?php

namespace App\Livewire;

use App\Mail\WebsiteMail;
use App\Models\Post;
use Livewire\Component;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class PostShow extends Component
{
    public $slug;
    public $post;
    public $popularPosts;

    public $email;

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
        $this->post = Post::with('media', 'topic', 'tags', 'sections', 'comments')
            ->select('id', 'topic_id', 'heading', 'body', 'view', 'created_at')
            ->where('slug', $this->slug)
            ->first();

        $this->popularPosts = Post::select('id', 'heading', 'slug')
            ->inRandomOrder()
            ->where('id', '!=', $this->post->id)
            ->take(3)
            ->get();

        if ($this->post) {
            // Increment view count
            $this->post->view++;
            $this->post->save();
        }
    }

    public function render()
    {
        return view('livewire.post-show');
    }
}
