<?php

namespace App\Traits;

trait TimestampableTrait
{
    public function beforeValidationOnCreate()
    {
        $this->created_at = $this->created_at ?? date('Y-m-d H:i:s');
        $this->modified_at = $this->modified_at ?? date('Y-m-d H:i:s');
    }

    public function beforeValidationOnUpdate()
    {
        $this->modified_at = date('Y-m-d H:i:s');
    }
}
