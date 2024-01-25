@php
    
    // dump(Auth::user()->getRole());
    // dump(Auth::user()->isAdmin());
    // dump(Auth::user()->isWorker());
    // dump(Auth::user()->isUser());
    
    // echo 'Role User<br>';
    // $workers = App\Models\RolesUsers::where('role_id', 1)->get();
    // foreach ($workers as $worker) {
    //     echo 'id: ' . $worker->user_id . ' name: ' . $worker->user['name'] . '<br>';
    // }
    // echo 'Role Worker<br>';
    // $workers = App\Models\RolesUsers::where('role_id', 2)->get();
    // foreach ($workers as $worker) {
    //     echo 'id: ' . $worker->user_id . ' name: ' . $worker->user['name'] . '<br>';
    // }
    // echo 'Role Admin<br>';
    // $workers = App\Models\RolesUsers::where('role_id', 3)->get();
    // foreach ($workers as $worker) {
    //     echo 'id: ' . $worker->user_id . ' name: ' . $worker->user['name'] . '<br>';
    // }
    
    // echo 'ProjTasks<br>';
    // $a = App\Models\Projtasks_project::where('project_id', 1)->get();
    // foreach ($a as $b) {
    //     echo 'project: '. $b->project_id . ' task: ' . $b->projtask_id . ' - ' . $b->projtask["text"] . ' (' . $b->projtask["status"] . ') - ' . $b->projtask->user["name"] . ' <br>';
    // }

    // echo '<br>ProjTasks<br>';
    // $a = App\Models\Projtasks_project::where('project_id', 2)->get();
    // foreach ($a as $b) {
    //     echo 'project: '. $b->project_id . ' task: ' . $b->projtask_id . ' - ' . $b->projtask["text"] . ' (' . $b->projtask["status"] . ') - ' . $b->projtask->user["name"] . ' <br>';
    // }

    // echo '<br>ProjTasks<br>';
    // $a = App\Models\Projtasks_project::where('project_id', 3)->get();
    // foreach ($a as $b) {
    //     echo 'project: '. $b->project_id . ' task: ' . $b->projtask_id . ' - ' . $b->projtask["text"] . ' (' . $b->projtask["status"] . ') - ' . $b->projtask->user["name"] . ' <br>';
    // }

    // echo App\Models\Projtasks_project::where('project_id', 1)->orderBy('created_at', 'DESC')->get();

    // echo App\Models\Role::all();

    // dd(Auth::user()->getRole());
    
    // dd(Auth::user()->isAdmin());
    echo "debug page";
@endphp
