<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\ResponseWithHttpStatus;

Trait CRUD
{
    abstract function model();
    abstract function validationRules($resource_id = 0);

    public function index()
    {
        $data = $this->model()::all();
        return self::trueResponse("Berhasil mengambil data", $data);
    }

    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), $this->validationRules())->validate();
            $data = $this->model()::create($request->all());
            return self::trueResponse("Berhasil Memasukan data", $data);
        }catch (\Exception $e) {
            return self::falseResponse($e->getMessage(),[],500);
        }
    }

    public function show($resource_id)
    {
        try {
            $data = $this->model()::findOrFail($resource_id);
            return self::trueResponse("Berhasil mengambil data", $data);
        }catch (\Exception $e) {
            return self::falseResponse($e->getMessage(),[],500);
        }
    }

    public function update(Request $request, $resource_id)
    {
        $resource = $this->model()::findOrFail($resource_id);

        Validator::make($request->all(), $this->validationRules($resource_id))->validate();

        return $resource->update($request->all());
    }

    public function destroy($resource_id)
    {
        try {
            $resource = $this->model()::findOrFail($resource_id);
            $resource->delete();
            return self::trueResponse("Berhasil Menghapus data", $resource);
        }catch (\Exception $e) {
            return self::falseResponse($e->getMessage(),[],500);
        }
    }
}