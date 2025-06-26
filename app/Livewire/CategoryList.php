<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class CategoryList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $showCategoryFormModal = false;
    public $editingCategoryId = null;

    protected $listeners = ['categorySaved' => 'refreshCategories', 'closeCategoryFormModal' => 'closeModal'];

    /**
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.pages.category-list', [
            'categories' => $categories,
        ]);
    }

    /**
     * Opens the category creation modal.
     *
     * @return void
     */
    public function createCategory()
    {
        $this->editingCategoryId = null;
        $this->showCategoryFormModal = true;
        $this->dispatch('openCategoryFormModal');
    }

    /**
     * Opens the category editing modal.
     *
     * @param int $categoryId
     * @return void
     */
    public function editCategory(int $categoryId)
    {
        $this->editingCategoryId = $categoryId;
        $this->showCategoryFormModal = true;
        $this->dispatch('openCategoryFormModal', categoryId: $categoryId);
    }

    /**
     * Deletes a category.
     *
     * @param int $categoryId
     * @return void
     */
    public function deleteCategory(int $categoryId)
    {
        Category::destroy($categoryId);
        session()->flash('message', 'Category deleted successfully.');
        $this->refreshCategories();
    }

    /**
     * Refreshes the category list after a save or delete operation.
     *
     * @return void
     */
    public function refreshCategories()
    {
        $this->showCategoryFormModal = false;
        $this->resetPage();
    }

    /**
     * Closes the page form modal.
     *
     * @return void
     */
    public function closeModal()
    {
        $this->showCategoryFormModal = false;
    }
}
