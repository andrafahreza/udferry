<?php
//$idnama = $_POST['id'];
$page1 = "det";
$page = "Laporan Retur Penjualan : ";
session_start();
include 'auth/connect.php';
include "part/head.php";
include 'part_func/umur.php';
include 'part_func/tgl_ind.php';

//All SQL Syntax
$cek = mysqli_query($conn, "SELECT * FROM retur_penjualan_header where status='Confirmed'");

?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Laporan Retur Penjualan</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered" id="table-1">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nota Retur Penjualan</th>
					<th>Tanggal Retur</th>
					<th>Nota Penjualan</th>
					<th>Tanggal Penjualan</th>
					<th>Pelanggan</th>
					<th>Sub Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = mysqli_query($conn, "SELECT * FROM retur_penjualan_header where status='Confirmed'");
				  $i = 0;
				  while ($row = mysqli_fetch_array($sql)) {
					$total=0;
					$sql3 = mysqli_query($conn, "SELECT * FROM penjualan_header where nota_penjualan='".$row["nota_penjualan"]."'");
					$nama_pelanggan="";
					$tanggal_penjualan="";
					if(mysqli_num_rows($sql3)>0){
						$row3 = mysqli_fetch_array($sql3);
						$id_pelanggan=$row3["id"];
						$tanggal_penjualan=$row3["tanggal"];
						
						$sql4 = mysqli_query($conn, "SELECT * FROM pelanggan where id='$id_pelanggan'");
						$nama_pelanggan="";
						if(mysqli_num_rows($sql4)>0){
							$row4 = mysqli_fetch_array($sql4);
							$nama_pelanggan=$row4["nama_pelanggan"];								
						}
					}
					$sql2 = mysqli_query($conn, "SELECT * FROM retur_penjualan_detail where nota_retur_penjualan='".$row["nota_retur_penjualan"]."'");
					while($row2 = mysqli_fetch_array($sql2)){
						$jlh=$row2["harga"]*$row2["qty"];
						$total=$total+$jlh;
						}
					//$idbarang = $row['id'];
					$i++;
                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
					   <td><?php echo ucwords($row['nota_retur_penjualan']) ?></td>
					   <td><?php echo date('d F Y', strtotime($row['tanggal'])) ?></td>
					   <td><?php echo ucwords($row['nota_penjualan']) ?></td>
					   <td><?php echo date('d F Y', strtotime($tanggal_penjualan)) ?></td>
					   <td><?php echo ucwords($nama_pelanggan) ?></td>
					   <td>Rp. <?php echo number_format($total, 0, ".", "."); ?></td>
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