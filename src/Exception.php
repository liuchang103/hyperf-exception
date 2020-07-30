<?php
namespace HyperfException;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Server\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

class Exception extends ServerException
{
    // HTTP 状态码
    const HTTP_STATUS = 200;
    
    // 自定义处理异常
    public function handle(ResponseInterface $response)
    {
        return $this->render($response)->withStatus(static::HTTP_STATUS);
    }
    
    // 自定义渲染方法
    public function render(ResponseInterface $response)
    {
        return $response->withBody(new SwooleStream($this->getMessage()));
    }
}