<?php

namespace Src\Models;

use Src\Core\Model;

class Classes extends Model
{
    public function __construct()
    {
        $this->setTable('classes_tbl');
    }
}