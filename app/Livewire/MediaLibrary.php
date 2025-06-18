<?php

namespace App\Livewire;

use App\Models\MediaItem;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class MediaLibrary extends Component
{
    use WithFileUploads;
 
    protected $queryString = [
        'currentFolderId' => ['except' => null],
    ];    
    public $search = '';
    public $newFolderName = '';
    public $UploadedFileName = '';
    public $currentFolderId = null;
    public $selectedItem = null;
    public $uploadFile;

    //method for creating file path
    private function buildFolderPath($folderId): string
    {
        $segments = [];
        while ($folderId) {
            $folder = MediaItem::find($folderId);
            if (!$folder) break;
            array_unshift($segments, $folder->name);
            $folderId = $folder->parent_id;
        }
        return implode('/', $segments);
    }

    public function uploadFiles()
    {
        $this->validate([
            'uploadFile' => 'required|file|max:10240',
            'UploadedFileName' => 'required|string|max:255|unique:media_items,name',
        ]);
        $folderPath = $this->buildFolderPath($this->currentFolderId);
        $storagePath = $folderPath ? 'media/' . $folderPath : 'media';

        $extension = $this->uploadFile->getClientOriginalExtension();
        $baseName = pathinfo($this->UploadedFileName, PATHINFO_FILENAME);
        $fileName = $baseName . '.' . $extension;

        // Step 3: Check uniqueness in current folder
        $fileExists = MediaItem::where('name', $fileName)
            ->where('parent_id', $this->currentFolderId)
            ->exists();

        if ($fileExists) {
            $fileName = $baseName . '_' . time() . '.' . $extension;
        }

        // Step 4: Store file with custom name
        $path = $this->uploadFile->storeAs($storagePath, $fileName, 'public');

        // Step 5: Save DB record
        MediaItem::create([
            'name'       => $this->UploadedFileName,
            'type'       => 'file',
            'parent_id'  => $this->currentFolderId,
            'path'       => $path,
            'mime_type'  => $this->uploadFile->getMimeType(),
            'size'       => intval($this->uploadFile->getSize() / 1024),
            'user_id'    => Auth::id(),
        ]);

        // Step 6: Reset input and notify
        $this->reset(['uploadFile', 'UploadedFileName']);
        Flux::modal('upload-file-modal')->close();
    }

    //showing properties of folder or file
    public function show($id)
    {
        $this->selectedItem = MediaItem::find($id);
    }

    //opening a folder
    public function openFolder($folderId)
    {
        $this->selectedItem = null;
        $this->currentFolderId = $folderId;
    }

    //going back to the parent folder
    public function goBack()
    {
        if ($this->currentFolderId) {
            $parent = MediaItem::find($this->currentFolderId)?->parent_id;
            $this->currentFolderId = $parent;
            $this->selectedItem = null;
        }
    }

    //creating a new folder
    public function createFolder()
    {

        $this->validate([
            'newFolderName' => 'unique:media_items,name|required|string|max:255',
        ]);


        $folder = MediaItem::create([
            'name'       => $this->newFolderName,
            'type'       => 'folder',
            'parent_id'  => $this->currentFolderId ?? null,
            'path'       => null,
            'mime_type'  => null,
            'size'       => 0,
            'user_id'    => Auth::id(),
        ]);
        $this->newFolderName = '';
        Flux::modal('create-folder-modal')->close();
    }

    //deleting a item (folder or file)
    public function deleteItem($id)
    {
        $item = MediaItem::find($id);

        if ($item && $item->type === 'folder') {
            $folderPath = $this->buildFolderPath($id);
            if ($folderPath) {
                Storage::disk('public')->deleteDirectory('media/' . $folderPath);
            }
            $item->delete();
        } elseif ($item && $item->type === 'file') {
            Storage::disk('public')->delete($item->path);
            $item->delete();
        }
        $this->selectedItem = null;
    }

    public function getBreadcrumb()
    {
        $breadcrumb = [];
        $folderId = $this->currentFolderId;
        while ($folderId) {
            $folder = MediaItem::find($folderId);
            if (!$folder) break;
            array_unshift($breadcrumb, $folder);
            $folderId = $folder->parent_id;
        }
        return $breadcrumb;
    }


    //rendering the view
    public function render()
    {
        $this->authorize('viewAny', MediaItem::class);
        return view('livewire.media-library', [
            'items' => MediaItem::when($this->search == null, fn($q) => $q->where('parent_id', $this->currentFolderId))
                ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                ->orderBy('type', 'desc')
                ->orderBy('name')
                ->paginate(20),
            'breadcrumbs' => $this->getBreadcrumb()
        ]);
    }
}
