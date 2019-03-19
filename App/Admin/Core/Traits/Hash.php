<?php

namespace App\Admin\Core\Traits;

trait Hash
{
    /**
     * @param string $param
     * @return string
     */
    public function hashString($param):string
    {
        return sha1($param);
    }

    /**
     * @param int $param
     * @return string
     */
    public function hashInt($param):string
    {
        return sha1($param);
    }
}