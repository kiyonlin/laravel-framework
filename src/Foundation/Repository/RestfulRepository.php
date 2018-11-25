<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 11:40 AM
 */

namespace Kiyon\Laravel\Foundation\Repository;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait RestfulRepository
{

    /**
     * @param Builder|null $builder
     * @return \Illuminate\Database\Eloquent\Collection|Model[]|mixed
     */
    public function all(Builder $builder = null)
    {
        $builder = $builder ?: $this->model;

        $queryBuilder = $builder->filter();

        if (request()->has('page') && request()->has('perPage')) {
            $result = $queryBuilder->paginate(request('perPage', ['*'], 'page', request('page')));
        } else {
            $result = $queryBuilder->get();
        }

        return $result;
    }


    /**
     * @param array $item
     * @return mixed
     */
    public function create(array $item)
    {
        return $this->model->create($item);
    }

    /**
     * @param Model $item
     * @param array $data
     * @return Model|mixed
     */
    public function update(Model $item, array $data)
    {
        $item->update($data);

        return $item;
    }

    /**
     * @param Model $item
     * @return Model|mixed
     */
    public function show(Model $item)
    {
        return $item;
    }

    /**
     * @param Model $item
     * @param array $data
     * @return bool|null|int
     * @throws \Exception
     */
    public function destroy(Model $item, array $data = [])
    {
        $ids = $this->getIds($data);

        if (count($ids)) {
            return $this->model->destroy($ids);
        }

        return $item->delete();
    }

    /**
     * @param array $data
     * @return array|mixed
     */
    private function getIds(array $data)
    {
        $ids = array_get($data, 'ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        return $ids;
    }
}