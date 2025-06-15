<x-layouts.admin>
    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="space-y-8 mx-auto">
        @csrf
        @method('PUT')

        {{-- Role Name Input --}}
        <div>
            <flux:input name="name" label="Name" value="{{ old('name', $role->name) }}" class="w-full" />
        </div>

        <flux:separator />

        {{-- Permissions Group --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($permissionGroups as $groupName => $permissions)
                <div class="bg-white shadow rounded-lg p-5 border">
                    <flux:checkbox.group :label="Str::title($groupName)">
                        <div class="flex flex-col space-y-2 mt-2">
                            @foreach ($permissions as $permission)
                                @php
                                    $checked = $role->hasPermissionTo($permission);
                                @endphp
                                <flux:checkbox label="{{ Str::title($permission->name) }}"
                                    value="{{ $permission->name }}" name="permissions[]" :checked="$checked" />
                            @endforeach
                        </div>
                    </flux:checkbox.group>
                </div>
            @endforeach
        </div>

        {{-- Submit Button --}}
        <div class="pt-4">
            <flux:button type="submit" variant="primary" class="w-full md:w-auto">
                Update
            </flux:button>
        </div>
    </form>
</x-layouts.admin>
