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
use Kiyon\Laravel\Member\Service\MemberService;

class MemberController extends Controller
{
    /** @var MemberService */
    protected $service;

    public function __construct(MemberService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $members = $this->service->repo->all();

        return $this->respond($members);
    }

    /**
     * @param MemberRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MemberRequest $request)
    {
        $data = request()->all();

        $member = $this->service->repo->create($data);

        return $this->respondCreated($member->load('roles'));
    }

    /**
     * @param Member $member
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Member $member)
    {
        $member = $this->service->repo->edit($member);

        return $this->respond($member);
    }

    /**
     * @param Member $member
     * @param MemberRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Member $member, MemberRequest $request)
    {
        $data = request()->all();

        $member = $this->service->repo->update($member, $data);

        return $this->respond($member);
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