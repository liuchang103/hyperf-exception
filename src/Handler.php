<?php
namespace HyperfException;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 判断被捕获到的异常是希望被捕获的异常
        if($throwable instanceof Exception)
        {
            // 阻止异常冒泡
            $this->stopPropagation();
            
            // 自定义处理
            return $throwable->handle($response);
        }

        // 交给下一个异常处理器
        return $response;
    }

    /**
     * 判断该异常处理器是否要对该异常进行处理
     */
    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}