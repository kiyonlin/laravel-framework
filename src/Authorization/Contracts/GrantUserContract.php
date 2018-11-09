<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 10:32 AM
 */

namespace Kiyon\Laravel\Authorization\Contracts;


interface GrantUserContract
{

    /**
     * Many-to-Many relations with the user model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users();

    /**
     * sync users.
     *
     * @param mixed $users
     * @param array $pivot
     * @return void
     */
    public function syncUsers($users, $pivot = []);

    /**
     * Attach multiple users to organizations
     *
     * @param mixed $users
     * @param array $pivot
     * @return
     */
    public function attachUsers($users, $pivot = []);

    /**
     * Detach multiple users from organizations
     *
     * @param mixed $users
     */
    public function detachUsers($users);
}