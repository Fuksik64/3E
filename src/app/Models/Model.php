<?php

namespace App\Models;

use SQLite3;

class Model
{
    protected SQLite3 $db;

    public function __construct()
    {
        $this->db = new SQLite3(database_path('sqlite' . '.db', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE));
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function getByColumn(string $table, string $column, mixed $value): array
    {
        $query = "SELECT * FROM {$table} WHERE {$column} = :{$column}";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":{$column}", $value, SQLITE3_TEXT);
        $result = $stmt->execute();
        $rows = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }
}