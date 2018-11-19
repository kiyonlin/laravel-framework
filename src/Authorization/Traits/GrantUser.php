<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 9:15 AM
 */

namespace Kiyon\Laravel\Authorization\Traits;


use Illuminate\Support\Collection;

trait GrantUser
{

    /**
     * Save the inputted users.
     *
     * @param mixed $users
     *
     * @param array $pivot
     * @return void
     */
    public function syncUsers($users, $pivot = [])
    {
        if ($users instanceof Collection) {
            $this->users()->sync($users);
        } else {
            $this->users()->sync($users, $pivot);
        }
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $users
     * @param array $pivot
     */
    public function attachUsers($users, $pivot = [])
    {
        if ($users instanceof Collection) {
            $this->users()->attach($users);
        } else {
            $this->users()->attach($users, $pivot);
        }
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $users
     */
    public function detachUsers($users)
    {
        $this->users()->detach($users);
    }
}