<?php

namespace Src\Models;

use Src\Core\Model;

class Students extends Model
{
    public function __construct()
    {
        $this->setTable('students_tbl');
    }
}