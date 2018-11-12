<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 11:28 AM
 */

namespace Kiyon\Laravel\Contracts\Repository;


use Illuminate\Database\Eloquent\Model;

interface RestfulRepositoryContract
{

    /**
     * fetch all items with data
     *
     * @param $data
     * @return mixed
     */
    public function all($data);

    /**
     * show item info to edit
     *
     * @param Model $item
     * @return mixed
     */
    public function edit(Model $item);

    /**
     * create an item
     *
     * @param array $item
     * @return mixed
     */
    public function create(array $item);

    /**
     * update an item
     *
     * @param Model $item
     * @param array $data
     * @return mixed
     */
    public function update(Model $item, array $data);

    /**
     * destroy an item or items
     *
     * @param Model $item
     * @param array $data
     * @return mixed
     */
    public function destroy(Model $item, array $data = []);
}