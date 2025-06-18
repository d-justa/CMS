<x-layouts.admin>
    <div x-data="{ tab: @js($defaultTab) }" class="w-full mx-auto mt-10">
        <!-- Tab Navigation -->
        <div class="flex space-x-10 mb-6">
            @can('updateGeneralSettings', App\Models\SiteSetting::class)
                <button @click="tab = 'general'" :class="tab === 'general' ? 'tab-active' : 'text-gray-600'" class="tab">
                    <i class="fas fa-cog"></i>
                    <span class="font-semibold">General</span>
                </button>
            @endcan

            @can('updateContactSettings', App\Models\SiteSetting::class)
                <button @click="tab = 'contact'" :class="tab === 'contact' ? 'tab-active' : 'text-gray-600'" class="tab">
                    <i class="fas fa-address-book"></i>
                    <span class="font-semibold">Contact</span>
                </button>
            @endcan

            @can('updateAdvancedSettings', App\Models\SiteSetting::class)
                <button @click="tab = 'advance'" :class="tab === 'advance' ? 'tab-active' : 'text-gray-600'"
                    class="tab">
                    <i class="fas fa-sliders-h"></i>
                    <span class="font-semibold">Advanced</span>
                </button>
            @endcan
        </div>

        <!-- Tab Contents -->
        <div x-show="tab === 'general'" x-transition>
            <form action="{{ route('site-settings.update.general') }}" method="post"
                class="bg-white p-6 rounded shadow-md">
                @csrf
                @method('put')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input name="site_title" label="Site Title"
                        :value="old('site_title', config('settings.site_title'))" />
                    <flux:input name="site_tag_line" label="Site Tag Line"
                        :value="old('site_title', config('settings.site_tag_line'))" />
                </div>
                <div class="mt-6">
                    <flux:button type="submit" variant="primary">Update</flux:button>
                </div>
            </form>
        </div>

        <!-- Contact Tab Content -->
        <div x-show="tab === 'contact'" x-transition class="p-6 bg-white rounded shadow-md space-y-6">
            <form action="{{ route('site-settings.update.contact') }}" method="post">
                @csrf
                @method('put')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <flux:input name="primary_email" label="Primary Email Address"
                        :value="old('primary_email', config('settings.primary_email'))" />
                    <flux:input name="secondary_email" label="Secondary Email Address"
                        :value="old('secondary_email', config('settings.secondary_email'))" />
                    <flux:input name="primary_phone" label="Primary Contact Number"
                        :value="old('primary_phone', config('settings.primary_phone'))" />
                    <flux:input name="secondary_phone" label="Support/Helpline Number"
                        :value="old('secondary_phone', config('settings.secondary_phone'))" />
                </div>

                <flux:separator />

                <h3 class="text-lg font-semibold text-gray-700 mt-4">Address Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                    <flux:input name="street_address1" label="Street Address 1"
                        :value="old('street_address1', config('settings.street_address1'))" />
                    <flux:input name="street_address2" label="Street Address 2" badge="optional"
                        :value="old('street_address2', config('settings.street_address2'))" />
                    <flux:input name="city" label="City" :value="old('city', config('settings.city'))" />
                    <flux:input name="state" label="State" :value="old('state', config('settings.state'))" />
                    <flux:input name="zip_code" label="ZIP / Postal Code"
                        :value="old('zip_code', config('settings.zip_code'))" />
                    <flux:input name="country" label="Country" :value="old('country', config('settings.country'))" />
                </div>

                <div class="col-span-2 mb-6 mt-4">
                    <flux:textarea name="contact_map_iframe" label="Google Map Embed Iframe" badge="optional"
                        rows="4" />
                </div>


                <div class="mt-6">
                    <flux:button type="submit" variant="primary">Update Contact Details</flux:button>
                </div>
            </form>
        </div>


        <div x-show="tab === 'advance'" class="p-6 bg-white rounded shadow-md">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Security Controls</h2>

            <form action="{{ route('site-settings.update.advanced') }}" method="post"
                class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('put')

                <flux:checkbox name="disable_interactions" label="Disable interactions"
                    description="Prevent Copy, Paste, Context Menu, Dev Tools"
                    :checked="config('settings.disable_interactions') == true" />

                <div class="flex items-start space-x-2">
                    <flux:checkbox name="disable_form_autocomplete" label="Disable Form Autocomplete"
                        :checked="config('settings.disable_form_autocomplete') == true" />
                </div>

                <div class="col-span-1 md:col-span-2">
                    <flux:button type="submit" variant="primary">Update</flux:button>
                </div>
            </form>
        </div>



    </div>



</x-layouts.admin>
