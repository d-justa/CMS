<x-layouts.admin>
    <form action="{{ route('users.update', $user->id) }}" method="post">
        @method('put')
        @csrf

        <flux:separator />

        <flux:fieldset>
            <flux:legend>Roles</flux:legend>

            <flux:description>Choose the roles.</flux:description>

            <div class="flex gap-4 *:gap-x-2">
                @foreach ($roles as $role)
                @php
                    $checked = $user->hasRole($role->name);
                @endphp
                    <flux:checkbox :checked="$checked" value="{{ $role->name }}" label="{{ $role->name }}" name="roles[]" />
                @endforeach
            </div>
        </flux:fieldset>
        <flux:button type="submit" variant="primary">Update</flux:button>
    </form>
</x-layouts.admin>
