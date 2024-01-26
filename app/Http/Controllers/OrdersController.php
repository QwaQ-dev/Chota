<?php

namespace App\Http\Controllers;

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
        return view("order.create");
    }

    public function store()
    {
        $data = request()->validate([
            "username" => "string|required",
            "typeworks" => "string|required",
            "summ" => "required|string",
            "executor" => "required|string",
        ]);

        if (request()->user()->isWorker()) {
            $data["user_id"] = request()->user()->id;
            $data["performer_id"] = auth()->id();
            $data["status_id"] = 1;
        } else {
            $data["user_id"] = request()->user()->id;
        }

        Order::create($data);

        $message = "Новая заявка.\nПользователь: ".User::find($data["user_id"])->name.".\nИсполнитель: ".$data["executor"].".\nТип работ: ".$data["typeworks"].".\nСумма: ".$data["summ"].".\nПроверьте список заявок!";

        return redirect()->route('order');
    }

    // Остальные методы также заменены на соответствующие операции с заказами
    // ...

    public function export()
    {
        return Excel::download(new ExportOrder, 'orders.xlsx');
    }
}
