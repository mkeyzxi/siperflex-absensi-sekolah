<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class TentangKami extends Component
{
    public function render()
    {
        return view('livewire.tentang-kami');
    }
}
