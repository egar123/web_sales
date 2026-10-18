<?php
require_once __DIR__ . '/../config/Database.php';

class KomisiTransfer {

    private $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function totalKomisiPenjualan($sales_id){
        $sales_id = (int) $sales_id;
        $q = mysqli_query($this->conn,
            "SELECT SUM(komisi) AS t FROM penjualan WHERE sales_id='$sales_id'");
        $row = mysqli_fetch_assoc($q);
        return (float) ($row['t'] ?? 0);
    }

    public function totalDitransfer($sales_id){
        $sales_id = (int) $sales_id;
        $q = mysqli_query($this->conn,
            "SELECT SUM(nominal) AS t FROM komisi_transfer WHERE sales_id='$sales_id'");
        $row = mysqli_fetch_assoc($q);
        return (float) ($row['t'] ?? 0);
    }

    public function sisaKomisi($sales_id){
        return max(0, $this->totalKomisiPenjualan($sales_id) - $this->totalDitransfer($sales_id));
    }

    public function simpan($sales_id, $nominal, $penerima){
        $sales_id = (int) $sales_id;
        $nominal = (float) $nominal;
        if($nominal <= 0){
            return ['ok' => false, 'msg' => 'Nominal harus lebih dari 0'];
        }
        if(!in_array($penerima, ['admin', 'boss'], true)){
            return ['ok' => false, 'msg' => 'Penerima tidak valid'];
        }
        $sisa = $this->sisaKomisi($sales_id);
        if($nominal > $sisa + 0.0001){
            return ['ok' => false, 'msg' => 'Nominal melebihi komisi yang belum ditransfer'];
        }
        $penerima_esc = mysqli_real_escape_string($this->conn, $penerima);
        $ok = mysqli_query($this->conn,
            "INSERT INTO komisi_transfer (sales_id, nominal, penerima) VALUES ('$sales_id', '$nominal', '$penerima_esc')");
        if(!$ok){
            return ['ok' => false, 'msg' => 'Gagal menyimpan: ' . mysqli_error($this->conn)];
        }
        return ['ok' => true, 'msg' => 'Transfer komisi berhasil dicatat'];
    }

    public function riwayatSales($sales_id, $limit = 20){
        $sales_id = (int) $sales_id;
        $limit = (int) $limit;
        return mysqli_query($this->conn,
            "SELECT * FROM komisi_transfer WHERE sales_id='$sales_id' ORDER BY tanggal DESC LIMIT $limit");
    }

    public function riwayatAdmin($limit = 100){
        $limit = (int) $limit;
        return mysqli_query($this->conn,
            "SELECT kt.*, u.nama, u.username
             FROM komisi_transfer kt
             JOIN users u ON u.id = kt.sales_id
             ORDER BY kt.tanggal DESC
             LIMIT $limit");
    }

    public function jumlahSalesSudahTransferBulanIni(){
        $q = mysqli_query($this->conn,
            "SELECT COUNT(DISTINCT sales_id) AS c FROM komisi_transfer
             WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())");
        $row = mysqli_fetch_assoc($q);
        return (int) ($row['c'] ?? 0);
    }

    public function totalNominalTransferBulanIni(){
        $q = mysqli_query($this->conn,
            "SELECT SUM(nominal) AS t FROM komisi_transfer
             WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())");
        $row = mysqli_fetch_assoc($q);
        return (float) ($row['t'] ?? 0);
    }
}
