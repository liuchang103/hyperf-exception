## hyperf-sanctum
Hyperf 的异常错误处理，有 Json 和 View 自定义渲染

## 安装

#### 引入包
```
composer require liuchang103/hyperf-exception
```

## 使用

#### 直接抛出 Json
```
throw new \HyperfException\Json('Error', -1);

// 输出
{"code":-1,"message":"Error"}
```

#### 直接抛出 View 视图
```
throw new \HyperfException\View('Error', '404');

// 将抛出 404 的视图文件
```

## 进阶

#### 继承 Json

使用常量约定 code 码，让控制器中消失 “数字”
```
namespace App\Exception;

class Success extends \HyperfException\Json
{
    const CODE = 100;
}

// 抛出
throw new \App\Exception\Success('Created Success');

// 输出
{"code":100,"message":"Created Success"}
```

定义 Http 状态码
```
class Error extends \HyperfException\Json
{
    const CODE = 200;
    const HTTP_STATUS = 500;
}

// 抛出
throw new \App\Exception\Error('Created Error');

// 将抛出 500 的 Http 状态
{"code":200,"message":"Created Error"}
```

#### 继承 View
使用常量约定 VIEW，让控制器中消失 “模版名”
```
namespace App\Exception;

class Miss extends \HyperfException\Json
{
    const VIEW = '404';
}

// 抛出
throw new \App\Exception\Miss('找不到存在的页面');

// 视图文件 404.blade.php
<h1> {{ $message }} </h1>
```

定义 Http 状态码
```
class Miss extends \HyperfException\Json
{
    const VIEW = '404';
    const HTTP_STATUS = 404;
}

// 抛出
throw new \App\Exception\Miss('找不到存在的页面');
```

## 自定义处理

如果需要自定义渲染，可继承 \HyperfException\Exception 并实现 render 方法，会接收 response 的对象
```
use \HyperfException\Exception;
use Hyperf\HttpMessage\Stream\SwooleStream;

class Message extends Exception
{
    const HTTP_STATUS = 202;
    
    // 自定义渲染
    public function render($response)
    {
        return $response->withBody(new SwooleStream($this->getMessage() . $this->getCode()));
    }
}

// 抛出
throw new \App\Exception\Message('自定义渲染', 1);

// 输出 202 的状态页面
自定义渲染1
```

HTTP_STATUS 状态码是在更深一层的自定义处理中.

如果要自定义处理，可实现 handle 方法，同样会接收 response 的对象 

(注意：实现 handle 方法后，HTTP_STATUS 常量将无效)
```
public function handle($response)
{
    return $response->withBody(new SwooleStream($this->getMessage() . $this->getCode()));
}

// 输出 200 正常状态的页面
自定义渲染1
```
