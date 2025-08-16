<?php

namespace Src\Models;

use Src\Core\Model;

class Users extends Model
{
    public function __construct()
    {
        $this->setTable('users_tbl');
    }
}