<?php

namespace App\Livewire\Blog;

use Livewire\Attributes\Validate;
use Livewire\Component;

class Subscribe extends Component
{
    #[Validate('required|email|unique:subscribers,email')]
    public $email = '';

    public function subscribe(): void
    {
        $this->validate();

        $subscriber = new \App\Models\Subscriber(attributes: [
            'email' => $this->email,
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        $subsscriber->save();

        session()->flash(key: 'subscribe-success', value: 'Thanks for subscribing! You\'ll receive our latest up');
    }

    public function render(): View
    {
        return view(view: 'livewire.blog.subscribe');
    }
}