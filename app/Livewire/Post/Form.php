<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $categories;
    public $category_id;
    public $title;
    public $body;
    public $edit = false;

    public function mount()
    {
        $this->categories = \App\Models\Category::where('delete_status', 'no')->orderByDesc('created_at')->get();
    }

    public function create(){
        $validatedData = $this->validate([
            'category_id' => 'required',
            'title' => 'required',
            'body' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $data = [
                'category_id' => $validatedData['category_id'],
                'title' => $validatedData['title'],
                'body' => $validatedData['body'],
                'created_by' => Auth::id(),
            ];
            \App\Models\Post::create($data);
            DB::commit();
            $this->reset(['category_id', 'title', 'body']);
            $this->dispatch('reloadPosts');
            session()->flash('success', 'Post created successfully');
            $this->dispatch('reloadPosts');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error('Error: ' . $th->getMessage()); // Log kesalahan
            session()->flash('error', 'Failed to create post: ' . $th->getMessage());
            $this->dispatch('reloadPosts');
        }
    }

    public function render()
    {
        return view('livewire.post.form');
    }

    
}
