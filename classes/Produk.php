<?php
require_once __DIR__ . '/../config/Database.php';

class Produk {

    private $conn;

    public function __construct(){

        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll(){

        return mysqli_query($this->conn,
            "SELECT * FROM produk
             ORDER BY id DESC");
    }
    public function search($keyword){

    return mysqli_query($this->conn,
        "SELECT * FROM produk
         WHERE nama_produk LIKE '%$keyword%'
         ORDER BY id DESC");
    }

    public function totalProduk(){

        $query = mysqli_query($this->conn,
            "SELECT COUNT(*) as total
             FROM produk");

        $data = mysqli_fetch_assoc($query);

        return $data['total'];
    }

    public function getBySales($sales_id){

        return mysqli_query($this->conn,
            "SELECT * FROM produk
             WHERE sales_id='$sales_id'
             OR sales_id IS NULL");
    }

    public function getById($id){

        $query = mysqli_query($this->conn,
            "SELECT * FROM produk
             WHERE id='$id'");

        return mysqli_fetch_assoc($query);
    }

    public function tambah($nama,$harga,$stok,$sales_id,$gambar){

    if($sales_id == ''){
        $sales_id = "NULL";
    } else {
        $sales_id = "'$sales_id'";
    }

    return mysqli_query($this->conn,
        "INSERT INTO produk(
            nama_produk,
            harga,
            stok,
            sales_id,
            gambar
        ) VALUES(
            '$nama',
            '$harga',
            '$stok',
            $sales_id,
            '$gambar'
        )");
}

    public function edit($id,$nama,$harga,$stok,$sales_id,$gambar){

        return mysqli_query($this->conn,
            "UPDATE produk SET
            nama_produk='$nama',
            harga='$harga',
            stok='$stok',
            sales_id='$sales_id',
            gambar='$gambar'
            WHERE id='$id'");
    }

    public function hapus($id){

        return mysqli_query($this->conn,
            "DELETE FROM produk
             WHERE id='$id'");
    }

    public function getAllWithSales(){

        return mysqli_query($this->conn,
            "SELECT produk.*, users.nama
             FROM produk
             LEFT JOIN users
             ON produk.sales_id = users.id
             ORDER BY produk.id DESC");
    }

    public function searchSales($sales_id,$keyword){

    return mysqli_query($this->conn,
        "SELECT * FROM produk
         WHERE (
            sales_id='$sales_id'
            OR sales_id IS NULL
         )
         AND nama_produk LIKE '%$keyword%'
         ORDER BY id DESC");
}
public function update($id,$nama,$harga,$stok,$gambar){

    if($gambar != ''){

        return mysqli_query($this->conn,
            "UPDATE produk SET
            nama_produk='$nama',
            harga='$harga',
            stok='$stok',
            gambar='$gambar'
            WHERE id='$id'");
    } else {

        return mysqli_query($this->conn,
            "UPDATE produk SET
            nama_produk='$nama',
            harga='$harga',
            stok='$stok'
            WHERE id='$id'");
    }
}
}
?>