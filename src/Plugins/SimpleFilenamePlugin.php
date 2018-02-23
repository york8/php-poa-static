<?php
/**
 * User: York <lianyupeng1988@126.com>
 * Date: 2018-01-28 22:30
 */

namespace York8\POA\StaticMiddleware\Plugins;

use York8\POA\Context;
use York8\POA\Middleware\MiddlewareInterface;
use York8\POA\StaticMiddleware\StaticMiddleware;
use York8\POA\StaticMiddleware\StaticOptions;

/**
 * 默认自带的简单文件名转换插件
 * @package Plugins
 */
class SimpleFilenamePlugin implements MiddlewareInterface
{
    /**
     * @var string
     */
    private $publicPrefix = '';

    public function __construct($publicPrefix)
    {
        $this->publicPrefix = $publicPrefix;
    }

    /**
     * @param Context $context 请求上下文
     */
    public function __invoke(Context $context)
    {
        /**
         * @var StaticOptions $options
         */
        $options = $context->attr(StaticMiddleware::ATTR_OPTIONS_NAME);
        $request = $context->getRequest();
        $urlPath = $request->getUri()->getPath();
        $name = $filename = $this->getFilename($urlPath);
        $filename = $this->joinPath($options->getRoot(), $name);
        $options->setFilename($filename);
    }

    private function getFilename($urlPath)
    {
        $prefix = $this->publicPrefix;
        $filename = preg_replace('#^' . $prefix . '/?#i', '', $urlPath);
        return $filename;
    }

    private function joinPath($path, ...$parts)
    {
        foreach ($parts as $i => &$p) {
            if ($p[0] !== '/') {
                $path .= '/';
            }
            $path .= $p;
        }
        return $path;
    }
}