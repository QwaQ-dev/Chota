<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Projtask;
use App\Models\Projtasks_project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        if (request()->user()->isWorker() || request()->user()->isAdmin()) {
            return view("project.index");
        } else {
            return abort(404);
        }
    }

    public function show($project_id)
    {
        if (request()->user()->isWorker() || request()->user()->isAdmin()) {
            $projecttasks = Projtasks_project::where('project_id', $project_id)->orderBy('created_at', 'DESC')->get();
            $planned = [];
            $progress = [];
            $completed = [];

            foreach ($projecttasks as $projecttask) {
                if ($projecttask->projtask['status'] == 'planned') {
                    array_push($planned, $projecttask);
                } elseif ($projecttask->projtask['status'] == 'progress') {
                    array_push($progress, $projecttask);
                } elseif ($projecttask->projtask['status'] == 'completed') {
                    array_push($completed, $projecttask);
                }
            }

            return view("project.show", compact("project_id", "planned", "progress", "completed"));
        } else {
            return abort(404);
        }
    }

    public function create()
    {
        if (request()->user()->isAdmin()) {
            return view("project.create");
        } else {
            return abort(404);
        }
    }

    public function store()
    {
        if (request()->user()->isAdmin()) {
            $planned = [];
            $progress = [];
            $completed = [];

            $data = request()->validate([
                "name" => "string|required",
                "description" => "nullable|string|max:500"
            ]);
            $create = Project::create($data);
            $project_id = $create->id;
            return redirect()->route("project.show", $project_id);
        } else {
            return abort(404);
        }
    }

    public function addcard($project_id)
    {
        if (request()->user()->isWorker() || request()->user()->isAdmin()) {
            $data = request()->validate([
                'text' => "string|required",
                'status' => "string|required",
            ]);
            $data["user_id"] = auth()->user()->id;

            $card = Projtask::create($data);

            Projtasks_project::create([
                'project_id' => $project_id,
                'projtask_id' => $card->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // dd($card);
            return redirect()->route('project.show', $project_id);
        } else {
            return abort(404);
        }
    }

    public function update($project, $projtask)
    {
        if (request()->user()->isWorker() || request()->user()->isAdmin()) {
            $data = request()->validate([
                // 'text' => "string|required",
                'status' => "string|required",
            ]);
            $projtask = Projtask::find($projtask);
            $projtask->update($data);

            return redirect()->route('project.show', $project);
        } else {
            return abort(404);
        }
    }


    public function destroy($project)
    {
        if (request()->user()->isAdmin()) {
            $project = Project::find($project);
            $project->update([
                'status' => "ended",
            ]);

            return redirect()->route('project');
        } else {
            return abort(404);
        }
    }
}
