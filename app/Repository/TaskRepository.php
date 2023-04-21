<?php
namespace App\Repository;

use Auth;
use App\Models\Tasks;
use App\Models\UserTasks;

use App\Interface\TaskInterface;
use Illuminate\Support\Facades\Hash;

class TaskRepository implements TaskInterface
{
    public function getAll()
    {
        return Tasks::all();
    }

    public function getById($id)
    {
        return Tasks::findOrFail($id);
    }

    public function create($collection)
    {
        try {
            $task = new Tasks;
            $task->name = $collection['name'];
            $task->due_date = $collection['due_date'];
            $task->status_id = $collection['status'];
            $task->save();
            return response('Tasks Created', 200);
        } catch(\Exception $e){
            return response($e->getMessage(), 400);
        }
    }

    public function update( $id,$collection)
    {
        try {
            $task = Tasks::findOrFail($id);
            $task->name = $collection['name'];
            $task->due_date = $collection['due_date'];
            $task->status_id = $collection['status'];
            $task->save();

            return response('Tasks Updated', 200);
        } catch(\Exception $e){
            // do task when error
            return response($e->getMessage(), 400);
        }
    }

    public function destroy( $id)
    {
        try {
            $status = Tasks::where('id',$id)->delete();
            return response('Tasks Deleted', 200);
        } catch(\Exception $e){
            // do task when error
            return response($e->getMessage(), 400);
        }
    }

    public function assign_user($collection)
    {
        try {
            $task = new UserTasks;
            $task->user_id = $collection['user'];
            $task->task_id = $collection['id'];
            $task->status_id = $collection['status'];
            $task->due_date = $collection['due_date'];
            $task->start_time = $collection['start_time'];
            $task->end_time = $collection['end_time'];
            $task->remarks = $collection['remarks'];
            $task->save();
            return response('Task Assigned Created', 200);
        } catch(\Exception $e){
            return response($e->getMessage(), 400);
        }
    }
}
