<?php

namespace Admin\Core\Traits;


trait RequestDateTrait
{
    public function createdAt()
    {
        return (new \DateTime())->format('Y-m-d H:i:s');
    }

    public function updatedAt()
    {
        return (new \DateTime())->format('Y-m-d H:i:s');

    }
}
