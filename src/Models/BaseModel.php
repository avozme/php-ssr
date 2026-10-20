<?php

namespace App\Models;

use InvalidArgumentException;

abstract class BaseModel
{
    protected \Database $database;
    private string $table;

    public function __construct(\Database $database, string $table)
    {
        $this->database = $database;
        $this->table = $this->quoteIdentifier($table);
    }

    public function getAll(): ?array
    {
        return $this->database->fetchAll("SELECT * FROM {$this->table}");
    }

    public function getById(int $id): ?array
    {
        return $this->database->fetchOne(
            "SELECT * FROM {$this->table} WHERE `id` = ?",
            [$id]
        );
    }

    public function delete(int $id): void
    {
        $this->database->query(
            "DELETE FROM {$this->table} WHERE `id` = ?",
            [$id]
        );
    }

    public function insert(array $data): void
    {
        if ($data === []) {
            throw new InvalidArgumentException('Insert data cannot be empty.');
        }

        $columns = array_map(
            fn ($column): string => $this->quoteIdentifier($column),
            array_keys($data)
        );
        $placeholders = array_fill(0, count($data), '?');

        $this->database->query(
            sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                $this->table,
                implode(', ', $columns),
                implode(', ', $placeholders)
            ),
            array_values($data)
        );
    }

    public function update(int $id, array $data): void
    {
        if ($data === []) {
            throw new InvalidArgumentException('Update data cannot be empty.');
        }

        $assignments = [];
        foreach (array_keys($data) as $column) {
            $assignments[] = $this->quoteIdentifier($column) . ' = ?';
        }

        $this->database->query(
            sprintf(
                'UPDATE %s SET %s WHERE `id` = ?',
                $this->table,
                implode(', ', $assignments)
            ),
            [...array_values($data), $id]
        );
    }

    private function quoteIdentifier(string $identifier): string
    {
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $identifier)) {
            throw new InvalidArgumentException('Invalid SQL identifier.');
        }

        return "`{$identifier}`";
    }
}
