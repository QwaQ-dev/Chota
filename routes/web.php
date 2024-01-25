<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\BotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::any('/welcome', function () {
//     return view('welcome');
// });

Route::any('/fish', function () {
    return view('fish');
})->name("fish");

Route::any('/bot', [BotController::class, 'index'])->name("bot");

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TasksController::class, 'index'])->name("task");
    Route::get('/tasks/create', [TasksController::class, 'create'])->name('task.create');
    Route::post('/tasks', [TasksController::class, 'store'])->name('task.store');

    Route::patch('/tasks/update/{task}', [TasksController::class, 'update'])->name('task.update');
    Route::patch('/tasks/completed/{task}', [TasksController::class, 'completed'])->name('task.completed');
    Route::delete('/tasks/{task}', [TasksController::class, 'destroy'])->name('task.destroy');
    Route::post('/tasks/export', [TasksController::class, 'export'])->name('task.export');

    Route::get('/warehouse', [WarehouseController::class, 'index'])->name('warehouse');
    Route::post('/warehouse', [WarehouseController::class, 'store'])->name('warehouse.store');

//    Route::get('/projects', [ProjectsController::class, 'index'])->name("project");
//    Route::get('/projects/create', [ProjectsController::class, 'create'])->name('project.create');
//    Route::post('/projects', [ProjectsController::class, 'store'])->name('project.store');
//    Route::get('/project/{project}', [ProjectsController::class, 'show'])->name('project.show');
//    Route::post('/projects/{project}/create', [ProjectsController::class, 'addcard'])->name('projtask.addcard');
//    Route::patch('/project/{project}/update/{projtask}', [ProjectsController::class, 'update'])->name('projtask.update');
//    Route::delete('/project/{project}', [ProjectsController::class, 'destroy'])->name('projtask.destroy');

    Route::get('/team', [TeamController::class, 'index'])->name("team");
    Route::post('/team', [TeamController::class, 'store'])->name('team.createNewUser');
    Route::post('/team/{user}/update', [TeamController::class, 'update'])->name('team.editUser');
});

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
