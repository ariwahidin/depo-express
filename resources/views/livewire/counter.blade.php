<?php

use function Livewire\Volt\{state};

state('count', 0);

$increment = function () {
    $this->count++;
};

?>

<div>
    <h1>Counter</h1>
    <p>Count: {{ $count }}</p>
    <button wire:click="increment">Increment</button>
</div>
