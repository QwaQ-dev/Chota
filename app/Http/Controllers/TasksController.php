<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\RolesUsers;
use App\Exports\ExportTask;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Maatwebsite\Excel\Facades\Excel;

class TasksController extends Controller
{
    public function index()
    {
        if (request()->user()->isUser())
            $tasks = [Task::where(["user_id" => request()->user()->id, "status_id" => 1])->orderBy("created_at", "DESC")->get(), Task::where(["user_id" => request()->user()->id, "status_id" => 0])->orderBy("created_at", "DESC")->get(), []];
        elseif (request()->user()->isAdmin()) {
            $tasks = [
                Task::where("status_id", 1)->orderBy("created_at", "DESC")->limit(50)->get(),
                Task::where("status_id", 0)->orderBy("created_at", "DESC")->limit(50)->get(),
                Task::where("status_id", 2)->orderBy("created_at", "DESC")->limit(50)->get(),
            ];
        } else {
            // $tasks = Task::all();
            $tasks = [
                Task::where(["performer_id" => request()->user()->id, "status_id" => 1])->orderBy("created_at", "DESC")->get(),
                [], []
            ];
        }
        if (!count($tasks[0]) && !count($tasks[1]) && !count($tasks[2])) $tasks = false;

        $users = User::all();

        $workersId = RolesUsers::where("role_id", 2)->get();

        $workers = [];

        foreach ($workersId as $worker) {
            array_push($workers, ['user_id' => $worker->user_id, 'name' => $worker->user["name"]]);
        }

        return view("task.index", compact("tasks", "users", "workers"));
    }

    public function create()
    {
        return view("task.create");
    }

    public function store()
    {
        $data = request()->validate([
            "cabinet" => "string|required",
            "title" => "string|required",
            "description" => "nullable|string|max:500"
        ]);
        if (request()->user()->isWorker()) {
            $data["user_id"] = request()->user()->id;
            $data["performer_id"] = auth()->id();
            $data["status_id"] = 1;
        } else {
            $data["user_id"] = request()->user()->id;
        }
        // dd($data);
        Task::create($data);
        $message = "Новая заявка.\nПользователь: ".User::find($data["user_id"])->name.".\nКабинет: ".$data["cabinet"].".\nПроблема: ".$data["title"].".\nОписание: ".$data["description"].".\nПроверьте список заявок!";

        return redirect()->route('task');
    }

    public function update(Task $task)
    {
        if (request()->user()->isWorker() || request()->user()->isAdmin()) {
            $performer_id = request()->performer_id ?? request()->user()->id;
            if (request()->accept) {
                $task = Task::find(request()->accept);
                $task->update([
                    "performer_id" => $performer_id,
                    "status_id" => 1
                ]);
            } elseif (request()->refuse) {
                $task = Task::find(request()->refuse);
                $task->update([
                    "performer_id" => Null,
                    "status_id" => 0
                ]);
            }
            $tasks = Task::where(["status_id" => 1, "performer_id" => $performer_id])->get();
            $users = User::all();
            return redirect()->route('task');
            // return view("task.update", compact("tasks", "users"));
        } else {
            return abort(404);
        }
    }

    public function completed(Task $task)
    {
        if (request()->user()->isWorker() || request()->user()->isAdmin()) {
            $task = Task::find(request()->accept);
            $task->update([
                "performer_id" => $task->performer_id,
                "status_id" => 2
            ]);
            $tasks = Task::where(["status_id" => 1, "performer_id" => request()->performer_id])->get();
            $users = User::all();
            return redirect()->route('task');
            // return view("task.update", compact("tasks", "users"));
        } else {
            return abort(404);
        }
    }


    public function destroy($task)
    {
        if (request()->user()->isAdmin()) {
            $task = Task::find($task);
            $task->delete();
            return redirect()->route('task');
        } else {
            return abort(404);
        }
    }

    public function export()
    {
        return Excel::download(new ExportTask, 'tasks.xlsx');
    }
}
