<?php

namespace App\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    public string $label;
    public string $name;
    public string $value;
    public bool $required;
    public ?string $placeholder;

    public function __construct($label, $name, $value = null, $required = false, $placeholder = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value != null ? $value : "";
        $this->required = $required;
        $this->placeholder = $placeholder;
    }

    public function render(): View|Closure|string
    {
        return view('components.inputs.text');
    }
}
