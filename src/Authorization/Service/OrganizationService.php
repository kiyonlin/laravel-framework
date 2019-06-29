<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 11:17 PM
 */

namespace Kiyon\Laravel\Authorization\Service;


use Illuminate\Support\Collection;
use Kiyon\Laravel\Authorization\Contracts\OrganizationRepositoryContract;
use Kiyon\Laravel\Foundation\Service\RestfulService;
use Kiyon\Laravel\Support\Constant;

class OrganizationService
{

    use RestfulService;

    /** @var OrganizationRepositoryContract $repo */
    protected $repo;

    public function __construct(OrganizationRepositoryContract $repo)
    {
        $this->repo = $repo;
    }

    /**
     * 获取 NgZorro 组织树
     *
     * @return array
     */
    public function getNgZorroOrganizationTree()
    {
        $organizations = $this->repo->all()->sortBy('sort');

        return $this->generateNgZorroOrganizationTree($organizations);
    }

    /**
     * 生成 NgZorro 结构的组织树
     *
     * @param Collection $organizations
     * param array $indirectOrganizationIds
     * param array $editableIds
     * @param int        $parent_id
     *
     * @return array
     */
    private function generateNgZorroOrganizationTree(
        Collection $organizations, $parent_id = Constant::ORGANIZATION_ROOT_ID)
    {
        $root = [];

        foreach ($this->subOrganizations($organizations, $parent_id) as $organization) {
            $child = [
                'key'   => $organization->id,
                'title' => $organization->display_name,
            ];

            if (count($this->subOrganizations($organizations, $currentId = $organization->id))) {
                $child['children'] = $this->generateNgZorroOrganizationTree($organizations, $currentId);
            } else {
                $child['isLeaf'] = true;
            }

            $root[] = $child;
        }

        return $root;
    }

    /**
     * 过滤给定组织id的子组织
     *
     * @param Collection $organizations
     * @param int        $parent_id
     *
     * @return Collection
     */
    private function subOrganizations(Collection $organizations, $parent_id)
    {
        return $organizations
            ->filter(function ($organization) use ($parent_id) {
                return $organization->parent_id == $parent_id;
            });
    }
}