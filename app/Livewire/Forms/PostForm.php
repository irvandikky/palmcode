<?php

namespace App\Livewire\Forms;

use App\Livewire\PostList;
use App\Models\Post;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PostForm extends Component
{
    use WithFileUploads;

    public $postId;
    public $title;
    public $slug;
    public $content;
    public $excerpt;
    public $image;
    public $currentImage;
    public $status = 'draft';
    public $published_at;
    public $selectedCategories = [];

    public $allCategories;

    protected $listeners = ['openPostFormModal' => 'loadPost'];

    /**
     * Mount the component.
     *
     * @param int|null $postId
     * @return void
     */
    public function mount(?int $postId = null)
    {
        $this->allCategories = Category::all();

        if ($postId) {
            $this->postId = $postId;
            $this->loadPost($postId);
        } else {
            $this->published_at = Carbon::now()->format('Y-m-d\TH:i');
        }
    }

    /**
     * Load post data for editing.
     *
     * @param int|null $postId
     * @return void
     */
    public function loadPost(?int $postId = null)
    {
        if ($postId) {
            $post = Post::findOrFail($postId);
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->content = $post->content;
            $this->excerpt = $post->excerpt;
            $this->currentImage = $post->image;
            $this->status = $post->status;
            $this->published_at = $post->published_at?->format('Y-m-d\TH:i');
            $this->selectedCategories = $post->categories->pluck('id')->toArray();
        } else {
            $this->reset(['title', 'slug', 'content', 'excerpt', 'image', 'currentImage', 'status', 'published_at', 'selectedCategories']);
            $this->status = 'draft';
            $this->published_at = Carbon::now()->format('Y-m-d\TH:i');
        }
    }

    /**
     * Real-time validation rules.
     *
     * @var array
     */
    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts,slug',
        'content' => 'nullable|string',
        'excerpt' => 'nullable|string|max:500',
        'image' => 'nullable|image|max:1024',
        'status' => 'required|in:draft,published',
        'published_at' => 'nullable|date',
        'selectedCategories' => 'nullable|array',
        'selectedCategories.*' => 'exists:categories,id',
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
     * Save or update the post.
     *
     * @return void
     */
    public function savePost()
    {
        $this->rules['slug'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('posts', 'slug')->ignore($this->postId),
        ];

        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'status' => $this->status,
            'published_at' => $this->status === 'published' ? Carbon::parse($this->published_at) : null,
        ];

        if ($this->image) {
            $originalName = time() . '-' . $this->image->getClientOriginalName();
            $data['image'] = $this->image->storeAs('image', $originalName, 'public');
        } elseif ($this->currentImage && !$this->image) {
            $data['image'] = $this->currentImage;
        } else {
            $data['image'] = null;
        }

        if ($this->postId) {
            $post = Post::findOrFail($this->postId);
            $post->update($data);
        } else {
            $post = Post::create($data);
        }

        $post->categories()->sync($this->selectedCategories);

        session()->flash('message', 'Post ' . ($this->postId ? 'updated' : 'created') . ' successfully.');

        $this->dispatch('postSaved')->to(PostList::class);
        $this->dispatch('closePostFormModal');
    }

    /**
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.forms.post-form');
    }
}
