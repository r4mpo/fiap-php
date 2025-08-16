<?php

namespace Src\Models;

use Src\Core\Model;

class Registrations extends Model
{
    public function __construct()
    {
        $this->setTable('classes_students_tbl');
    }
}