<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 9:15 AM
 */

namespace Kiyon\Laravel\Authorization\Traits;


use Illuminate\Support\Collection;

trait GrantOrganization
{

    /**
     * sync organizations.
     *
     * @param array|object|int $organizations
     *
     * @param array            $pivot
     *
     * @return void
     */
    public function syncOrganizationsWithoutDetaching($organizations)
    {
        $this->syncOrganizations($organizations, false);
    }

    /**
     * sync organizations without detaching.
     *
     * @param array|object|int $organizations
     *
     * @param array            $pivot
     *
     * @return void
     */
    public function syncOrganizations($organizations, $detaching = true)
    {
        $this->organizations()->sync($organizations, $detaching);
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $organizations
     * @param array $pivot
     *
     * @return void
     */
    public function attachOrganizations($organizations, $pivot = [])
    {
        if ($organizations instanceof Collection) {
            $this->organizations()->attach($organizations);
        } else {
            $this->organizations()->attach($organizations, $pivot);
        }
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $organizations
     *
     * @return void
     */
    public function detachOrganizations($organizations)
    {
        $this->organizations()->detach($organizations);
    }
}