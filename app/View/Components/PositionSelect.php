<?php

namespace App\View\Components;

use App\Models\Position;
use Illuminate\View\Component;

class PositionSelect extends Component
{
    public $positions;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->positions = Position::all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.position-select');
    }
}
