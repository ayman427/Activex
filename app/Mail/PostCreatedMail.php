<?php
namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $post;
    public $postUrl;

    public function __construct(Post $post)
    {
        $this->post = $post;
        // Generate the URL to the post page
        $this->postUrl = route('post.show', $post->id);
    }

    public function build()
    {
        return $this->subject("New Post Created")
                    ->view('emails.post_created')
                    ->with([
                        'postTitle' => $this->post->title,
                        'postContent' => $this->post->content,
                        'postUrl' => $this->postUrl,
                    ]);
    }
}
