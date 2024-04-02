<?php

namespace App\Models;

use App\Model;

class Invoice extends Model
{
    public function create(float $amount, int $user_id) : int
    {
        $query = "INSERT INTO invoices(amount, user_id) VALUES (:amount, :user_id)";

        $statement = $this->db->prepare($query);
        $statement->bindValue(":amount", $amount);
        $statement->bindValue(":user_id", $user_id, \PDO::PARAM_INT);

        $statement->execute();

        return (int)$this->db->lastInsertId();
    }

    public function find(int $invoiceId)
    {
        $query = "SELECT inv.id, us.full_name, us.email FROM users as us JOIN invoices as inv ON us.id = inv.user_id WHERE inv.id = ?";

        $statement = $this->db->prepare($query);
        $statement->execute([$invoiceId]);
        $invoice = $statement->fetch();
        return $invoice ?: [];
    }
}