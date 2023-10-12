<?php

namespace App\Services;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\CoreHasCacheableTrait;
use Prettus\Repository\Eloquent\BaseRepository;

class BaseService
{

    use CoreHasCacheableTrait;

    /**
     * @var int
     */
    protected $limit = 12;

    /**
     * @var array
     */
    protected $filter = [];

    /**
     * @var array
     */
    protected $search = [];

    /**
     * List field allow search
     *
     * @var array
     */
    protected $allowSearchByField = [];

    /**
     * @var string
     */
    protected $sort = 'updated_at';

    /**
     * @var string
     */
    protected $dir = 'DESC';

    protected $baseRepository;

    protected $request;

    protected $allowPolicies = [];

    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
        $this->sort = request()->query('sort', 'updated_at');
        $this->dir = request()->query('dir', 'DESC');
    }

    public function setAllowPolicyMethods($method = [])
    {
        $this->allowPolicies = $method;
    }

    /**
     * Check authorize user allow call method
     *
     * @param string $method
     * @param integer $id
     * @return bool
     */
    public function authorize($method, $id)
    {
        $item = $this->baseRepository->getModel()->find($id);
        abort_if(!auth()->check() || auth()->user()->cannot($method, $item), 403);
    }

    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $collection = $this->baseRepository->all();
        return $collection;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

    /**
     * Get all data with options
     *
     * Display a listing of the resource.
     */
    public function getOptions()
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->paginate($this->limit, ['id', 'name']);
        return $collection;
    }

    /**
     * Display the specified resource.
     *
     */
    public function find($id)
    {
        $item = $this->baseRepository->find($id);
        return $item;
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $item = $this->baseRepository->create($data);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     *
     */
    public function update(Request $request, $id)
    {
        try {
            if (in_array('update', $this->allowPolicies)) {
                $this->authorize('update', $id);
            }
            DB::beginTransaction();
            $data = $request->all();
            $item = $this->baseRepository->update($data, $id);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     */
    public function delete($id)
    {
        try {
            //code...
            if (in_array(
                'delete',
                $this->allowPolicies
            )) {
                $this->authorize('update', $id);
            }
            DB::beginTransaction();
            $deleted = $this->baseRepository->delete($id);
            DB::commit();
            return $deleted;
        } catch (Exception $e) {
            DB::rollBack();
            //throw $th;
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     */
    public function massDelete(array $ids)
    {
        try {
            //code...
            DB::beginTransaction();
            $deleted = $this->baseRepository->whereIn('id', $ids)->delete();
            DB::commit();
            return $deleted;
        } catch (Exception $e) {
            DB::rollBack();
            //throw $th;
            throw $e;
        }
    }

    public function getMetaSEO($alias, $columns = ['id', 'alias', 'name'])
    {
        $key = $this->getCacheKey('getMetaSEO');
        // return $this->baseRepository->findWhere(['alias' => $alias], $columns)->first();
        $item = Cache::remember($key, 6000, function () use ($alias, $columns) {
            return $this->baseRepository->findWhere(['alias' => $alias], $columns)->first();
        });

        return $item;
    }
}
