<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Symfony\Contracts\Service\Attribute\Required;

// landing page
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// index
Route::get('/tasks', function () {
    // $tasks = Task::latest()-> where('completed',true)->get();
    // $tasks = Task::latest()->get();
    $tasks = Task::latest()->paginate(10); // seperate the taske into pages
    return view('index',
    ['tasks' => $tasks]);
})->name('tasks.index');

// render the form
// if u just want to render a page without passing data u can say directly Rout::view()
Route::view('/tasks/create', 'create')->name('tasks.create');

// // render edit form
// Route::get('/tasks/{id}/edit', function ($id) {

//     $task = Task::findOrFail($id);
//     return view('edit', ['task' => $task]);
// })->name('tasks.edit');

// render edit form
// this is the route model binding way:
Route::get('/tasks/{task}/edit', function (Task $task) {
    return view('edit', ['task' => $task]);
})->name('tasks.edit');

// show
Route::get('/tasks/{task}', function (Task $task) {
    return view('show', ['task' => $task]);
})->name('tasks.show');

Route::post('/tasks', function (TaskRequest $request) {
    // if the data passed validation from TaskRequest, then we get the data into $data
    $data = $request->validated();
    // $task = new Task;
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();

    // there is a shortcut way to save data into db:
    $task = Task::create($data);

    return redirect()->route('tasks.show', ['task'=> $task->id])
    ->with('success', 'Task created successfully!');

})->name('tasks.store');

// update
Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    $data = $request->validated();
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();
    $task->update($data);
    return redirect()->route('tasks.show', ['task' =>$task->id])
    ->with('success','Task updated successfully!');

})->name('tasks.update');

// delete a task
Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();
    return redirect()->route('tasks.index')
    ->with('success', 'Task deleted successfully');
})->name('tasks.destroy');

// toggle completed
Route::patch('/tasks/{task}', function (Task $task) {
    $task->toggleCompleted();
    return redirect()->back()->with('success','Task completed successfully');
})->name('tasks.toggle-complete');


// if user try to access a wrong route you will redirect it in this page:
Route::fallback(function () {
    return "Wrong route try again!!";
});
