<?php
declare(strict_types=1);
namespace App\Controllers;



use App\App;
use App\Models\Invoice;
use App\Models\User;
use App\View;
use mysql_xdevapi\Exception;

class HomeController
{
    public function index() : View
    {
        $db = App::db();
//            $email = $_GET["email"];
//            $query = "SELECT * FROM users where email = :email;";
//
//            $statement = $db->prepare($query);
//            $statement->bindValue(":email", $email);
//            $statement->execute();
//
//            var_dump($query);
//
//            $data = $statement->fetchAll();
//            if(!$data)
//            {
//                var_dump("not exist any data...");
//                exit();
//            }
//            foreach ($data as $user) {
//                echo "<pre>";
//                var_dump($user);
//                echo "</pre>";
//            }
//
//            $email = $_GET["email"];
//            $fullname = explode("@", $email)[0];
//            $is_active = true;
//
//            $query = "INSERT INTO users(email, full_name, is_active, created_at) VALUES (:email, :full_name, :is_active, now())";
//
//            $statement = $db->prepare($query);
//            $statement->bindParam(":email", $email);
//            $statement->bindParam(":full_name", $fullname);
//            $statement->bindParam(":is_active", $is_active, \PDO::PARAM_BOOL);
//
//            $statement->execute();
//
//            $user_id = (int)$db->lastInsertId();
//
//            $user_query = "SELECT * FROM users WHERE id = :id";
//            $user = $db->prepare($user_query);
//            $user->bindParam(":id", $user_id, \PDO::PARAM_INT);
//            $user->execute();
//            var_dump($user->fetch());

//            TRANSACTION IN PDO
            $email = $_GET["email"];
            $full_name = explode("@", $email)[0];
            $invId = null;
            $user = new User();
            $invoice = new Invoice();

            try {
                $db->beginTransaction();
                $userId = $user->create($email, $full_name);

                $invId = $invoice->create(200, $userId);
                $db->commit();
            } catch (\Throwable $ex)
            {
                var_dump($ex->getMessage());
                if($db->inTransaction())
                {
                    $db->rollBack();
                }
            }

//
//            $getUserInvoice = $db->prepare("SELECT * FROM users as us JOIN invoices as inv ON us.id = inv.user_id and us.email = ?");
//
//            $getUserInvoice->execute([$email]);

//            echo "<pre>";
//            var_dump($getUserInvoice->fetch());
//            echo "</pre>";

        var_dump($invoice->find($invId)['full_name']);

        return View::make("home/index", ["invoice" => $invoice->find($invId)]);
    }

    public function upload()
    {
        foreach ($_FILES['file']["name"] as $key => $filename) {
            $filePath = STORAGE_PATH . "/" . $filename;
            move_uploaded_file($_FILES['file']['tmp_name'][$key], $filePath);
        }

        header("Location: /");
        exit;
    }
}