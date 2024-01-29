<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Order;  // Импорт модели Order
use App\Models\RolesUsers;
use App\Exports\ExportOrder;  // Импорт экспорта Order
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Maatwebsite\Excel\Facades\Excel;

class OrdersController extends Controller
{
    public function index()
    {
        if (request()->user()->isUser()) {
            $orders = [
                Order::where(["user_id" => request()->user()->id, "status_id" => 1])->orderBy("created_at", "DESC")->get(),
                Order::where(["user_id" => request()->user()->id, "status_id" => 0])->orderBy("created_at", "DESC")->get(),
                [],
            ];
        } elseif (request()->user()->isAdmin()) {
            $orders = [
                Order::where("status_id", 1)->orderBy("created_at", "DESC")->limit(50)->get(),
                Order::where("status_id", 0)->orderBy("created_at", "DESC")->limit(50)->get(),
                Order::where("status_id", 2)->orderBy("created_at", "DESC")->limit(50)->get(),
            ];
        } else {
            $orders = [
                Order::where(["performer_id" => request()->user()->id, "status_id" => 1])->orderBy("created_at", "DESC")->get(),
                [],
                [],
            ];
        }
        if (!count($orders[0]) && !count($orders[1]) && !count($orders[2])) {
            $orders = false;
        }

        $users = User::all();

        $workersId = RolesUsers::where("role_id", 2)->get();

        $workers = [];

        foreach ($workersId as $worker) {
            array_push($workers, ['user_id' => $worker->user_id, 'name' => $worker->user["name"]]);
        }

        return view("orders.index", compact("orders", "users", "workers"));
    }

    public function create()
    {
        // Проверка роли пользователя
        if (request()->user()->isUser()) {
            return abort(403); // Ошибка доступа
        }

        return view("orders.create");
    }


    public function store()
    {
        $data = request()->validate([
            "username" => "string|required",
            "typeworks" => "string|required",
            "summ" => "required|string",
            "executor" => "required|array", // Используйте массив для множественного выбора
        ]);

        // Другие проверки данных

        // Создание заказа
        $order = Order::create([
            'username' => $data['username'],
            'typeworks' => $data['typeworks'],
            'summ' => $data['summ'],
            'status_id' => 0, // Устанавливаем статус в "ожидание"
        ]);

        // Привязка исполнителей к заказу
        foreach ($data['executor'] as $executor) {
            // Добавьте свою логику для привязки исполнителей
        }

        // Другие действия после создания заказа

        return redirect()->route('orders');
    }


    public function update(Order $order)
    {
        if (request()->user()->isWorker() || request()->user()->isAdmin()) {
            $performer_id = request()->performer_id ?? request()->user()->id;
            if (request()->accept) {
                $order = Order::find(request()->accept);
                $order->update([
                    "performer_id" => $performer_id,
                    "status_id" => 1
                ]);
            } elseif (request()->refuse) {
                $order = Order::find(request()->refuse);
                $order->update([
                    "performer_id" => Null,
                    "status_id" => 0
                ]);
            }
            $order = Order::where(["status_id" => 1, "performer_id" => $performer_id])->get();
            $users = User::all();
            return redirect()->route('orders');
            // return view("task.update", compact("tasks", "users"));
        } else {
            return abort(404);
        }
    }


    public function completed(Order $order)
    {
        if (request()->user()->isWorker() || request()->user()->isAdmin()) {
            $order = Order::find(request()->accept);
            $order->update([
                "performer_id" => $order->performer_id,
                "status_id" => 2
            ]);
            $tasks = Order::where(["status_id" => 1, "performer_id" => request()->performer_id])->get();
            $users = User::all();
            return redirect()->route('orders');
            // return view("task.update", compact("tasks", "users"));
        } else {
            return abort(404);
        }
    }

    public function destroy($order)
    {
        if (request()->user()->isAdmin()) {
            $order = Order::find($order);
            $order->delete();
            return redirect()->route('orders');
        } else {
            return abort(404);
        }
    }

    public function export()
    {
        return Excel::download(new ExportOrder, 'orders.xlsx');
    }
}
