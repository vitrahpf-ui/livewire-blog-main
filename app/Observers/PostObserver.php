<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //check if post status is published and was not published before 
        if ($post->isDirty(attributes: 'status') && $post->status == 'published' && $post->getOriginal(key: 'status') != 'published') {
        // send notification to all verified subscribers
        $subscribers = \App\Models\Subscriber::where(column: 'verified', operator: true)->get();
        // send notification to each subscriber
        if ($subscribers->count() > 0) {
            Notification::send(notifiables: $subscribers, notification: new \App\Notifications\NewPostPublished(post: $post));
        }
    }
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
