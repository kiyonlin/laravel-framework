<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/20
 * Time: 9:19 AM
 */

namespace Kiyon\Laravel\Member\Controller;


use Kiyon\Laravel\Foundation\Routing\Controller;
use Kiyon\Laravel\Member\Model\Member;
use Kiyon\Laravel\Member\Request\MemberRequest;
use Kiyon\Laravel\Member\Resource\MemberResource;
use Kiyon\Laravel\Member\Service\MemberService;

class MemberController extends Controller
{

    /** @var MemberService */
    protected $service;

    public function __construct(MemberService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $members = $this->service->repo->all();

        return MemberResource::collection($members);
    }

    /**
     * @param MemberRequest $request
     * @return MemberResource
     */
    public function store(MemberRequest $request)
    {
        $data = request()->all();

        $member = $this->service->repo->create($data);

        return new MemberResource($member);
    }

    /**
     * @param Member $member
     * @return MemberResource
     */
    public function show(Member $member)
    {
        $member = $this->service->repo->show($member);

        return new MemberResource($member);
    }

    /**
     * @param Member $member
     * @param MemberRequest $request
     * @return MemberResource
     */
    public function update(Member $member, MemberRequest $request)
    {
        $data = request()->all();

        $member = $this->service->repo->update($member, $data);

        return new MemberResource($member);
    }

    /**
     * @param Member $member
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Member $member)
    {
        $data = request()->all();

        $this->service->repo->destroy($member, $data);

        return $this->respondNoContent();
    }
}