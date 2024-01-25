<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{-- {{ __('navigation.projects') }} --}}
                {{ $prrojectInfo = App\Models\Project::where('id', $project_id)->get()[0]['name'] }}
                @if (Auth::user()->isAdmin())
                    <x-secondary-button x-data="" class="ml-4"
                        x-on:click.prevent="$dispatch('open-modal', 'edit-project')">
                        {{ __('Settings') }}
                    </x-secondary-button>
                @endif
            </h2>
            <x-secondary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'project-update-{{ $project_id }}')">
                {{ __('Add new card') }}
            </x-secondary-button>
        </div>
    </x-slot>

    <x-modal name="project-update-{{ $project_id }}" focusable>
        <form method="post" action="{{ route('projtask.addcard', $project_id) }}" class="p-6">
            @csrf
            @method('post')

            <div class="mt-6">
                <x-input-label for="text" value="{{ __('text') }}" class="sr-only" />

                <x-textarea id="text" name="text" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Card text') }}" required />
            </div>

            <div class="mt-6">
                <x-input-label for="status" value="{{ __('status') }}" class="sr-only" />

                <x-select id="status" name="status" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Card text') }}">
                    <option value="planned">{{ __('project.planned') }}</option>
                    <option value="progress">{{ __('project.progress') }}</option>
                    <option value="completed">{{ __('project.completed') }}</option>
                </x-select>
            </div>

            <x-secondary-button x-on:click="$dispatch('close')" class="mt-6">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-accept-button class="ml-3">
                {{ __('Add') }}
            </x-accept-button>
        </form>
    </x-modal>

    <x-modal name="edit-project" focusable>
        <form method="post" action="{{ route('projtask.destroy', $project_id) }}" class="p-6">
            @csrf
            @method('delete')

            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Вы действительно хотите завершить проект?</div>

            <x-secondary-button x-on:click="$dispatch('close')" class="mt-6">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-accept-button class="ml-4">
                {{ __('Ended') }}
            </x-accept-button>
        </form>
    </x-modal>

    <div class="w-full flex justify-between py-12" style="overflow: scroll">

        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-10">
                    <div class="mb-3 p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-4">
                            {{ __('project.planned') }}
                        </div>
                        @if (count($planned))
                            @foreach ($planned as $project)
                                <x-button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'projtask-update-{{ $project->projtask['id'] }}')">
                                    <div class="text-left p-4 text-gray-900 dark:text-gray-100">
                                        {{ $project->projtask['text'] }}
                                        <div class="flex justify-between gray">
                                            <span>
                                                {{ $project->projtask->user['name'] }}
                                            </span>
                                            <span class="line"></span>
                                            <span>
                                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->projtask['updated_at'])->locale(App::currentLocale())->isoFormat('dddd, D MMMM H:mm') }}
                                            </span>
                                        </div>
                                    </div>
                                </x-button>

                                <x-modal name="projtask-update-{{ $project->projtask['id'] }}" focusable>
                                    <form method="post"
                                        action="{{ route('projtask.update', ['project' => $project_id, 'projtask' => $project->projtask['id']]) }}"
                                        class="p-6">
                                        @csrf
                                        @method('patch')

                                        <div class="mt-6">
                                            <x-input-label for="status" value="{{ __($project->projtask['text']) }}"
                                                class="sr-only" />

                                            <x-select id="status" name="status" type="text"
                                                class="mt-1 block w-3/4" placeholder="{{ __('Card text') }}">
                                                <option value="planned">{{ __('project.planned') }}</option>
                                                <option value="progress">{{ __('project.progress') }}</option>
                                                <option value="completed">{{ __('project.completed') }}</option>
                                                <option value="deleted">{{ __('project.deleted') }}</option>
                                            </x-select>
                                        </div>

                                        <div class="mt-6 flex justify-between">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>

                                            <x-accept-button class="ml-3">
                                                {{ __('Update') }}
                                            </x-accept-button>

                                            {{-- <x-accept-button class="ml-3">
                                                    {{ __('Delete') }}
                                                </x-accept-button> --}}
                                        </div>
                                    </form>
                                </x-modal>
                            @endforeach
                        @else
                            <div class="flex justify-between gray">
                                <span>
                                    {{ __('Add a new card') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-10">
                    <div class="mb-3 p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-4">
                            {{ __('project.progress') }}
                        </div>
                        @if (count($progress))
                            @foreach ($progress as $project)
                                <x-button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'projtask-update-{{ $project->projtask['id'] }}')">
                                    <div class="text-left p-4 text-gray-900 dark:text-gray-100">
                                        {{ $project->projtask['text'] }}
                                        <div class="flex justify-between gray">
                                            <span>
                                                {{ $project->projtask->user['name'] }}
                                            </span>
                                            <span class="line"></span>
                                            <span>
                                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->projtask['updated_at'])->locale(App::currentLocale())->isoFormat('dddd, D MMMM H:mm') }}
                                            </span>
                                        </div>
                                    </div>
                                </x-button>

                                <x-modal name="projtask-update-{{ $project->projtask['id'] }}" focusable>
                                    <form method="post"
                                        action="{{ route('projtask.update', ['project' => $project_id, 'projtask' => $project->projtask['id']]) }}"
                                        class="p-6">
                                        @csrf
                                        @method('patch')

                                        <div class="mt-6">
                                            <x-input-label for="status" value="{{ __($project->projtask['text']) }}"
                                                class="sr-only" />

                                            <x-select id="status" name="status" type="text"
                                                class="mt-1 block w-3/4" placeholder="{{ __('Card text') }}">
                                                <option value="planned">{{ __('project.planned') }}</option>
                                                <option value="progress">{{ __('project.progress') }}</option>
                                                <option value="completed">{{ __('project.completed') }}</option>
                                                <option value="deleted">{{ __('project.deleted') }}</option>
                                            </x-select>
                                        </div>

                                        <div class="mt-6 flex justify-between">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>

                                            <x-accept-button class="ml-3">
                                                {{ __('Update') }}
                                            </x-accept-button>

                                            {{-- <x-accept-button class="ml-3">
                                                    {{ __('Delete') }}
                                                </x-accept-button> --}}
                                        </div>
                                    </form>
                                </x-modal>
                            @endforeach
                        @else
                            <div class="flex justify-between gray">
                                <span>
                                    {{ __('Add a new card') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-10">
                    <div class="mb-3 p-6 text-gray-900 dark:text-gray-100">
                        <div class="mb-4">
                            {{ __('project.completed') }}
                        </div>
                        @if (count($completed))
                            @foreach ($completed as $project)
                                <x-button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'projtask-update-{{ $project->projtask['id'] }}')">
                                    <div class="text-left p-4 text-gray-900 dark:text-gray-100">
                                        {{ $project->projtask['text'] }}
                                        <div class="flex justify-between gray">
                                            <span>
                                                {{ $project->projtask->user['name'] }}
                                            </span>
                                            <span class="line"></span>
                                            <span>
                                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->projtask['updated_at'])->locale(App::currentLocale())->isoFormat('dddd, D MMMM H:mm') }}
                                            </span>
                                        </div>
                                    </div>
                                </x-button>

                                <x-modal name="projtask-update-{{ $project->projtask['id'] }}" focusable>
                                    <form method="post"
                                        action="{{ route('projtask.update', ['project' => $project_id, 'projtask' => $project->projtask['id']]) }}"
                                        class="p-6">
                                        @csrf
                                        @method('patch')

                                        <div class="mt-6">
                                            <x-input-label for="status"
                                                value="{{ __($project->projtask['text']) }}" class="sr-only" />

                                            <x-select id="status" name="status" type="text"
                                                class="mt-1 block w-3/4" placeholder="{{ __('Card text') }}">
                                                <option value="planned">{{ __('project.planned') }}</option>
                                                <option value="progress">{{ __('project.progress') }}</option>
                                                <option value="completed">{{ __('project.completed') }}</option>
                                                <option value="deleted">{{ __('project.deleted') }}</option>
                                            </x-select>
                                        </div>

                                        <div class="mt-6 flex justify-between">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>

                                            <x-accept-button class="ml-3">
                                                {{ __('Update') }}
                                            </x-accept-button>

                                            {{-- <x-accept-button class="ml-3">
                                                    {{ __('Delete') }}
                                                </x-accept-button> --}}
                                        </div>
                                    </form>
                                </x-modal>
                            @endforeach
                        @else
                            <div class="flex justify-between gray">
                                <span>
                                    {{ __('Add a new card') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>


</x-app-layout>
