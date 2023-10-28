<?php


namespace Modules\Core\Services;

use App\Models\Interfaces\FilterableModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CollectionService
 * Provide some utility function for sort and pagination and functions related to the collections responses
 *
 * @package App\Services
 * @version 1.0
 */
class CollectionService
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var
     */
    private $queryBuilder;


    /**
     * @var FilterableModel
     */
    private FilterableModel $modelClass;

    /**
     * @param $method
     */
    public function initializeForm($method)
    {
        switch ($method){
            case 'unAssign' :
                $group = DB::table('form_formGroup')->select('form_uuid')->pluck('form_uuid')->whereNotNull()->toArray();
                $form = $this->queryBuilder->pluck('uuid')->toArray();
                $filters = array_diff($form, $group);
                $this->queryBuilder->whereIn('uuid', $filters);
                break;
            default :
                break;
        }
    }

    /**
     * Read the sort_by parameter from the request and sort the specified model with that
     *
     * @return void
     */
    public function initializeSort(): void
    {
        $sortBy = $this->request->get('sort_by' , '-created_at');
        if ($sortBy) {
            if (substr($sortBy, 0, 1) === '-') {
                $this->queryBuilder->orderByDesc(substr($sortBy, 1));
            } else {
                $this->queryBuilder->orderBy($sortBy);
            }
        }
    }

    /**
     * Use the specified filter data in the request and add some search conditions in the provided query
     *
     * @return void
     */
    public function initializeFilter(): void
    {
        $filterData = $this->request->get('filter', []);
        $searchFields = $this->modelClass->getSearchFields();
        $filterFields = $this->modelClass->getFilterFields();

        if (isset($filterData['search'])) {
            $searchInput = $filterData['search'];
            unset($filterData['search']);

            $this->queryBuilder->where(function (Builder $query) use ($searchInput, $searchFields) {
                foreach ($searchFields as $field) {
                    $query->orWhere($field, 'like', '%'.  $searchInput . '%');
                }
            });

        }

        if (isset($filterData['deleted_at'])) {
            $searchInput = $filterData['deleted_at'];
            unset($filterData['deleted_at']);
            $this->queryBuilder->onlyTrashed();
        }

        if (count($filterData) > 0) {
            foreach ($filterData as $field => $datum) {
                if (in_array($field, $filterFields)) {
                    $this->queryBuilder->where($field, $datum);
                }
            }
        }
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @param $queryBuilder
     */
    public function setQueryBuilder($queryBuilder): void
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param string $modelClass
     */
    public function setModelClass(string $modelClass): void
    {
        $this->modelClass = new $modelClass;
    }
}
