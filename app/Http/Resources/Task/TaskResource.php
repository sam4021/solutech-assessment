<?php

namespace App\Http\Resources\Task;

use Carbon\Carbon;
use App\Http\Resources\Status\StatusResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->due_date)

                                    ->format('Y-m-d');
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'due_date' => $newDate,
            'status' => (new StatusResource($this->status)),
            'users' => $this->users
        ];
    }
}
