<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Задачи') }}
        </h2>
    </x-slot>
    <style>
        .task {
            margin: 20px;
            padding: 20px;
            border: 1px solid gray;
            border-radius: 10px;
        }

        .task__header {
            display: flex;
            justify-content: space-between;
            text-transform: capitalize;
        }

        .task__body {
            margin-top: 20px;
        }

        .accept {
            display: flex;
            flex-direction: row-reverse;
        }
    </style>
    <div class="py-12">
        <div id="tasks" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($tasks)
                @foreach ($tasks as $task)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-10">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="task__header">
                                <div class="task__header task__header_user">
                                    <div class="task__header_user">{{ $users[$task->user_id - 1]->name }}</div>
                                    <div class="gray line"></div>
                                    <div class="task__header_cabinet">{{ $task->cabinet }} кабинет</div>
                                </div>
                                <div class="task__header task__header_date">
                                    <div class="task__date">{{ $task->updated_at }}</div>
                                </div>
                            </div>
                            <div class="task__body">
                                <div class="task__title">{{ $task->title }}</div>
                                <div class="task__description">{{ $task->description }}</div>
                                @if (Auth::user()->role == (1 || 2))
                                    <form action="{{ route('task.completed', $task->id) }}" method="post"
                                        class="accept">
                                        @csrf
                                        @method('patch')
                                        <button name="accept" value="{{ $task->id }}">Выполнено</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="task">
                    <div class="task__header">Ошибка</div>
                    <div class="task__body">Новых заявок не найдено.</div>
                </div>
            @endif
        </div>
    </div>


</x-app-layout>
