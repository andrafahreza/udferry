<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	$page = "Penjualan";
	$tanggal=date("Y-m-d");
	session_start();
	include 'auth/connect.php';
	include "part/head.php";
	
	$nota=100000001;
	$cekpenjualan = mysqli_query($conn, "SELECT * FROM penjualan_header WHERE status='Unconfirm' order by nota_penjualan desc");
	$jtjual = mysqli_num_rows($cekpenjualan);
	if($jtjual>0){
		$dtjual=mysqli_fetch_array($cekpenjualan);
		$nota=$dtjual["nota_penjualan"];
	}else{
		$cekpenjualan = mysqli_query($conn, "SELECT * FROM penjualan_header order by nota_penjualan desc");
		$jtjual = mysqli_num_rows($cekpenjualan);
		if($jtjual>0){
			$dtjual=mysqli_fetch_array($cekpenjualan);
			$nota=$dtjual["nota_penjualan"];
			$nota=$nota+1;			
		}
	}

	$cekheader = mysqli_query($conn, "SELECT * FROM penjualan_header WHERE nota_penjualan='$nota'");
	$barisheader = mysqli_num_rows($cekheader);
	if($barisheader>0){
		$edit = mysqli_query($conn, "UPDATE  penjualan_header set nota_penjualan='$nota', tanggal='$tanggal', status='Unconfirm' where nota_penjualan='$nota'");
	}else{
		$add = mysqli_query($conn, "INSERT INTO penjualan_header (nota_penjualan, tanggal,status) VALUES ('$nota', '$tanggal', 'Unconfirm')");
	}

	if (isset($_GET['hapusid'])) {
		$idbarang = $_GET['hapusid'];
		$dlt = mysqli_query($conn, "DELETE From penjualan_detail where nota_penjualan='$nota' and idbarang='$idbarang'");		
	}
	
	if (isset($_POST['submit1'])) {
		
		$cektrans = mysqli_query($conn, "SELECT * FROM penjualan_header WHERE status='Unconfirm' order by nota_penjualan desc");
			$jtcektrans = mysqli_num_rows($cektrans);
			if($jtcektrans>0){
				$dtjtuncorfirm=mysqli_fetch_array($cektrans);
				$nota=$dtjtuncorfirm["nota_penjualan"];
				//update stok
				$jlh_trans=0;
				$cekcetailtrans = mysqli_query($conn, "SELECT * FROM penjualan_detail WHERE nota_penjualan='$nota'");
				while(mysqli_fetch_array($cekcetailtrans)){
					$jlh_trans++;
				}
				$_SESSION["SD_jumlah_transaksi"]=$jlh_trans;
			}
			
		if($_SESSION["SD_jumlah_transaksi"]<=0){
			echo '<script>
				setTimeout(function() {
					swal({
						title: "Gagal!",
						text: "Penjualan tidak dapat disimpan, isi data barang!",
						icon: "warning"
						});
					}, 500);
			</script>';
		}else{
			$cekuncorfirm = mysqli_query($conn, "SELECT * FROM penjualan_header WHERE status='Unconfirm' order by nota_penjualan desc");
			$jtuncorfirm = mysqli_num_rows($cekuncorfirm);
			if($jtuncorfirm>0){
				$dtjtuncorfirm=mysqli_fetch_array($cekuncorfirm);
				$nota=$dtjtuncorfirm["nota_penjualan"];
				//update stok
				$cekdetail = mysqli_query($conn, "SELECT * FROM penjualan_detail WHERE nota_penjualan='$nota'");
				while($updatestok=mysqli_fetch_array($cekdetail)){
					$idbarang=$updatestok["idbarang"];
					$qty_update=$updatestok["qty"];
					$tanbahstok = mysqli_query($conn, "UPDATE barang set stok=stok-'$qty_update' WHERE id='$idbarang'");
				}
			}

			$edit = mysqli_query($conn, "UPDATE  penjualan_header set nota_penjualan='$nota', tanggal='$tanggal', status='Confirmed' where nota_penjualan='$nota'");
			//echo '<script>document.location="penjualan.php";</script>';			
			$nota=100000001;
			$cekpenjualan = mysqli_query($conn, "SELECT * FROM penjualan_header WHERE status='Unconfirm' order by nota_penjualan desc");
			$jtjual = mysqli_num_rows($cekpenjualan);
			if($jtjual>0){
				$dtjual=mysqli_fetch_array($cekpenjualan);
				$nota=$dtjual["nota_penjualan"];
			}else{
				$cekpenjualan = mysqli_query($conn, "SELECT * FROM penjualan_header order by nota_penjualan desc");
				$jtjual = mysqli_num_rows($cekpenjualan);
				if($jtjual>0){
					$dtjual=mysqli_fetch_array($cekpenjualan);
					$nota=$dtjual["nota_penjualan"];
					$nota=$nota+1;
				}
			}		
			echo '<script>
				setTimeout(function() {
					swal({
						title: "Berhasil!",
						text: "Penjualan telah ditambahkan!",
						icon: "success"
						});
					}, 500);
			</script>';
		}
	}
	
	if (isset($_POST['submit2'])) {
		$idbarang = $_POST['id'];
		$qty = $_POST['qty'];
		$stok=0;
		$harga=0;
		$cekbrg = mysqli_query($conn, "SELECT * FROM barang WHERE id='$idbarang'");
		$jtbrg = mysqli_num_rows($cekbrg);
		if($jtbrg>0){
			$dtbrg=mysqli_fetch_array($cekbrg);
			$harga=$dtbrg["harga"];
			$stok=$dtbrg["stok"];
		}
		if($stok>=$qty){
			$dlt = mysqli_query($conn, "DELETE From penjualan_detail where nota_penjualan='$nota' and idbarang='$idbarang'");
			$add = mysqli_query($conn, "INSERT INTO penjualan_detail (nota_penjualan, idbarang, harga, qty) VALUES ('$nota', '$idbarang', '$harga', '$qty')");
			echo '<script>
				setTimeout(function() {
					swal({
						title: "Berhasil!",
						text: "Barang telah ditambahkan!",
						icon: "success"
						});
					}, 500);
			</script>';
			
		}else{
			echo '<script>
				setTimeout(function() {
					swal({
						title: "Peringatan!",
						text: "Stok tidak mencukupi, stok tersedia '.$stok.'",
						icon: "warning"
						});
					}, 500);
			</script>';
		}	
	}
	?>
</head>

<body>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<div class="navbar-bg"></div>

			<?php
			include 'part/navbar.php';
			include 'part/sidebar.php';
			?>

			<!-- Main Content -->
			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1><?php echo $page; ?></h1>

					</div>
					<div class="section-body">
						<div class="row">
							<div class="col-12">
								<div class="card">		
									<div class="card-header">
									<h4><?php echo $page; ?></h4>
										<div class="card-header-action">
											<!--<a href="retur_penjualan.php" class="nav-link"><button class="btn btn-primary">Retur Penjualan</button></a>-->
										</div>
									<form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off">								
										<div class="card-header-action">
											<button type="submit" class="btn btn-primary" name="submit1">Simpan</button>
											<a href="data_penjualan.php" class="btn btn-secondary">X</a>
										</div>
									</div>
									</form>									
									<div class="card-body">
										<div class="form-group row">
										  <label class="col-sm-3 col-form-label">Nota Penjualan</label>
										  <div class="col-sm-9">
											<input type="text" class="form-control" name="jenis" required="" value="<?php echo $nota; ?>" readonly>
											<div class="invalid-feedback">
											  Mohon data diisi!
											</div>
										  </div>
										</div>
										<div class="form-group row">
										  <label class="col-sm-3 col-form-label">Tanggal</label>
										  <div class="col-sm-9">
											<input type="date" class="form-control" name="tanggal" required="" value="<?php echo $tanggal; ?>" readonly>
											<div class="invalid-feedback">
											  Mohon data diisi!
											</div>
										  </div>
										</div>
										<b><?php echo "Detail Barang"; ?></b>
										<div class="card-header-action">
										  <a href="#" class="btn btn-primary" data-target="#addBarang" data-toggle="modal">Tambahkan Barang</a>
										</div>
										<div class="table-responsive">
											<table class="table table-striped" id="table-0">
												<thead>
													<tr>
														<th class="text-center">
															#
														</th>
														<th>Nama Barang</th>
														<th>Jenis</th>
														<th>Ukuran</th>
														<th>Deskripsi</th>
														<th>Harga</th>
														<th>Stok</th>
														<th>Qty</th>
														<th>Total</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sql = mysqli_query($conn, "SELECT * FROM penjualan_detail join barang on penjualan_detail.idbarang=barang.id where nota_penjualan='$nota'");
													$i = 0;
													while ($row = mysqli_fetch_array($sql)) {
														$i++;
													?>
														<tr>
															<td><?php echo $i; ?></td>
															<td><?php echo ucwords($row['nama_barang']); ?></td>
															<td><?php echo ucwords($row['jenis']); ?></td>
															<td><?php echo ucwords($row['ukuran']); ?></td>
															<td><?php echo ucwords($row['deskripsi']); ?></td>
															<td><?php echo "Rp ".number_format($row['harga'],0); ?></td>
															<td><?php echo ucwords($row['stok']); ?></td>
															<td><?php echo ucwords($row['qty']); ?></td>
															<td><?php echo "Rp ".number_format(($row['qty']*$row['harga']),0); ?></td>
															<td>
																<a class="btn btn-danger btn-action" href="penjualan.php?hapusid=<?php echo $row['id']; ?>"><i class="fas fa-trash"></i></a>
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
					</div>
			</div>
			</section>
		</div>
		
		<div class="modal fade" tabindex="-1" role="dialog" id="addBarang">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Barang</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Barang</label>
                  <div class="col-sm-9">
					<select class="form-control" id="id" name="id" required="" onchange="unlockdata()" required>
						<option value="">-Pilih-</option>
						<?php
						$query_barang=mysqli_query($conn,"select * from barang order by nama_barang asc");
						while ($row=mysqli_fetch_array($query_barang)){
							echo '<option value="'. $row['id'] .'" '. ' >'. $row['nama_barang'] .'</option>';
						} ?>
					</select>
					<script>
						function unlockdata(){
							var kj=document.getElementById('id').value;
							var ukuran=kj+'_ukuran';
							var stok=kj+'_stok';
							var gambar=kj+'_gambar';
							if(kj==""){
								document.getElementById('ukuran').value='';
								document.getElementById('stok').value='';
								document.getElementById('gambar').src='assets/img/news/img15.jpg';
							}else{
								document.getElementById('ukuran').value=document.getElementById(ukuran).value;
								document.getElementById('stok').value=document.getElementById(stok).value;
								document.getElementById('gambar').src=document.getElementById(gambar).value;
							}
						}
					</script>
						<?php
						$query_barang1=mysqli_query($conn,"select * from barang order by nama_barang asc");
						while ($row1=mysqli_fetch_array($query_barang1)){ ?>
							<input type="hidden" class="form-control" id="<?php echo $row1["id"]."_ukuran"; ?>" value="<?php echo $row1["ukuran"]; ?>">
							<input type="hidden" class="form-control" id="<?php echo $row1["id"]."_stok"; ?>" value="<?php echo $row1["stok"]; ?>">
							<input type="hidden" class="form-control" id="<?php echo $row1["id"]."_gambar"; ?>" value="<?php echo "assets/img/barang/".$row1["id"].".jpg"; ?>">
					<?php } ?>	
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
				<div class="form-group row" style="display:;">
                  <label class="col-sm-3 col-form-label">Ukuran</label>
                  <div class="col-sm-9">
					<input type="text" class="form-control" name="ukuran" id="ukuran" readonly >
                  </div>
                </div>
				<div class="form-group row" style="display:;">
                  <label class="col-sm-3 col-form-label">Stok</label>
                  <div class="col-sm-9">
					<input type="text" class="form-control" name="stok" id="stok" readonly >
                  </div>
                </div>
				<div class="form-group row" style="display:;">
                  <label class="col-sm-3 col-form-label">Gambar</label>
                  <div class="col-sm-9">
					<img src="assets/img/news/img15.jpg" id="gambar" width="150px">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Qty</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="qty" id="qty" onchange="validate_qty()" required="" value="">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>			
					<script type="text/javascript">
					function validate_qty(){
						var jumlah= document.getElementById("qty").value;
						if(jumlah<=0){								
							document.getElementById("qty").value=1;
						}
					}
					</script>
                  </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="submit2">Tambah</button>
              </form>
            </div>
          </div>
        </div>
      </div>
		<?php include 'part/footer.php'; ?>
	</div>
	</div>
	<?php include "part/all-js.php"; ?>
</body>

</html>