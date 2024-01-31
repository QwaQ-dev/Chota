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
//            dd(Order::where(["user_id" => request()->user()->id, "status_id" => 0])->orderBy("created_at", "DESC")->get());
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

        $workersId = RolesUsers::where("role_id", 1)->get();

        $workers = [];

        foreach ($workersId as $worker) {
            array_push($workers, ['user_id' => $worker->user_id, 'name' => $worker->user["name"]]);
        }

        return view("orders.index", compact("orders", "users", "workers"));
    }

    public function create()
    {
        return view("orders.create");
    }

    public function store(Request $request)
    {
        $order = new Order();
        $order->user_id = $request->input('user_id');
        $order->username = $request->input('username');
        $order->typeworks = $request->input('typeworks');
        $order->quantity = $request->input('quantity');
        $order->summ = $request->input('summ');
//        $order->executor = $request->input('executor');
        $order->typeuser = 'some_value'; // Fill in according to your logic
        $order->status_id = 0; // Fill in according to your logic
        $order->save();

        // Добавим withInput() для сохранения данных введенных в форме
        return back()->withInput()->with('success', 'Order created successfully');

    }


    public function update(Request $request, Order $order)
    {
        $performer_id = $request->performer_id ?? $request->user()->id;

        if ($request->has('accept')) {
            $order->update([
                "performer_id" => $performer_id,
                "status_id" => 1
            ]);
        } elseif ($request->has('refuse')) {
            $order->update([
                "performer_id" => null,
                "status_id" => 2
            ]);
        }

        return redirect()->route('orders');
    }


    public function accept(Order $order)
    {
        $order->update([
            'status_id' => 1,
        ]);

        return redirect()->route('orders')->with('success', 'Order marked as completed.');
    }

    public function refuse(Order $order)
    {
        $order->update([
            'status_id' => 2,
        ]);

        return redirect()->route('orders')->with('success', 'Order marked as cancelled.');
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
