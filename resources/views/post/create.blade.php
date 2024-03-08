<x-modal title="{{ __('Create new post') }}" wire:model="addPost" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <x-validation-errors/>
        <p class="italic text-sm text-red-700 m-0">
            {{ __('Fields marked with * are required') }}
        </p>

        <div>
            <x-input-label for="title">{{ __('Title') }} *</x-input-label>
            <x-text-input id="title" class="block mt-1 w-full" type="text"
                name="title" :value="old('title')" wire:model="title"
                autocomplete="off" maxlength="150" required />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
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