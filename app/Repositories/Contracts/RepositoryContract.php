<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface RepositoryContract
{
    public function fetch(Request $request);

    public function list();

    public function byId($id);

    public function store($request);

    public function update($id, Request $request);

    public function remove($id);

    public function getModel();
}
