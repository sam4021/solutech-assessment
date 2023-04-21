<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\Status\StatusCollection;

use App\Repository\StatusRepository;

class StatusController extends Controller
{
    public $status;

    public function __construct(StatusRepository $status)
    {
        $this->status = $status;
    }

    public function index()
    {
        $status =  $this->status->getAll();

        if (count($status)) {
            return StatusCollection::make($status)->resolve();
        } else {
            return [];
        }

    }

    public function show($id)
    {
        $status =  $this->status->getById($id);

        return new StatusResource($status);
    }

    public function store(Request $request)
    {
        $collection = $request->except(['_token','_method']);

        $response = $this->status->create($collection);
        return $response;
    }

    public function update($id, Request $request)
    {
        $collection = $request->except(['_token','_method']);

        $response = $this->status->update($id,$collection);
        return $response;
    }

    public function destroy($id)
    {
        $response = $this->status->destroy($id);
        return $response;
    }
}
