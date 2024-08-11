<?php
//$idnama = $_POST['id'];
$page1 = "det";
$page = "Laporan Supplier : ";
session_start();
include 'auth/connect.php';
include "part/head.php";
include 'part_func/umur.php';
include 'part_func/tgl_ind.php';

//All SQL Syntax
$cek = mysqli_query($conn, "SELECT * FROM supplier");

?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Laporan Supplier</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered" id="table-1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Contac Person</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				  $no=0;
                  while ($row = mysqli_fetch_array($cek)) {
                    $id = $row['id'];
					$no=$no+1;
                  ?>
                    <tr>
					  <td><?php echo ucwords($no) ?></td>
                      <td><?php echo ucwords($row['nama_supplier']); ?></td>
                      <td><?php echo ucwords($row['alamat']); ?></td>
                      <td><?php echo ucwords($row['telepon']); ?></td>                      
                      <td><?php echo ucwords($row['contac_person']); ?></td>                      
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