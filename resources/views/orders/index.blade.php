<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('navigation.tasks') }}
            </h2>
            @if (Auth::user()->isWorker())
                @if (session('status') === 'task-added')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                       class="text-sm text-gray-600 dark:text-gray-400">{{ __('Task added.') }}</p>
                @endif
                <x-secondary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-new-task')">
                    {{ __('Add new task') }}
                </x-secondary-button>
            @endif
        </div>
    </x-slot>

    <x-modal name="add-new-task" focusable>
        <div class="p-6">
            <header>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Create task') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('To create a task, fill in the fields below.') }}
                </p>
            </header>
            <form method="post" action="{{ route('task.store') }}" class="mt-6 space-y-6">
                @csrf
                @method('post')

                <div class="max-w-xl">
                    <x-input-label for="username" :value="__('Specify the name client')" />
                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" required
                                  autofocus autocomplete="username" />
                </div>

                <div class="max-w-xl">
                    <x-input-label for="type_work" :value="__('Specify the type of work')" />
                    <x-text-input id="type_work" name="type_work" type="text" class="mt-1 block w-full" list="type_works"
                                  required autocomplete="type_work" />
                    <datalist id="type_works">
                        <option value="Изготовление импланта">
                        <option value="Изготовление протезов">
                        <option value="Изготовление виниров">
                        <option value="Изготовление циркониевых коронок">
                        <option value="Изготовление керамических накладок">
                        <option value="Другое">
                    </datalist>
                </div>

                <div class="max-w-xl">
                    <x-input-label for="summ_order" :value="__('Specify a sum')" />
                    <x-text-input id="summ_order" name="summ_order" type="text" class="mt-1 block w-full" required
                                  autofocus autocomplete="summ_order" />
                </div>

                <div class="max-w-xl">
                    <x-input-label for="executor" :value="__('Specify the responsible persons')" />
                    <x-text-input id="executor" name="executor" type="text" class="mt-1 block w-full" list="name_persons"
                                  required autocomplete="executor" />
                    <datalist id="name_persons">
                        <option value="Ваня Петров">
                        <option value="Саша Иванов">
                        <option value="Данил Сергеев">
                        <option value="Асылбек Ратов">
                        <option value="Дмитрий Иванов">
                        <option value="Сергей Смирнов">
                        <option value="Анатолий Дягелев">
                    </datalist>
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Create') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
