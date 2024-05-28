<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\NewCommentEvent;
use App\Notification;
class NotifyBlogOwner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewCommentEvent $event)
    {
        $notification  = new Notification;
        $notification -> subject = "Comment";
        $notification -> message = $event-> comment -> name ." commented on post ". $event-> blog -> Title;
        $notification -> blog_id = $event-> comment -> blog_id;
        $notification -> from_user_id = $event->comment -> user_id;
        //to user it sholud be from blog post that posted the post
        $notification -> to_user_id = $event->blog -> user_id;
        $notification -> save();
    }
}
