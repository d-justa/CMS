<x-layouts.auth>
    <div class="border border-zinc-800 dark:border-white p-6 min-w-[30vw] rounded-2xl">
        <div class="flex items-center mb-6">
            <div>
                <img src="{{ asset('logo.jpg') }}" alt="Logo" class="w-14">
            </div>
            <flux:separator vertical class="mx-4" />
            <div class="">
                <flux:heading level="1" size="lg">Forgot Password?</flux:heading>
                <flux:subheading>We got you covered!</flux:subheading>
            </div>
        </div>

        <form action="" method="post">
            @csrf
            <div class="space-y-6">
                <flux:input type="email" label="Email" name="email" />

                <flux:button type="submit" variant="primary" class="w-full">Send Email</flux:button>
            </div>
        </form>
    </div>

</x-layouts.auth>
