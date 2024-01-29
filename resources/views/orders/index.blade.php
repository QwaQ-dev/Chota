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
            <form method="post" action="{{ route('orders.store') }}" class="mt-6 space-y-6">
                @csrf
                @method('post')

                <div class="max-w-xl">
                    <x-input-label for="username" :value="__('Specify the name client')" />
                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" required
                                  autofocus autocomplete="username" />
                </div>

                <div class="max-w-xl">
                    <x-input-label for="type_work" :value="__('Specify the type of work')" />
                    <x-text-input id="typeworks" name="typeworks" type="text" class="mt-1 block w-full" list="typeworks"
                                  required autocomplete="typeworks" />
                    <datalist id="typeworks">
                        <option value="Изготовление импланта">
                        <option value="Изготовление протезов">
                        <option value="Изготовление виниров">
                        <option value="Изготовление циркониевых коронок">
                        <option value="Изготовление керамических накладок">
                        <option value="Другое">
                    </datalist>
                </div>

                <div class="max-w-xl">
                    <x-input-label for="type_work" :value="__('Выберите сырье со склада')" />
                    <x-text-input id="typeworks" name="typeworks" type="text" class="mt-1 block w-full" list="typeworks"
                                  required autocomplete="typeworks" />
                    <datalist id="typeworks">
                        <option value="Изготовление импланта">
                        <option value="Изготовление протезов">
                        <option value="Изготовление виниров">
                        <option value="Изготовление циркониевых коронок">
                        <option value="Изготовление керамических накладок">
                        <option value="Другое">
                    </datalist>
                </div>

                <div class="max-w-xl">
                    <x-input-label for="summ" :value="__('Specify a sum')" />
                    <x-text-input id="summ" name="summ" type="text" class="mt-1 block w-full" required
                                  autofocus autocomplete="summ" />
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


    @if (Auth::user()->isWorker())
        {{-- <a class="task_create p-2 fixed right-0 mb-0 w-16 rounded-full z-10 transition shadow bg-white dark:bg-gray-800"
            href="{{ route('task.create') }}">
            <img class="text-gray-900 dark:text-gray-100"
                src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4MDBweCIgaGVpZ2h0PSI4MDBweCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIj48cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTEyIDRDMTIuNTUyMyA0IDEzIDQuNDQ3NzIgMTMgNVYxMUgxOUMxOS41NTIzIDExIDIwIDExLjQ0NzcgMjAgMTJDMjAgMTIuNTUyMyAxOS41NTIzIDEzIDE5IDEzSDEzVjE5QzEzIDE5LjU1MjMgMTIuNTUyMyAyMCAxMiAyMEMxMS40NDc3IDIwIDExIDE5LjU1MjMgMTEgMTlWMTNINUM0LjQ0NzcyIDEzIDQgMTIuNTUyMyA0IDEyQzQgMTEuNDQ3NyA0LjQ0NzcyIDExIDUgMTFIMTFWNUMxMSA0LjQ0NzcyIDExLjQ0NzcgNCAxMiA0WiIgZmlsbD0iIzRmNDZlNSIvPjwvc3ZnPg==">
        </a> --}}
    @endif

    @if (!$orders)
        <div class="py-12">
            <div id="tasks" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-10">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between">{{ __('navigation.task.information') }}</div>
                        <div class="task__body">{{ __('navigation.task.information_text') }}</div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="py-12">
            <div id="tasks" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <details open>
                    <summary
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                        {{ __('navigation.task.active') }}</summary>
                    @foreach ($orders[0] as $order)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-10">
                            <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-around">
                                <form method="post" action="{{ route('orders.update', $order->id) }}" class="mt-6 space-y-6">
                                    @csrf
                                    @method('patch')
                                    <div class="max-w-xl">
                                        <label class="text-lg font-bold text-gray-900 dark:text-gray-100" for="order_id">
                                            Заказ
                                        </label>
                                        <span class="block mt-1">{{ $order->id }}</span>
                                    </div>

                                    <div class="max-w-xl">
                                        <label class="text-lg font-bold text-gray-900 dark:text-gray-100" for="username">
                                            Клиент
                                        </label>
                                        <span class="block mt-1">{{ $order->username }}</span>
                                    </div>

                                    <div class="max-w-xl">
                                        <label class="text-lg font-bold text-gray-900 dark:text-gray-100" for="typeworks">
                                            Работа
                                        </label>
                                        <span class="block mt-1">{{ $order->typeworks }}</span>
                                    </div>

                                    <div class="max-w-xl">
                                        <label class="text-lg font-bold text-gray-900 dark:text-gray-100" for="summ">
                                            Сырье со склада
                                        </label>
                                        <span class="block mt-1">{{ $order->summ }}</span>
                                    </div>

                                    <div class="max-w-xl">
                                        <label class="text-lg font-bold text-gray-900 dark:text-gray-100" for="summ">
                                            Сумма заказа
                                        </label>
                                        <span class="block mt-1">{{ $order->summ }}</span>
                                    </div>
                                </form>
                                <form method="post" action="{{ route('orders.update', $order->id) }}" class="mt-6 space-y-6">
                                    @csrf
                                    @method('patch')
                                    <div class="max-w-xl">
                                        <label class="text-lg font-bold text-gray-900 dark:text-gray-100" for="order_id">
                                            Ход работы
                                        </label>
                                    </div>

                                    <div class="max-w-xl">
                                        <input type="checkbox"
                                               class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border border-gray-900/20 bg-gray transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-700 before:opacity-0 before:transition-opacity checked:border-gray-900 checked:bg-gray-900 checked:before:bg-gray-900 hover:scale-105 hover:before:opacity-0"
                                               id="customStyle" disabled/>
                                        <label class="text-lg text-gray-900 dark:text-gray-100 ml-2" for="order_id">
                                            Имя
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </details>


            </div>
        </div>
    @endif

</x-app-layout>
