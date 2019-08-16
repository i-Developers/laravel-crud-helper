<?php
declare(strict_types=1);

namespace Technote\CrudHelper\Http\Controllers\Api;

use Eloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Technote\CrudHelper\Http\Requests\SearchRequest;
use Technote\CrudHelper\Http\Requests\UpdateRequest;
use Technote\CrudHelper\Repositories\CrudRepository;
use Technote\SearchHelper\Models\Traits\Searchable;

class CrudController
{
    /**
     * @param  SearchRequest  $request
     * @param  CrudRepository  $repository
     *
     * @return LengthAwarePaginator|Builder[]|Collection|Model[]|Searchable[]
     */
    public function index(SearchRequest $request, CrudRepository $repository)
    {
        return $repository->all($request->getConditions());
    }

    /**
     * @param $primaryId
     * @param  CrudRepository  $repository
     *
     * @return Eloquent|Eloquent[]|Collection|Model
     */
    public function show($primaryId, CrudRepository $repository)
    {
        return $repository->get($primaryId);
    }

    /**
     * @param  UpdateRequest  $request
     * @param  CrudRepository  $repository
     *
     * @return Eloquent|Model
     */
    public function store(UpdateRequest $request, CrudRepository $repository)
    {
        return $repository->create($request->getData());
    }

    /**
     * @param  UpdateRequest  $request
     * @param  int  $primaryId
     * @param  CrudRepository  $repository
     *
     * @return Eloquent|Model
     */
    public function update(UpdateRequest $request, $primaryId, CrudRepository $repository)
    {
        return $repository->update($primaryId, $request->getData());
    }

    /**
     * @param  int  $primaryId
     * @param  CrudRepository  $repository
     *
     * @return array
     */
    public function destroy($primaryId, CrudRepository $repository)
    {
        return $repository->delete($primaryId);
    }
}