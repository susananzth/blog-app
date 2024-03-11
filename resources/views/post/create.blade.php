<x-modal title="{{ __('Create new post') }}" wire:model="addPost" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <x-validation-errors/>
        <p class="italic text-sm text-red-700 m-0">
            {{ __('Fields marked with * are required') }}
        </p>

        <div>
            <x-input.label for="title">{{ __('Title') }} *</x-input.label>
            <x-input.text id="title" class="block mt-1 w-full" type="text"
                name="title" :value="old('title')" wire:model="title"
                autocomplete="off" maxlength="150" required />
            <x-input.message-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div>
            <x-input.label for="image">{{ __('Image') }}</x-input.label>
            <x-input.file id="image" type="file" name="image" wire:model="image" required />
            <p class="mt-0 text-xs text-gray-500">PNG, JPG o JPEG (MAX. 4MB).</p>
            <x-input.message-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <div>
            <x-input.label for="body">{{ __('Content') }} *</x-input.label>
            <x-input.textarea id="body" name="body" :value="old('body')" 
                wire:model="body" autocomplete="off" required></x-input.textarea>
            <x-input.message-error :messages="$errors->get('body')" class="mt-2" />
        </div>

        <div>
            <x-input.label for="status">{{ __('Status') }} *</x-input.label>
            <x-input.select id="status" class="block mt-1 w-full" 
                name="status" wire:model="status" required>
                <option value="">{{ __('Please select') }}</option>
                <option value="0" {{ (old('status') == false) ? 'selected' : '' }}>{{ __('Created') }}</option>
                <option value="1" {{ (old('status') == true) ? 'selected' : '' }}>{{ __('Published') }}</option>
            </x-input.select>
            <x-input.message-error :messages="$errors->get('status')" class="mt-2" />
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