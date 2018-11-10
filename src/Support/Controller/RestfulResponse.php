<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/8
 * Time: 3:00 PM
 */

namespace Kiyon\Laravel\Support\Controller;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait RestfulResponse
{

    protected $statusCode = SymfonyResponse::HTTP_OK;

    /**
     * 响应成功操作
     *
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respond($data, $header = [])
    {
        return Response::json($data, $this->getStatusCode(), $header);
    }

    /**
     * 响应错误操作
     *
     * @param $message
     * @return mixed
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message'     => $message,
                'status_code' => $this->getStatusCode()
            ]
        ], $this->getStatusCode());
    }

    /**
     * 资源已创建并返回
     *
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respondCreated($data, $header = [])
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_CREATED)
            ->respond($data, $header);
    }

    /**
     * 已接受请求，用于任务创建
     *
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respondAccepted($data, $header = [])
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_ACCEPTED)
            ->respond($data, $header);
    }

    /**
     * 资源删除成功
     *
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respondNoContent()
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_NO_CONTENT)
            ->respond([]);
    }

    /**
     * 响应请求错误
     *
     * @param string $message
     * @return mixed
     */
    public function respondBadRequest($message = 'Bad Request')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_BAD_REQUEST)
            ->respondWithError($message);
    }

    /**
     * 响应未找到资源错误
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_NOT_FOUND)
            ->respondWithError($message);
    }

    /**
     * 响应认证失败错误
     *
     * @param string $message
     * @return mixed
     */
    public function respondUnauthorised($message = 'Unauthorised')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_UNAUTHORIZED)
            ->respondWithError($message);
    }

    /**
     * 响应没有权限错误
     *
     * @param string $message
     * @return mixed
     */
    public function respondForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_FORBIDDEN)
            ->respondWithError($message);
    }

    /**
     * 响应服务器内部错误
     *
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Server Error')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithError($message);
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}