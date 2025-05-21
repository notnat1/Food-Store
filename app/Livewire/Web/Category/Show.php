<?php

namespace App\Livewire\Web\Category;

use Livewire\Component;
use App\Models\Category;

class Show extends Component
{
    /**
     * slug
     *
     * @var mixed
     */
    public $slug;
    
    /**
     * mount
     *
     * @param  mixed $slug
     * @return void
     */
    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        //get category
        $category = Category::query()
            ->with('products')
            ->where('slug', $this->slug)
            ->firstOrFail();

        return view('livewire.web.category.show', compact('category'));
    }
}