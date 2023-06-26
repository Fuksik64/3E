<?php

namespace App\Models;

class AddressBook extends Model
{
    protected string $table = 'address_book';

    public function createTable(): void
    {
        $query = "CREATE TABLE IF NOT EXISTS {$this->table} (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                firstname VARCHAR(64) NOT NULL,
                lastname VARCHAR(64) NOT NULL,
                phone VARCHAR(64) NOT NULL,
                email  VARCHAR(64) NULL,
                address VARCHAR(64) NULL
            );";
        $this->db->exec($query);
    }

    public function store(array $data): void
    {
        $query = "INSERT INTO {$this->table} (firstname, lastname, phone, email, address) VALUES (:firstname, :lastname, :phone, :email, :address)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':firstname', $data['firstname'], SQLITE3_TEXT);
        $stmt->bindValue(':lastname', $data['lastname'], SQLITE3_TEXT);
        $stmt->bindValue(':phone', $data['phone'], SQLITE3_TEXT);
        $stmt->bindValue(':email', $data['email'], SQLITE3_TEXT);
        $stmt->bindValue(':address', $data['address'], SQLITE3_TEXT);
        $stmt->execute();
    }

    public function destroy(int $id): void
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->execute();
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute();
        $rows = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }
}