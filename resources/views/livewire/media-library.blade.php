<div>
    <div class="flex  flex-col md:flex-row w-full p-4 space-x-4 border rounded border-gray-200">
        <div class="w-full md:w-3/4 space-y-4">
            <div class="flex flex-col md:flex-row md:justify-between  items-center">
                <div class="flex gap-3">
                    @if ($currentFolderId)
                        <flux:button wire:click="goBack" class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </flux:button>
                    @endif
                    <flux:heading size="xl">Media Library</flux:heading>
                </div>

                <div class="flex gap-2">
                    <div>
                        <flux:input placeholder="Search..." wire:model.live.debounce.500ms="search" />
                    </div>
                    @can('create', \App\Models\MediaItem::class)
                        <flux:modal.trigger name="create-folder-modal">
                            <flux:button icon="folder-plus" variant="primary" class="cursor-pointer">New Folder
                            </flux:button>
                        </flux:modal.trigger>

                        <flux:modal.trigger name="upload-file-modal">
                            <flux:button wire:click="" icon="arrow-up-tray" variant="filled" class="cursor-pointer">
                                Upload File
                            </flux:button>
                        </flux:modal.trigger>
                    @endcan
                </div>
            </div>
            <div>
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="#" icon="home" wire:click="openFolder(null)" />
                    @foreach ($breadcrumbs as $breadcrumb)
                        <flux:breadcrumbs.item class="cursor-pointer" wire:click="openFolder({{ $breadcrumb->id }})">
                            {{ $breadcrumb->name }}
                        </flux:breadcrumbs.item>
                    @endforeach
                </flux:breadcrumbs>

            </div>


            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 relative">
                <div wire:loading wire:target="openFolder"
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white/60 z-10">
                    <flux:icon.loading class="w-6 h-6 text-gray-600" />
                </div>
                @if ($items->isEmpty())
                    <div class="flex items-center justify-center col-span-full p-4">
                        <p>This folder is empty.</p>
                    </div>
                @endif
                @foreach ($items as $item)
                    <div x-data="{ clickTimeout: null }"
                        @click="
                    clearTimeout(clickTimeout);
                    clickTimeout = setTimeout(() => { $wire.show({{ $item->id }}) }, 250);
                "
                        @dblclick="
                    clearTimeout(clickTimeout);
                    @if ($item->type === 'folder')
$wire.openFolder({{ $item->id }});
@endif
                "
                        class="border rounded p-4 cursor-pointer hover:bg-gray-100 text-center shadow-sm flex flex-col items-center space-y-2">
                        @if ($item->type === 'folder')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                            </svg>
                            <div class="text-sm font-semibold truncate w-full">{{ $item->name }}</div>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M7 2h6l5 5v13a2 2 0 01-2 2H7a2 2 0 01-2-2V4a2 2 0 012-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 2v6h6" />
                            </svg>

                            <div class="text-sm font-medium truncate w-full">{{ $item->name }}</div>
                            <div class="text-xs text-gray-500 truncate w-full">{{ $item->mime_type }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div>
                {{ $items->links() }}
            </div>

        </div>
        <div class="w-full md:w-1/4 mb-4 md:border-l border-gray-200 relative">
            <div wire:loading wire:target="show"
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white/60 z-10">
                <flux:icon.loading class="w-6 h-6 text-gray-600" />
            </div>

            <div class="flex justify-center border-gray-200">
                <flux:heading size="xl">Properties</flux:heading>
            </div>
            <div>
                @if ($selectedItem)
                    <div class="w-full max-w-md mx-auto">
                        <div class="space-y-4 p-4">
                            <flux:heading size="lg">
                                {{ $selectedItem->name }}
                            </flux:heading>
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                                <flux:text class="font-medium">Type:</flux:text>
                                <flux:text>{{ ucfirst($selectedItem->type) }}</flux:text>
                                @if ($selectedItem->type === 'file')
                                    <flux:text class="font-medium">MIME Type:</flux:text>
                                    <flux:text>{{ $selectedItem->mime_type }}</flux:text>
                                    <flux:text class="font-medium">Size:</flux:text>
                                    <flux:text>{{ number_format($selectedItem->size, 2) }} KB</flux:text>
                                    <div class="col-span-2 pt-4">
                                        <img src="{{ asset('storage/' . $selectedItem->path) }}" alt="Preview"
                                            class="rounded border w-full max-h-64 object-contain">
                                    </div>
                                    <div class="col-span-2">
                                        <flux:input type="text"
                                            value="{{ asset('storage/' . $selectedItem->path) }}" readonly
                                            class="w-full" copyable size="sm" />
                                    </div>
                                @endif
                                <flux:text class="font-medium">Created:</flux:text>
                                <flux:text>{{ $selectedItem->created_at->format('d M Y, H:i') }}</flux:text>
                            </div>
                        </div>
                        @can('delete', $selectedItem)
                            <div class="flex justify-end mt-4">
                                <flux:button wire:click="deleteItem({{ $selectedItem->id }})" class="cursor-pointer"
                                    variant="danger">Delete
                                </flux:button>
                            </div>
                        </div>
                    @endcan
                @endif
            </div>
        </div>
    </div>
    <flux:modal name="create-folder-modal" class="md:w-96">
        <div class="space-y-6">
            <flux:heading size="lg">Create Folder</flux:heading>
            <flux:input label="Folder Name" placeholder="Enter folder name" wire:model="newFolderName" />
            <flux:button wire:click="createFolder" variant="primary" class="w-full cursor-pointer">
                Save
            </flux:button>
        </div>
    </flux:modal>

    <flux:modal name="upload-file-modal" class="md:w-96">
        <div class="space-y-6">
            <flux:heading size="lg">Upload File</flux:heading>
            <flux:input type="file" label="Choose File" wire:model="uploadFile" class="w-full" />
            <flux:input placeholder="File name" label="File Name" wire:model="UploadedFileName" class="w-full" />
            <flux:button wire:click="uploadFiles" variant="primary" class="w-full">
                Upload
            </flux:button>
        </div>
    </flux:modal>

</div>
