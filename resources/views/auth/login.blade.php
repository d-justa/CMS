<x-layouts.auth>
    <div class="border border-zinc-800 dark:border-white p-6 min-w-[30vw] rounded-2xl">
        <div class="flex items-center mb-6">
            <div>
                <img src="{{ asset('logo.jpg') }}" alt="Logo" class="w-14 rounded-full">
            </div>
            <flux:separator vertical class="mx-4" />
            <div class="">
                <flux:heading level="1" size="lg">Login to your account</flux:heading>
                <flux:subheading>Welcome back!</flux:subheading>
            </div>
        </div>

        <form action="" method="post">
            @csrf
            <div class="space-y-6">
                <flux:input type="email" label="Email" name="email" />

                <flux:field>
                    <div class="flex justify-between mb-3">
                        <flux:label>Password</flux:label>
                        <a href="{{ route('password.request') }}" class="text-sm">Forgot Password?</a>
                    </div>
                    <flux:input type="password" name="password" viewable />
                    <flux:error name="password" />
                </flux:field>

                <flux:button type="submit" variant="primary" class="w-full">Login</flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <flux:separator text="OR" class="my-6" />

            <div class="text-center text-sm">
                <a href="{{ route('register') }}">Sign up for a new account</a>
            </div>
        @endif
    </div>

</x-layouts.auth>
