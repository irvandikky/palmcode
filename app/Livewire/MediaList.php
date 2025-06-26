<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class MediaList extends Component
{
    public $file;
    public $files = [];

    use WithFileUploads;

    /**
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.pages.media-list');
    }

    /**
     * Retrieve existing media files.
     *
     * @return void
     */
    public function mount()
    {
        $this->getFiles();
    }

    /**
     * Handles file upload and refreshes the file list.
     *
     * @return void
     */
    public function upload()
    {
        $this->validate([
            'file' => 'image|max:1024',
        ]);

        $originalName = time() . '-' . $this->file->getClientOriginalName();
        $this->file->storeAs('image', $originalName, 'public');
        $this->file = null;
        $this->getFiles();
    }

    /**
     * Handles file upload and refreshes the file list.
     *
     * @return void
     */

    public function updatedFile()
    {
        $this->upload();
    }

    /**
     * Deletes the given file and refreshes the file list.
     *
     * @param string $filePath
     * @return void
     */
    public function delete($filePath)
    {
        Storage::disk('public')->delete($filePath);
        $this->getFiles();
    }

    /**
     * Retrieves all media files from the 'image' directory.
     *
     * @return void
     */
    private function getFiles()
    {
        $this->files = collect(Storage::disk('public')->files('image'))->sortDesc()->toArray();
    }
}
