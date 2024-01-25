<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('navigation.projects') }}
            </h2>
            @if (Auth::user()->isAdmin())
                <x-secondary-button x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'create-project')">
                    {{ __('Add new project') }}
                </x-secondary-button>
            @endif
        </div>
    </x-slot>

    <x-modal name="create-project" focusable>
        <form class="p-6" method="POST" action="{{ route('project.store') }}">
            @csrf
            @method('post')

            <div class="max-w-xm">
                <x-input-label for="name" :value="__('Enter the name of the project')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus
                    autocomplete="title" placeholder="{{ __('The name is required.') }}" />
            </div>

            <div class="mt-3">
                <x-input-label for="description" :value="__('Enter the description of the project')" />
                <x-textarea id="description" name="description" type="text" class="mt-1 block w-full" autofocus
                    autocomplete="description" />
            </div>
            <div class="flex items-center gap-4 mt-6">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
            </div>
        </form>
    </x-modal>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach (App\Models\Project::where('status', 'active')->get() as $project)
                <a href="{{ route('project.show', $project['id']) }}">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <b>{{ $project['name'] }}</b>
                            {{ $project['description'] }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
