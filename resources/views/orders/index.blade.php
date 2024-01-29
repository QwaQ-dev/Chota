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

    @if (Auth::user()->isWorker() || Auth::user()->isAdmin())
        @include('orders.create')
    @else
        <p>У вас нет доступа к созданию заказов.</p>
    @endif


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
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <form method="post" action="{{ route('orders.update', $order->id) }}" class="mt-6 space-y-6">
                                    @csrf
                                    @method('patch')

                                    <div class="max-w-xl">
                                        <label class="text-lg font-medium text-gray-900 dark:text-gray-100" for="order_id">
                                            Заказ
                                        </label>
                                        <span class="block mt-1">{{ $order->id }}</span>
                                    </div>

                                    <div class="max-w-xl">
                                        <label class="text-lg font-medium text-gray-900 dark:text-gray-100" for="username">
                                            Клиент
                                        </label>
                                        <span class="block mt-1">{{ $order->username }}</span>
                                    </div>

                                    <div class="max-w-xl">
                                        <label class="text-lg font-medium text-gray-900 dark:text-gray-100" for="typeworks">
                                            Работа
                                        </label>
                                        <span class="block mt-1">{{ $order->typeworks }}</span>
                                    </div>

                                    <div class="max-w-xl">
                                        <label class="text-lg font-medium text-gray-900 dark:text-gray-100" for="summ">
                                            Сумма заказа
                                        </label>
                                        <span class="block mt-1">{{ $order->summ }}</span>
                                    </div>

                                    <div class="max-w-xl">
                                        <label class="text-lg font-medium text-gray-900 dark:text-gray-100" for="executor">
                                            Исполнители
                                        </label>
                                        <span class="block mt-1">{{ $order->executor }}</span>
                                    </div>

                                    <!-- Добавьте другие поля по необходимости -->

                                    <div class="flex items-center gap-4">
                                        <div class="flex justify-end mt-4">
                                            <form action="{{ route('orders.completed', $order->id) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <x-primary-button name="accept" value="{{ $order->id }}">
                                                    {{ __('navigation.task.done') }}</x-primary-button>
                                            </form>
                                            <form action="{{ route('orders.update', $order->id) }}" method="post"
                                                  class="ml-3">
                                                @csrf
                                                @method('patch')
                                                <x-primary-button name="refuse" value="{{ $order->id }}">
                                                    {{ __('navigation.task.assign') }}</x-primary-button>
                                            </form>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </details>
                <details open>
                    <summary
                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                        {{ __('navigation.task.wait') }}</summary>
                    @if ($orders !== null && count($orders[1]) == 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-10">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <div class="flex justify-between">{{ __('navigation.task.information') }}</div>
                                <div class="mt-4">{{ __('navigation.task.information_text') }}</div>
                            </div>
                        </div>
                    @else
                        @foreach ($orders[1] as $order)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-10">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    <div class="flex justify-between capitalize">
                                        <div class="flex justify-between">
                                            <span class="task__header_user">{{ $users[$order->user_id - 0]->name }}
                                            </span>
                                            <div class="gray line"></div>
                                            <span class="task__header_cabinet">{{ $order->cabinet }}
                                                {{ __('navigation.task.cabinet') }} </span>
                                        </div>
                                        <div class="flex justify-end">
                                            <span>
                                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->locale(App::currentLocale())->isoFormat('dddd, D MMMM H:mm') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="task__title">{{ $order->username }}</div>
                                        <div class="task__description">{{ $order->typeworks }}</div>
                                        @if (Auth::user()->isAdmin() && $order->status_id == 0)
                                            <div class="flex justify-between mt-6">
                                                <form action="{{ route('orders.destroy', $order->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <x-accept-button>
                                                        {{ __('Delete') }}
                                                    </x-accept-button>
                                                </form>

                                                <form action="{{ route('orders.update', $order->id) }}" method="post">
                                                    @csrf
                                                    @method('patch')
                                                    <x-select name="performer_id">
                                                        @foreach ($workers as $worker)
                                                            <option value="{{ $worker['user_id'] }}">
                                                                {{ $worker['name'] }}</option>
                                                        @endforeach
                                                    </x-select>
                                                    <x-primary-button name="accept" value="{{ $order->id }}"
                                                                      class="ml-3">
                                                        {{ __('navigation.task.assign') }}
                                                    </x-primary-button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </details>
                @if (Auth::user()->isAdmin())
                @endif
                @if ($orders !== null && is_countable($orders[1]) && count($orders[1]) == 0)
                    <details>
                        <summary
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                            {{ __('navigation.task.completed') }}</summary>
                        <div class="mt-3 mb-3 text-gray-900 dark:text-gray-100">
                            <form action="{{ route('task.export') }}" method="post">
                                @csrf
                                <!-- @method('patch') -->
                                <label for="start">{{ __('navigation.task.from') }}:</label>

                                <input type="date" id="start"
                                       class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                       name="from" value="{{ date('Y-m-d', strtotime('-1 month')) }}"
                                       min="2023-01-01" max="2033-12-31" style="border-radius: 0.5em;">

                                <label class="ml-3" for="end">{{ __('navigation.task.to') }}:</label>

                                <input type="date" id="end"
                                       class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                       name="to" value="{{ date('Y-m-d') }}" min="2023-01-01" max="2033-12-31"
                                       style="border-radius: 0.5em;">

                                <x-primary-button class="ml-3">{{ __('navigation.task.export') }}</x-primary-button>
                            </form>
                        </div>
                        @foreach ($orders[2] as $order)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-10">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    <div class="flex justify-between capitalize">
                                        <div class="flex justify-between">
                                            <span>{{ $users[$order->user_id - 1]->name }}</span>
                                            <div class="gray line"></div>
                                            <span>{{ $order->cabinet }}
                                                {{ __('navigation.task.cabinet') }}</span>
                                        </div>
                                        <div class="flex justify-end">
                                            <span>
                                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $task->updated_at)->locale(App::currentLocale())->isoFormat('dddd, D MMMM H:mm') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <span>{{ $order->title }}</span>
                                        <span>{{ $order->description }}</span>
                                        <span
                                            class="flex justify-end mt-6 mr-2">{{ __('navigation.task.performer') }}:
                                            {{ $workers[array_search($order->performer_id, array_column($workers, 'user_id'))]['name'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </details>
                @endif
            </div>
        </div>
    @endif

</x-app-layout>
