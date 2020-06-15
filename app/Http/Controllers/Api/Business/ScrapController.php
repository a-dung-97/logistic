<?php

namespace App\Http\Controllers\Api\Business;

use App\Helpers\Helper;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScrapRequest;
use App\Http\Resources\ScrapResource;
use App\Scrap;
use Illuminate\Http\Request;

class ScrapController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $search = $request->query('search');
        $query = Scrap::query();
        if ($search) $query->whereLike(['name', 'code'], '%' . $search . '%');
        return ScrapResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScrapRequest $request)
    {
        Scrap::create($request->all());
        return Response::created();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scrap  $scrap
     * @return \Illuminate\Http\Response
     */
    public function update(ScrapRequest $request, Scrap $scrap)
    {
        $scrap->update($request->all());
        return Response::updated();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Scrap  $scrap
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scrap $scrap)
    {
        return Helper::delete($scrap);
    }
}
