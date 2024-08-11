<?php
//$idnama = $_POST['id'];
$page1 = "det";
$page = "Invoice : ";
session_start();
include 'auth/connect.php';
include "part/head.php";
include 'part_func/umur.php';
include 'part_func/tgl_ind.php';

//All SQL Syntax
$cek = mysqli_query($conn, "SELECT * FROM barang");
$nota_penjualan=@$_POST["nota_penjualan"];
?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
			<img src="assets/img/logo.jpg" alt="logo" width="50"> <h1>UD. FERY</h1>
          </div>
          <div class="card-body">
		  <br><hr><br>
            <div class="table-responsive">
				<table class="table" id="table-0">
                  <?php
                  $sql = mysqli_query($conn, "SELECT * FROM penjualan_header where nota_penjualan='$nota_penjualan'");
				  $i = 0;
				  while ($row = mysqli_fetch_array($sql)) {
					$total=0;
					$sql2 = mysqli_query($conn, "SELECT * FROM penjualan_detail where nota_penjualan='".$row["nota_penjualan"]."'");
					while($row2 = mysqli_fetch_array($sql2)){
						$jlh=$row2["harga"]*$row2["qty"];
						$total=$total+$jlh;
						}
					$idbarang = $row['id'];
					$i++;
                  ?>
                    <tr>
					  <td colspan="2" align="center"></b><h2>INVOICE</h2></b><hr></td>
                    </tr>
                    <tr>
					  <th width="190">Nota Penjualan</th><th width="">: <?php echo ucwords($row['nota_penjualan']) ?></th>
                    </tr>
                    <tr>
					  <th>Tanggal</th><th>: <?php echo ucwords($row['tanggal']) ?></th>
                    </tr>                   
					<tr>
					  <td colspan="2" align="center"><hr><br>
					  <h5>Detail Barang</h5>
					  <br>
						<table width="100%" border="1">
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
						</table>
						<br><hr>
					  </td>				  
					</tr>
                    <tr>
					  <td>Total</td><td>: Rp. <?php echo number_format($total, 0, ".", "."); ?></td>
                    </tr>
                  <?php } ?>
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
		  Invoice ini dicetak pada tanggal ' . tgl_indo(date('Y-m-d')) . '
		</div>
		</footer>';
    echo '<script> window.print(); </script>';
  } ?>