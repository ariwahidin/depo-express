<?php

namespace App\Livewire\Post;

use Livewire\Component;

class Block extends Component
{
    public $posts;

    #[ \Livewire\Attributes\On('reloadPosts') ]
    public function mount()
    {
        $this->posts = \App\Models\Post::where('delete_status', 'no')->orderByDesc('created_at')->get();
    }
    public function render()
    {
        return view('livewire.post.block');
    }
}
