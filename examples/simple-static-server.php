<?php
/**
 * User: York <lianyupeng1988@126.com>
 * Date: 2018-01-25 18:09
 */

require '../vendor/autoload.php';

use York8\POA\Application;
use York8\POA\Context;
use York8\POA\Middleware\ProfileMiddleware;
use York8\POA\Middleware\RouterMiddleware;
use York8\POA\StaticMiddleware\Plugins\SimpleFilenamePlugin;
use York8\POA\StaticMiddleware\StaticMiddleware;

try {
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
} catch (Throwable $exception) {
    fwrite(STDERR, $exception->getMessage());
}
