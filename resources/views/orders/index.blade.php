<x-app-layout>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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

                <div class="max-w-xl">
                    <x-input-label for="username" :value="__('Specify the name client')" />
                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" required
                                  autofocus autocomplete="username" />
                </div>

                <div class="max-w-xl">
                    <x-input-label for="typeworks" :value="__('Specify the type of work')" />
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
                    <x-input-label for="quantity" :value="__('Выберите сырье со склада')" />
                    <x-text-input id="quantity" name="quantity" type="text" class="mt-1 block w-full" list="quantity"
                                  required autocomplete="quantity" />
                    <datalist id="quantity">
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
                    <x-primary-button type="submit">{{ __('Create') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <div class="mt-6 text-white mx-auto">
        @if ($orders)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($orders as $statusOrders)
                    <div class="m-6">
                        <h3 class="text-lg font-semibold mb-4 accordion-trigger">
                            @if ($loop->index == 0)
                                {{ __('Выполненные заказы') }} <span class="arrow">&#9660;</span>
                            @elseif ($loop->index == 1)
                                {{ __('Ожидаемые заказы') }} <span class="arrow">&#9660;</span>
                            @else
                                {{ __('Отмененные заказы') }} <span class="arrow">&#9660;</span>
                            @endif
                        </h3>

                        <div class="accordion-content" style="display: none;">
                            @if (count($statusOrders) > 0)
                                @foreach ($statusOrders as $order)
                                    <div class="bg-white dark:bg-gray-800 p-6 m-4 rounded-lg shadow-md mb-8 w-full">
                                    <div class="flex flex-col m-4">
                                        <span class="font-bold">{{ __('Имя клиента:  ') }}</span> {{ $order->username }}
                                    </div>
                                    <div class="flex flex-col m-4">
                                        <span class="font-bold">{{ __('Тип работы: ') }}</span> {{ $order->typeworks }}
                                    </div>
                                    <div class="flex flex-col m-4">
                                        <span class="font-bold">{{ __('Количество сырья: ') }}</span> {{ $order->quantity }}
                                    </div>
                                    <div class="flex flex-col m-4">
                                        <span class="font-bold">{{ __('Сумма заказа: ') }}</span> {{ $order->summ }}
                                    </div>
                                    <div class="flex flex-col m-4">
                                        <span class="font-bold">{{ __('Исполнитель: ') }}</span> {{ $order->executor }}
                                    </div>
                                    <div class="flex justify-between mt-4">
                                        <form method="POST" action="{{ route('orders.accept', $order->id) }}">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">
                                                {{ __('Выполнено') }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('orders.refuse', $order->id) }}">
                                            @csrf
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">
                                                {{ __('Отменить') }}
                                            </button>
                                        </form>
                                    </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500">{{ __('Заказов в этом статусе нет.') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">{{ __('Заказов нет.') }}</p>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $('.accordion-trigger').click(funзрзction() {
                $(this).next('.accordion-content').slideToggle();
                // Переключение стрелочки в зависимости от состояния аккордеона
                $(this).find('.arrow').html($(this).next('.accordion-content').is(':visible') ? '&#9650;' : '&#9660;');
            });
        });
    </script>
















</x-app-layout>
