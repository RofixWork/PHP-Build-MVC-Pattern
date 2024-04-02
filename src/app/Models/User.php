<?php

namespace App\Models;

use App\Model;

class User extends Model
{
    public function create(string $email, string $full_name, bool $is_active = true) : int
    {
        $query = "INSERT INTO users(email, full_name, is_active, created_at) VALUES (:email, :full_name, :is_active, NOW())";

        $statement = $this->db->prepare($query);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":full_name", $full_name);
        $statement->bindValue(":is_active", $is_active, \PDO::PARAM_BOOL);

        $statement->execute();

        return (int)$this->db->lastInsertId();
    }
}