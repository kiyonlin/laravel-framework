<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 11:40 AM
 */

namespace Kiyon\Laravel\Foundation\Repository;


use Illuminate\Database\Eloquent\Model;

trait RestfulRepository
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Model[]|mixed
     */
    public function all()
    {
        $queryBuilder = $this->model->filter();

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
    public function edit(Model $item)
    {
        return $item;
    }

    /**
     * @param Model $item
     * @param array $data
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(Model $item, array $data = [])
    {
        return $item->delete();
    }
}