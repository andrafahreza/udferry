<?php
//$idnama = $_POST['id'];
$page1 = "det";
$page = "Laporan Penjualan : ";
session_start();
include 'auth/connect.php';
include "part/head.php";
include 'part_func/umur.php';
include 'part_func/tgl_ind.php';

//All SQL Syntax
$cek = mysqli_query($conn, "SELECT * FROM barang");

?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Laporan Penjualan</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered" id="table-1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nota Penjualan</th>
					<th>Tanggal</th>
					<th>Sub Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = mysqli_query($conn, "SELECT * FROM penjualan_header");
				  $i = 0;
				  while ($row = mysqli_fetch_array($sql)) {
					$total=0;
					$sql2 = mysqli_query($conn, "SELECT * FROM penjualan_detail where nota_penjualan='".$row["nota_penjualan"]."'");
					while($row2 = mysqli_fetch_array($sql2)){
						$jlh=$row2["harga"]*$row2["qty"];
						$total=$total+$jlh;
						}
					//$idbarang = $row['id'];
					$i++;
                  ?>
                    <tr>
                      <td rowspan="" valign="top"><?php echo $i; ?></td>
					  <td><?php echo ucwords($row['nota_penjualan']) ?></td>
					  <td><?php echo ucwords($row['tanggal']) ?></td>
					  <td>Rp. <?php echo number_format($total, 0, ".", "."); ?></td>
                    </tr>
					<tr>
                      <td rowspan="" valign="top"></td>
					  <td colspan="4">
						<table class="table table-striped" id="table-0">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th>Nama Barang</th>
									<th>Jenis</th>
									<th>Ukuran</th>
									<th>Deskripsi</th>
									<th>Harga</th>
									<th>Qty</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sql_detail = mysqli_query($conn, "SELECT * FROM penjualan_detail join barang on penjualan_detail.idbarang=barang.id where nota_penjualan='".$row["nota_penjualan"]."'");
								$i = 0;
								while ($rowdetail = mysqli_fetch_array($sql_detail)) {
									$i++;
								?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo ucwords($rowdetail['nama_barang']); ?></td>
										<td><?php echo ucwords($rowdetail['jenis']); ?></td>
										<td><?php echo ucwords($rowdetail['ukuran']); ?></td>
										<td><?php echo ucwords($rowdetail['deskripsi']); ?></td>
										<td><?php echo "Rp ".number_format($rowdetail['harga'],0); ?></td>
										<td><?php echo ucwords($rowdetail['qty']); ?></td>
										<td><?php echo "Rp ".number_format(($rowdetail['qty']*$rowdetail['harga']),0); ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					  </td>				  
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