<x-slot name="header">
    <x-title-list icon="blog">{{ __('Posts') }}</x-title-list>
</x-slot>

<div class="max-w-7xl py-6 mx-auto sm:px-4 lg:px-6 space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-secondary-800 shadow sm:rounded-lg">
        <x-session-status/>
        <div class="flex flex-col">
            <div class="inline-block min-w-full">
                <x-primary-button type="button" wire:click="create()" class="mb-2">
                    <i class="fa-solid fa-plus me-1"></i>{{ __('Create Post') }}
                </x-primary-button>
                <div class="rounded overflow-x-auto">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b bg-secondary-800 font-medium text-white dark:border-secondary-500 dark:bg-secondary-900">
                            <tr>
                                <x-table-th title="{{ __('Title') }}" />
                                <x-table-th title="{{ __('Author') }}" />
                                <x-table-th title="{{ __('Status') }}" />
                                <th scope="col" class="px-6 py-4">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                            <tr
                                class="border-b transition duration-300 ease-in-out hover:bg-secondary-100 dark:border-secondary-500 dark:hover:bg-secondary-600">
                                <x-table-td>{{ $post->title }}</x-table-td>
                                <x-table-td>{{ $post->user->first_name }} {{ $post->user->last_name }}</x-table-td>
                                <x-table-td>
                                    @if ($post->status == true)
                                    <x-bag color="bg-green-400">{{ __('Published') }}</x-bag>
                                    @else
                                    <x-bag color="bg-gray-400">{{ __('Created') }}</x-bag>
                                    @endif</x-table-td>
                                <x-table-td>
                                    <x-table-buttons id="{{ $post->id }}" />
                                </x-table-td>
                            </tr>
                            @empty
                            <x-table-empty />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
        @if($addPost)
            @include('post.create')
        @endif
        @if($updatePost)
            @include('post.edit')
        @endif
        @if($deletePost)
            <x-table-modal-delete model="deletePost" />
        @endif
    </div>
</div>