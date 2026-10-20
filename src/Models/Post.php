<?php

namespace App\Models;

class Post extends BaseModel
{
    public function __construct(\Database $database)
    {
        parent::__construct($database, 'publicaciones');
    }

    public function search(string $term): ?array
    {
        $pattern = '%' . $term . '%';

        return $this->database->fetchAll(
            'SELECT * FROM `publicaciones` WHERE `titulo` LIKE ? OR `categoria` LIKE ?',
            [$pattern, $pattern]
        );
    }
}
