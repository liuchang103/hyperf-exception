<?php
namespace HyperfException;

use Psr\Http\Message\ResponseInterface;
use Hyperf\View\RenderInterface;
use Hyperf\Utils\ApplicationContext;

class View extends Exception
{
    // 视图文件
    const VIEW = 'index';
    
    // 视图文件
    protected $view;
    
    // 携带状态码
    public function __construct($message, $view = null)
    {
        parent::__construct($message);
        
        $this->view = $view ?? static::VIEW;
    }
    
    // 视图渲染
    public function render(ResponseInterface $response)
    {
        $render = ApplicationContext::getContainer()->get(RenderInterface::class);
        
        return $render->render($this->view, $this->view());
    }

    // 自定义视图参数
    protected function view()
    {
        return [
            'message' => $this->getMessage()
        ];
    }
}