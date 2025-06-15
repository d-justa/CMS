<x-layouts.admin>
    <form action="{{ route('roles.store') }}" method="POST" class="space-y-8 mx-auto">
        @csrf

        {{-- Role Name Input --}}
        <div>
            <flux:input name="name" label="Name" class="w-full" />
        </div>

        <flux:separator />

        {{-- Permissions Group --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($permissionGroups as $key => $permissions)
                <div class="bg-white shadow rounded-lg p-5 border">
                    <flux:checkbox.group :label="Str::title($key)">
                        <div class="flex flex-col space-y-2 mt-2">
                            @foreach ($permissions as $permission)
                                <flux:checkbox label="{{ Str::title($permission->name) }}"
                                    value="{{ $permission->name }}" />
                            @endforeach
                        </div>
                    </flux:checkbox.group>
                </div>
            @endforeach
        </div>

        {{-- Submit Button --}}
        <div class="pt-4">
            <flux:button type="submit" variant="primary" class="w-full md:w-auto">
                Save
            </flux:button>
        </div>
    </form>
</x-layouts.admin>
