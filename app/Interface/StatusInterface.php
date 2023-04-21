<?php
namespace App\Interface;

interface StatusInterface
{
    public function getAll();

    public function getById($id);

    public function create($collection);

    public function update($id,$collection);

    public function destroy($id);
}
