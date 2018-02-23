<?php
/**
 * User: York <lianyupeng1988@126.com>
 * Date: 2018-01-21 16:58
 */

namespace York8\POA\StaticMiddleware;

use York8\POA\Context;
use York8\POA\Middleware\MiddlewareInterface;
use York8\POA\Middleware\MiddlewaresTrait;

class StaticMiddleware implements MiddlewareInterface
{
    const ATTR_OPTIONS_NAME = 'staticOptions';

    use MiddlewaresTrait;

    /**
     * @var string
     */
    private $root;

    /**
     * StaticServer constructor.
     * @param string $root 静态文件根目录
     */
    public function __construct($root)
    {
        $this->root = $root;
    }

    public function handle(Context $context)
    {
        /**
         * @var StaticOptions $options
         */
        $options = $context->attr(self::ATTR_OPTIONS_NAME);
        $filename = $options->getFilename();
        if (is_file($filename) && is_readable($filename)) {
            $context->send(file_get_contents($filename));
            return false;
        }
        return null;
    }

    /**
     * @param Context $context 请求上下文
     * @return null|false
     */
    public function __invoke(Context $context)
    {
        $options = new StaticOptions($this->root);
        $context->attr(self::ATTR_OPTIONS_NAME, $options);
        return $this->run($context);
    }
}