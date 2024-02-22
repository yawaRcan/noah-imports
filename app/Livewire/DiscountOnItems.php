<?php

namespace App\Livewire;

use Livewire\Component;

class DiscountOnItems extends Component
{
    public $discount = '14';
    public function render()
    {
        return view('livewire.discount-on-items');
    }
    public function save()
    {
        dd($this->discount);
    }
}
