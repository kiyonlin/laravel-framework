<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 10:32 AM
 */

namespace Kiyon\Laravel\Authorization\Contracts;


interface GrantOrganizationContract
{

    /**
     * Many-to-Many relations with Organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations();

    /**
     * Save the inputted organizations.
     *
     * @param mixed $organizations
     *
     * @param array $pivot
     * @return void
     */
    public function syncOrganizations($organizations, $pivot = []);

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $organizations
     * @param array $pivot
     * @return void
     */
    public function attachOrganizations($organizations, $pivot = []);


    /**
     * Detach multiple organizations from users
     *
     * @param mixed $organizations
     */
    public function detachOrganizations($organizations);
}