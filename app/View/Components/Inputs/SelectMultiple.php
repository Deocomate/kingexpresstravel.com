<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectMultiple extends Component
{
    public string $label;
    public string $name;
    public bool $required; // Thêm dòng này

    public function __construct($label, $name, $required = false) // Sửa dòng này
    {
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.select-multiple');
    }
}
