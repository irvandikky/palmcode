<?php

namespace App\Livewire\Forms;

use App\Livewire\PageList;
use App\Models\Page;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageForm extends Component
{
    public $pageId;
    public $title;
    public $slug;
    public $body;
    public $status = 'draft';

    protected $listeners = ['openPageFormModal' => 'loadPage'];

    /**
     * Mount the component.
     *
     * @param int|null $pageId
     * @return void
     */
    public function mount(?int $pageId = null)
    {
        if ($pageId) {
            $this->pageId = $pageId;
            $this->loadPage($pageId);
        } else {
            $this->reset(['title', 'slug', 'body', 'status']);
            $this->status = 'draft';
        }
    }

    /**
     * Load page data for editing.
     *
     * @param int|null $pageId
     * @return void
     */
    public function loadPage(?int $pageId = null)
    {
        if ($pageId) {
            $page = Page::findOrFail($pageId);
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->body = $page->body;
            $this->status = $page->status;
        } else {
            $this->reset(['title', 'slug', 'body', 'status']);
            $this->status = 'draft';
        }
    }

    /**
     * Real-time validation rules.
     *
     * @var array
     */
    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:pages,slug',
        'body' => 'nullable|string',
        'status' => 'required|in:draft,published',
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

        if ($propertyName === 'title') {
            $this->slug = Str::slug($this->title);
        }
    }

    /**
     * Save or update the page.
     *
     * @return void
     */
    public function savePage()
    {
        $this->rules['slug'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('pages', 'slug')->ignore($this->pageId),
        ];

        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'status' => $this->status,
        ];

        if ($this->pageId) {
            Page::findOrFail($this->pageId)->update($data);
        } else {
            Page::create($data);
        }

        session()->flash('message', 'Page ' . ($this->pageId ? 'updated' : 'created') . ' successfully.');

        $this->dispatch('pageSaved')->to(PageList::class);
        $this->dispatch('closePageFormModal');
    }

    /**
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.forms.page-form');
    }
}
