<x-modal title="{{ __('Create new category') }}" wire:model="addCategory" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <x-validation-errors/>
        <p class="italic text-sm text-red-700 m-0">
            {{ __('Fields marked with * are required') }}
        </p>

        <div>
            <x-input-label for="name">{{ __('Name') }} *</x-input-label>
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                name="name" :value="old('name')" wire:model="name"
                autocomplete="off" maxlength="100" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="image">{{ __('Image') }}</x-input-label>
            <x-input-file id="image" type="file" name="image" wire:model="image" />
            <p class="mt-0 text-xs text-gray-500">PNG, JPG o JPEG (MAX. 4MB).</p>
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <div class="flex justify-end gap-4">
            <x-primary-button type="button" wire:click.prevent="store()">
                <i class="fa-solid fa-save me-1"></i>{{ __('Save') }}
            </x-primary-button>
            <x-secondary-button wire:click.prevent="cancel()">
                <i class="fa-solid fa-ban me-1"></i>{{ __('Cancel') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>