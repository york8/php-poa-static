# poa-static

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Total Downloads][ico-downloads]][link-downloads]

poa-static 是[POA](https://raw.githubusercontent.com/york8/php-poa)框架的一个中间件，用来处理静态文件的请求

## 作者

- [York](https://github.com/york8)

## 安装
```bash
composer require york8/poa-static
```

## 使用
```php
$app = new Application();

$staticMiddleware = new StaticMiddleware('..');
$staticMiddleware->use(new ProfileMiddleware())->use(new SimpleFilenamePlugin('/static'));

// 定义路由器，将路径 /static 前缀开头的请求交给 StaticMiddleware 处理
$router = new RouterMiddleware(function (Context $context) {
    $context->statusCode(404)->send('Not Found');
});
$router->get('/static', $staticMiddleware);

$app->useErrorMiddleware(function (Throwable $throwable) {
    // 全局未捕获 错误/异常 处理
    fwrite(STDERR, $throwable->getMessage() . "\n");
})
    // 简单请求错误异常处理
    ->use(function (Context $context) {
        try {
            yield;
        } catch (Throwable $exception) {
            fwrite(STDERR, $exception->getMessage() . "\n");
            $context->statusCode(500)->send($exception->getMessage());
        }
    })
    // 使用路由器
    ->use($router);

$app->listen('0.0.0.0:8088');
```

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/york8/poa-static.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/york8/poa-static.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/york8/poa-static
[link-downloads]: https://packagist.org/packages/york8/poa-static