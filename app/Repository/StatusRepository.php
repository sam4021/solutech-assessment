<?php
namespace App\Repository;

use Auth;
use App\Models\Status;

use App\Interface\StatusInterface;
use Illuminate\Support\Facades\Hash;

class StatusRepository implements StatusInterface
{
    public function getAll()
    {
        return Status::all();
    }

    public function getById($id)
    {
        return Status::findOrFail($id);
    }

    public function create($collection)
    {
        try {
            $status = new Status;
            $status->name = $collection['name'];
            $status->save();
            return response('Status Created', 200);
        } catch(\Exception $e){
            return response($e->getMessage(), 400);
        }
    }

    public function update( $id,$collection)
    {
        try {
            $status = Status::findOrFail($id);
            $status->name = $collection['name'];
            $status->save();
            return response('States Updated', 200);
        } catch(\Exception $e){
            // do task when error
            return response($e->getMessage(), 400);
        }
    }

    public function destroy( $id)
    {
        try {
            $status = Status::where('id',$id)->delete();
            return response('Status Deleted', 200);
        } catch(\Exception $e){
            // do task when error
            return response($e->getMessage(), 400);
        }
    }
}
