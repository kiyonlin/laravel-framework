<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 11:40 AM
 */

namespace Kiyon\Laravel\Foundation\Service;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait RestfulService
{

    /**
     * @param Builder|null $builder
     * @return \Illuminate\Database\Eloquent\Collection|Model[]|mixed
     */
    public function all(Builder $builder = null)
    {
        if (property_exists($this, 'repo')) {
            return $this->repo->all($builder);
        }
        return null;
    }


    /**
     * @param array $item
     * @return mixed
     */
    public function create(array $item)
    {
        if (property_exists($this, 'repo')) {
            return $this->repo->create($item);
        }
        return null;
    }

    /**
     * @param Model $item
     * @param array $data
     * @return Model|mixed
     */
    public function update(Model $item, array $data)
    {
        if (property_exists($this, 'repo')) {
            return $this->repo->update($item, $data);
        }
        return null;
    }

    /**
     * @param Model $item
     * @return Model|mixed
     */
    public function show(Model $item)
    {
        if (property_exists($this, 'repo')) {
            return $this->repo->show($item);
        }
        return null;
    }

    /**
     * @param Model $item
     * @param array $data
     * @return bool|null|int
     * @throws \Exception
     */
    public function destroy(Model $item, array $data = [])
    {
        if (property_exists($this, 'repo')) {
            return $this->repo->destroy($item, $data);
        }
        return null;
    }

}