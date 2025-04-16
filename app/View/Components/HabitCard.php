<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HabitCard extends Component
{
    public string $name;
    public string $category;
    public string $date;
    public int $id;

    public function __construct($name, $category, $date, $id)
    {
        $this->name = $name;
        $this->category = $category;
        $this->date = $date;
        $this->id = $id;
    }

    public function render()
    {
        return view('components.habit-card');
    }
}
