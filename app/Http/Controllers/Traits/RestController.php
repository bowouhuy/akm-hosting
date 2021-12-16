<?php

namespace App\Http\Controllers\Traits;

use App\Http\Requests\IndexRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

/**
 * Handle requiring restful
 * Trait RestfulController
 * @package App\Http\Controllers\Traits
 */
trait RestController
{

    public function json($code = Response::HTTP_OK, $message = '', $data = null)
    {
        if (!is_null($data)) {
            if (method_exists($data, 'items')) {

                $request = app(Request::class);

                $query = [];
                foreach ($request->query() as $key => $value) {
                    if ($key != 'page')
                        $query[] = $key . '=' . $value;
                }

                $query = '&' . implode('&', $query);

                $previousPageUrl = (!empty($data->previousPageUrl())) ?
                    $data->previousPageUrl() . $query :
                    $data->previousPageUrl();

                $nextPageUrl = (!empty($data->nextPageUrl())) ?
                    $data->nextPageUrl() . $query :
                    $data->nextPageUrl();


                $currentPageUrl = (!empty($data->url($data->currentPage()))) ?
                    $data->url($data->currentPage()) . $query :
                    $data->url($data->currentPage());

                $paginate = [
                    'has_more_pages' => $data->hasMorePages(),
                    'count' => (int)$data->count(),
                    'total' => (int)$data->total(),
                    'per_page' => (int)$data->perPage(),
                    'current_page' => (int)$data->currentPage(),
                    'last_page' => (int)$data->lastPage(),
                    'prev_page_url' => $previousPageUrl,
                    'current_page_url' => $currentPageUrl,
                    'next_page_url' => $nextPageUrl
                ];

                return response()->json(
                    [
                        "code" => $code,
                        "message" => $message,
                        "data" => $data->items(),
                        "pagination" => $paginate
                    ], $code, []
                );
            }

            return response()->json(
                [
                    "code" => $code,
                    "message" => $message,
                    "data" => $data
                ], $code, []
            );
        }
        return response()->json(
            [
                "code" => $code,
                "message" => $message
            ], $code, []
        );
    }
    public function resource()
    {
        return [];
    }

    /**
     * @param IndexRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function index(IndexRequest $request)
    {
        try {
            $data = $this->repository->fetch($request);
            
            $breadcrumbs = [
                ['name'=> $this->name]
            ];
            if ($request->expectsJson()) {
                if ($request->get('is_datatable')) {
                    $dt = Datatables::collection(
                        $this->repository->list()
                    )->toJson();
                        
                    return $dt;
                } else {
                    return $this->json(
                        Response::HTTP_OK,
                        "$this->name Fetched.",
                        $data
                    );
                }
            }

            return view("$this->layout.index", $data, [ 'breadcrumbs' => $breadcrumbs]);
        } catch (\Exception $e) {
            if ($request->expectsJson())
                throw $e;

            return back()
                ->withErrors(
                    $e->__toString()
                );
        }
    }

    public function list()
    {
        $data = $this->repository->list();
        return $this->json(
            Response::HTTP_OK,
            "$this->name Fetched.",
            $data
        );
    }

    public function fetchDatatable()
    {
        try {
            $list = $this
                ->repository
                ->list()
                ->toArray();
            
            $dt = Datatables::collection($list)
                ->toArray();
            
            $json = preg_replace('/{"EMPTY_OBJECT"\s*:\s*true}/',
                '{}',
                json_encode($dt, JSON_UNESCAPED_SLASHES));
            
            return $json;

        } catch (\Exception $e) {
            return back()
                ->withErrors(
                    $e->__toString()
                );
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function show($id, Request $request)
    {
        try {
            $dataById = $this->repository->byId($id);

            if ($request->expectsJson())
                return $this->json(
                    Response::HTTP_OK,
                    "$this->name Fetched.",
                    $dataById
                );

            return view(
                "$this->layout.detail", [
                'data' => $dataById
            ]);
        } catch (\Exception $e) {
            if ($request->expectsJson())
                throw $e;

            return back()
                ->withErrors(
                    $e->__toString()
                );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function showCreateForm(Request $request)
    {
        try {
            $data = $this->resource();

            if ($request->expectsJson())
                return $this->json(
                    Response::HTTP_OK,
                    "Create $this->name was displayed.",
                    $data
                );

            return view(
                "$this->layout.create",
                $data
            );
        } catch (\Exception $e) {
            if ($request->expectsJson())
                throw $e;

            return back()
                ->withErrors(
                    $e->__toString()
                );
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function store(Request $request)
    {
        try {
            $data = $this->repository->store($request);

            if ($request->expectsJson())
                return $this->json(
                    Response::HTTP_CREATED,
                    "$this->name Saved Successfully.",
                    $data
                );

            return redirect()->to($this->redirectTo, 201)
                ->with('message', 'Data saved successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson())
                throw $e;

            return back()
                ->withErrors(
                    $e->__toString()
                );
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function showEditForm($id, Request $request)
    {
        try {
            $dataById = $this->repository->byId($id);
            $data = $this->resource();
            $data['data'] = $dataById;

            if ($request->expectsJson())
                return $this->json(
                    Response::HTTP_OK,
                    "$this->name Fetched.",
                    $data
                );

            return view(
                "$this->layout.edit", $data
            );
        } catch (\Exception $e) {
            if ($request->expectsJson())
                throw $e;

            return back()
                ->withErrors(
                    $e->__toString()
                );
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function update($id, Request $request)
    {
        try {
            $data = $this->repository->update($id, $request);

            if ($request->expectsJson())
                return $this->json(
                    Response::HTTP_CREATED,
                    "$this->name Updated Successfully.",
                    $data
                );

            return redirect($this->redirectTo)
                ->with('message', 'Data updated successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson())
                throw $e;

            return back()
                ->withErrors(
                    $e->__toString()
                );
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function destroy($id, Request $request)
    {
        try {
            $this->repository->remove($id);

            if ($request->expectsJson())
                return $this->json(
                    Response::HTTP_OK,
                    "The $this->name $id was deleted."
                );

            return back()
                ->with(
                    'message', "The $this->name $id was deleted."
                );
        } catch (\Exception $e) {
            if ($request->expectsJson())
                throw $e;

            return back()
                ->withErrors(
                    $e->__toString()
                );
        }
    }
}
