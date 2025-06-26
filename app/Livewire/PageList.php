<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class PageList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $showPageFormModal = false;
    public $editingPageId = null;

    protected $listeners = ['pageSaved' => 'refreshPages', 'closePageFormModal' => 'closeModal'];

    /**
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $pages = Page::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.pages.page-list', [
            'pages' => $pages,
        ]);
    }

    /**
     * Opens the page creation modal.
     *
     * @return void
     */
    public function createPage()
    {
        $this->editingPageId = null;
        $this->showPageFormModal = true;
        $this->dispatch('openPageFormModal');
    }

    /**
     * Opens the page editing modal.
     *
     * @param int $pageId
     * @return void
     */
    public function editPage(int $pageId)
    {
        $this->editingPageId = $pageId;
        $this->showPageFormModal = true;
        $this->dispatch('openPageFormModal', pageId: $pageId);
    }

    /**
     * Deletes a page.
     *
     * @param int $pageId
     * @return void
     */
    public function deletePage(int $pageId)
    {
        Page::destroy($pageId);
        session()->flash('message', 'Page deleted successfully.');
        $this->refreshPages();
    }

    /**
     * Refreshes the page list after a save or delete operation.
     *
     * @return void
     */
    public function refreshPages()
    {
        $this->showPageFormModal = false;
        $this->resetPage();
    }

    /**
     * Closes the page form modal.
     *
     * @return void
     */
    public function closeModal()
    {
        $this->showPageFormModal = false;
    }
}
