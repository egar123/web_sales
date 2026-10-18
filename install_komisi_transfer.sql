CREATE TABLE IF NOT EXISTS komisi_transfer (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sales_id INT NOT NULL,
  nominal DECIMAL(15,2) NOT NULL,
  penerima ENUM('admin','boss') NOT NULL DEFAULT 'admin',
  tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (sales_id),
  INDEX (tanggal)
);
