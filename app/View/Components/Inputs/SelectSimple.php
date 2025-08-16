<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectSimple extends Component
{
    public string $label;
    public string $name;
    public string $value;
    public bool $required;

    public function __construct($label, $name, $value = null, $required = false) // Sửa dòng này
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value != null ? $value : "";
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.select-simple');
    }
}
