<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class PostList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $showPostFormModal = false;
    public $editingPostId = null;

    protected $listeners = ['postSaved' => 'refreshPosts', 'postDeleted' => 'refreshPosts', 'closePostFormModal' => 'closeModal'];

    /**
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $posts = Post::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('excerpt', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.pages.post-list', [
            'posts' => $posts,
        ]);
    }

    /**
     * Opens the post creation modal.
     *
     * @return void
     */
    public function createPost()
    {
        $this->editingPostId = null;
        $this->showPostFormModal = true;
        $this->dispatch('openPostFormModal');
    }

    /**
     * Opens the post editing modal.
     *
     * @param int $postId
     * @return void
     */
    public function editPost(int $postId)
    {
        $this->editingPostId = $postId;
        $this->showPostFormModal = true;
        $this->dispatch('openPostFormModal', postId: $postId);
    }

    /**
     * Deletes a post.
     *
     * @param int $postId
     * @return void
     */
    public function deletePost(int $postId)
    {
        Post::destroy($postId);
        session()->flash('message', 'Post deleted successfully.');
        $this->refreshPosts();
    }

    /**
     * Refreshes the post list after a save or delete operation.
     *
     * @return void
     */
    public function refreshPosts()
    {
        $this->showPostFormModal = false;
        $this->resetPage();
    }

    /**
     * Closes the page form modal.
     *
     * @return void
     */
    public function closeModal()
    {
        $this->showPostFormModal = false;
    }
}
