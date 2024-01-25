<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Создать заявку') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-x">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Создание заявки') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Для создания заявки необходимо заполнить поля ниже.') }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('task.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')

                        <div class="max-w-xl">
                            <x-input-label for="cabinet" :value="__('Укажите кабинет')" />
                            <x-text-input id="cabinet" name="cabinet" type="text" class="mt-1 block w-full"
                                required autofocus autocomplete="cabinet" />
                        </div>

                        <div class="max-w-xl">
                            <x-input-label for="title" :value="__('Выберите проблему из списка')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                list="problems" required autocomplete="title" />
                            <datalist id="problems">
                                <option value="Неисправность проекторов или аудиовизуального оборудования">
                                <option value="Проблемы с доступом к электронным ресурсам">
                                <option value="Неисправность ноутбуков или компьютеров">
                                <option value="Необходимость обновления оборудования">
                                <option value="Неисправность принтеров или сканеров">
                                <option value="Проблемы с программным обеспечением">
                                <option value="Проблемы с подключением к сети">
                                <option value="Другое">
                            </datalist>
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Опишите проблему')" />
                            <x-textarea id="description" name="description" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="description" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Создать') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
