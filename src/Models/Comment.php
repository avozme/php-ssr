<?php

namespace App\Models;

class Comment extends BaseModel
{
    public function __construct(\Database $database)
    {
        parent::__construct($database, 'comentarios');
    }
}
