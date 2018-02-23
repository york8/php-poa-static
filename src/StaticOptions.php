<?php
/**
 * User: York <lianyupeng1988@126.com>
 * Date: 2018-01-21 17:01
 */

namespace York8\POA\StaticMiddleware;

class StaticOptions
{
    /**
     * @var string 提供静态文件的根目录
     */
    private $root = '';

    /**
     * @var string 文件名
     */
    private $filename;

    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
     * @return string
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param string $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }
}