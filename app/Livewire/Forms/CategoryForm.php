<?php

namespace App\Livewire\Forms;

use App\Livewire\CategoryList;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryForm extends Component
{
    public $categoryId;
    public $name;
    public $slug;

    protected $listeners = ['openCategoryFormModal' => 'loadCategory'];

    /**
     * Mount the component.
     *
     * @param int|null $categoryId
     * @return void
     */
    public function mount(?int $categoryId = null)
    {
        if ($categoryId) {
            $this->categoryId = $categoryId;
            $this->loadCategory($categoryId);
        } else {
            $this->reset(['name', 'slug']);
        }
    }

    /**
     * Load category data for editing.
     *
     * @param int|null $categoryId
     * @return void
     */
    public function loadCategory(?int $categoryId = null)
    {
        if ($categoryId) {
            $category = Category::findOrFail($categoryId);
            $this->name = $category->name;
            $this->slug = $category->slug;
        } else {
            $this->reset(['name', 'slug']);
        }
    }

    /**
     * Real-time validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|string|max:255|unique:categories,name',
        'slug' => 'required|string|max:255|unique:categories,slug',
    ];

    /**
     * Updated hook for real-time slug generation.
     *
     * @param string $propertyName
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'name') {
            $this->slug = Str::slug($this->name);
        }
    }

    /**
     * Save or update the category.
     *
     * @return void
     */
    public function saveCategory()
    {
        $this->rules['name'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('categories', 'name')->ignore($this->categoryId),
        ];
        $this->rules['slug'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('categories', 'slug')->ignore($this->categoryId),
        ];

        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
        ];

        if ($this->categoryId) {
            Category::findOrFail($this->categoryId)->update($data);
        } else {
            Category::create($data);
        }

        session()->flash('message', 'Category ' . ($this->categoryId ? 'updated' : 'created') . ' successfully.');

        $this->dispatch('categorySaved')->to(CategoryList::class);
        $this->dispatch('closeCategoryFormModal');
    }

    /**
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.forms.category-form');
    }
}
