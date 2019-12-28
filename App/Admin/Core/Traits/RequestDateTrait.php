<?php

namespace Admin\Core\Traits;


trait RequestDateTrait
{
    public function createAt()
    {
        return (new \DateTime())->format('Y-m-d H:i:s');
    }

    public function updateAt()
    {
        return (new \DateTime())->format('Y-m-d H:i:s');

    }
}
