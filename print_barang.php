<?php
//$idnama = $_POST['id'];
$page1 = "det";
$page = "Laporan Barang : ";
session_start();
include 'auth/connect.php';
include "part/head.php";
include 'part_func/umur.php';
include 'part_func/tgl_ind.php';

//All SQL Syntax
$cek = mysqli_query($conn, "SELECT * FROM barang");
$pasien = mysqli_fetch_array($cek);
$idid = $pasien['id'];

?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Laporan Barang</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered" id="table-1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
					<th>Jenis</th>
					<th>Ukuran</th>
					<th>Deskripsi</th>
					<th>Stok</th>
					<th>Harga per unit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				  $no=0;
                  while ($row = mysqli_fetch_array($cek)) {
					$no=$no+1;
                  ?>
                    <tr>
                      <td><?php echo ucwords($no) ?></td>
                      <td><?php echo ucwords($row['nama_barang']) ?></td>
					  <td><?php echo ucwords($row['jenis']) ?></td>
					  <td><?php echo ucwords($row['ukuran']) ?></td>
					  <td><?php echo ucwords($row['deskripsi']) ?></td>
					  <td><?php echo $row['stok'] . ""; ?></td>
					  <td>Rp. <?php echo number_format($row['harga'], 0, ".", "."); ?></td>            
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php
  if (!isset($_POST['detail'])) {
		echo '<footer class="main-footer">
		<div class="footer-left">
		  Laporan ini dicetak pada tanggal ' . tgl_indo(date('Y-m-d')) . '
		</div>
		</footer>';
    echo '<script> window.print(); </script>';
  } ?>