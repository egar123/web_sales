<?php
require_once __DIR__ . '/../config/Database.php';

class Penjualan {

    private $conn;

    public function __construct(){

        $db = new Database();
        $this->conn = $db->connect();
    }

    // total semua penjualan
    public function totalPenjualan(){

        $query = mysqli_query($this->conn,
            "SELECT SUM(total) as total
             FROM penjualan");

        $data = mysqli_fetch_assoc($query);

        return $data['total'] ?? 0;
    }

    // transaksi hari ini
public function transaksiHariIni($sales_id){

    $query = mysqli_query($this->conn,
        "SELECT SUM(qty) as total
         FROM penjualan
         WHERE sales_id='$sales_id'
         AND DATE(tanggal) = CURDATE()"
    );

    $data = mysqli_fetch_assoc($query);

    return $data['total'] ?? 0;
}

    // total bulanan
    public function totalBulanan($sales_id){

        $bulan = date('m');
        $tahun = date('Y');

        $query = mysqli_query($this->conn,
            "SELECT SUM(total) as total
             FROM penjualan
             WHERE sales_id='$sales_id'
             AND MONTH(tanggal)='$bulan'
             AND YEAR(tanggal)='$tahun'");

        $data = mysqli_fetch_assoc($query);

        return $data['total'] ?? 0;
    }

    // target bulanan
    public function targetBulanan($sales_id){

        $target = 50000000;

        $total = $this->totalBulanan($sales_id);

        $persen = ($total / $target) * 100;

        return min(round($persen),100);
    }

    public function totalKomisiBulanan($sales_id){

    $query = mysqli_query($this->conn,
        "SELECT SUM(komisi) as total_komisi
         FROM penjualan
         WHERE sales_id='$sales_id'");

    $data = mysqli_fetch_assoc($query);

    return $data['total_komisi'] ?? 0;
}

public function targetProduk($sales_id){

    $q = mysqli_query($this->conn,
        "SELECT target_produk FROM users WHERE id='$sales_id'");

    $target = mysqli_fetch_assoc($q)['target_produk'] ?? 1;

    $q2 = mysqli_query($this->conn,
        "SELECT SUM(qty) as total
         FROM penjualan
         WHERE sales_id='$sales_id'");

    $terjual = mysqli_fetch_assoc($q2)['total'] ?? 0;

    return round(($terjual / $target) * 100);
}

public function targetOmset($sales_id){

    $q = mysqli_query($this->conn,
        "SELECT target_omset FROM users WHERE id='$sales_id'");

    $target = mysqli_fetch_assoc($q)['target_omset'] ?? 1;

    $total = $this->totalBulanan($sales_id);

    return round(($total / $target) * 100);
}
}
?>