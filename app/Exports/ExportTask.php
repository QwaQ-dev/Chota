<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportTask implements FromCollection, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $from = date("Y-m-d 00:00:00", strtotime(request()->from));
        $to = date("Y-m-d 23:59:59", strtotime(request()->to));
        $users = \App\Models\User::all();
        $usersName = [];
        foreach($users as $user){
            $usersName[$user->id] = $user->name;
        }
        $tasksExport = [["#", "Заявитель", "Кабинет", "Описание", "Исполнитель", "Дата создания", "Дата выполнения"]];
        $tasks = Task::where("status_id", 2)->whereBetween("updated_at", [$from, $to])->orderBy("created_at", "DESC")->get();
        $id = 1;
        foreach($tasks as $task){
            array_push($tasksExport, [
                $id,
                $usersName[$task["user_id"]],
                $task->cabinet,
                $task->title,
                $usersName[$task["performer_id"]],
                $task->created_at,
                $task->updated_at
            ]);
            $id++;
        }
        return collect($tasksExport);
    }
}
