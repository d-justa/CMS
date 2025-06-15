<x-layouts.admin>
    <form action="" method="post">
        @csrf
        @method('put')
        <div class="grid grid-cols-3 gap-4">
            <flux:input name="site_title" label="Site Title" />
            <flux:input name="site_tag_line" label="Site Tag Line" />
        </div>

        <flux:button type="submit" variant="primary">Update</flux:button>
    </form>
</x-layouts.admin>