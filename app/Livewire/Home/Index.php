<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Events\OrderCreated;

class Index extends Component
{

    public $todos = [];

    public $todo = '';

    public function add()
    {
        $this->todos[] = $this->todo;

        $this->todo = '';
    }
    
    public function render()
    {
        return view('livewire.home.index');
    }

    public function testEvent()
    {
        event(new OrderCreated());
    }
}
