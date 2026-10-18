<?php
require_once __DIR__ . '/../config/Database.php';

class User {

    private $conn;

    public function __construct(){

        $db = new Database();
        $this->conn = $db->connect();
    }

    public function login($username,$password){

        $password = md5($password);

        $query = mysqli_query($this->conn,
            "SELECT * FROM users
             WHERE username='$username'
             AND password='$password'");

        return mysqli_fetch_assoc($query);
    }

    public function getSales(){

        return mysqli_query($this->conn,
            "SELECT * FROM users
             WHERE role != 'admin'");
    }

    public function totalKaryawan(){

        $query = mysqli_query($this->conn,
            "SELECT COUNT(*) as total
             FROM users
             WHERE role != 'admin'");

        $data = mysqli_fetch_assoc($query);

        return $data['total'];
    }

    public function hapus($id){

    return mysqli_query($this->conn,
        "DELETE FROM users
         WHERE id='$id'");
}
}
?>