<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public string $type;
    public ?string $name;
    public ?string $label;
    public ?string $id;
    public ?string $value;
    public ?string $placeholder;
    public bool $required;
    public ?string $class;
    public ?string $wrapperClass;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type = 'text',
        ?string $name = null,
        ?string $label = null,
        ?string $id = null,
        ?string $value = null,
        ?string $placeholder = null,
        bool $required = false,
        ?string $class = '',
        ?string $wrapperClass = '',
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->id = $id ?? $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->class = $class;
        $this->wrapperClass = $wrapperClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.form.input');
    }
}
