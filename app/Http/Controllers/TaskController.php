<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Task\TaskResource;
use App\Http\Resources\Task\TaskCollection;

use App\Repository\TaskRepository;

class TaskController extends Controller
{
    public $task;

    public function __construct(TaskRepository $task)
    {
        $this->task = $task;
    }

    public function index()
    {
        $task =  $this->task->getAll();

        return TaskCollection::make($task)->resolve();
    }

    public function show($id)
    {
        $task =  $this->task->getById($id);

        return new TaskResource($task);
    }

    public function store(Request $request)
    {
        $collection = $request->except(['_token','_method']);
        $response = $this->task->create($collection);
        return $response;
    }

    public function update($id, Request $request)
    {
        $collection = $request->except(['_token','_method']);

        $response = $this->task->update($id,$collection);
        return $response;
    }

    public function destroy($id)
    {
        $response = $this->task->destroy($id);
        return $response;
    }

    public function assign_user(Request $request)
    {
        $collection = $request->except(['_token','_method']);

        $response = $this->task->assign_user($collection);
        return $response;
    }
}
