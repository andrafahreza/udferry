<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	$page = "Retur Pembelian";
	$tanggal_retur=date("Y-m-d");
	session_start();
	include 'auth/connect.php';
	include "part/head.php";
	
	$nota=100000001;
	$cekreturpembelian = mysqli_query($conn, "SELECT * FROM retur_pembelian_header WHERE status='Unconfirm' order by nota_retur_pembelian desc");
	$jtreturbeli = mysqli_num_rows($cekreturpembelian);
	if($jtreturbeli>0){
		$dtreturbeli=mysqli_fetch_array($cekreturpembelian);
		$nota=$dtreturbeli["nota_retur_pembelian"];
	}else{
		$cekreturpembelian = mysqli_query($conn, "SELECT * FROM retur_pembelian_header order by nota_retur_pembelian desc");
		$jtreturbeli = mysqli_num_rows($cekreturpembelian);
		if($jtreturbeli>0){
			$dtreturbeli=mysqli_fetch_array($cekreturpembelian);
			$nota=$dtreturbeli["nota_retur_pembelian"];
			$nota=$nota+1;			
		}
	}

	$cekheader67 = mysqli_query($conn, "SELECT * FROM retur_pembelian_header WHERE nota_retur_pembelian='$nota'");
	$barisheader67 = mysqli_num_rows($cekheader67);
	if($barisheader67>0){
		$edit = mysqli_query($conn, "UPDATE  retur_pembelian_header set nota_retur_pembelian='$nota', tanggal='$tanggal_retur', nota_pembelian='".@$_SESSION["SD_nota_pembelian"]."', status='Unconfirm' where nota_retur_pembelian='$nota'");
	}else{
		$add = mysqli_query($conn, "INSERT INTO retur_pembelian_header (nota_retur_pembelian, tanggal, nota_pembelian,status) VALUES ('$nota', '$tanggal_retur', '".@$_SESSION["SD_nota_pembelian"]."', 'Unconfirm')");
	}

	if (isset($_GET['hapusid'])) {
		$idbarang = $_GET['hapusid'];
		$dlt = mysqli_query($conn, "DELETE From retur_pembelian_detail where nota_retur_pembelian='$nota' and idbarang='$idbarang'");		
	}
	
	if (isset($_POST['submit1'])) {
		$cektrans = mysqli_query($conn, "SELECT * FROM retur_pembelian_header WHERE status='Unconfirm' order by nota_retur_pembelian desc");
			$jtcektrans = mysqli_num_rows($cektrans);
			if($jtcektrans>0){
				$dtjtuncorfirm=mysqli_fetch_array($cektrans);
				$nota=$dtjtuncorfirm["nota_retur_pembelian"];
				//update stok
				$jlh_trans=0;
				$cekcetailtrans = mysqli_query($conn, "SELECT * FROM retur_pembelian_detail WHERE nota_retur_pembelian='$nota'");
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
						text: "Retur pembelian tidak dapat disimpan, isi data retur barang!",
						icon: "warning"
						});
					}, 500);
			</script>';
		}else{
			$cekuncorfirm = mysqli_query($conn, "SELECT * FROM retur_pembelian_header WHERE status='Unconfirm' order by nota_retur_pembelian desc");
			$jtuncorfirm = mysqli_num_rows($cekuncorfirm);
			if($jtuncorfirm>0){
				$dtjtuncorfirm=mysqli_fetch_array($cekuncorfirm);
				$nota=$dtjtuncorfirm["nota_retur_pembelian"];
				$nota_pembelian333=$dtjtuncorfirm["nota_pembelian"];
				$cekdetail = mysqli_query($conn, "SELECT * FROM retur_pembelian_detail WHERE nota_retur_pembelian='$nota'");
				while($row_detail=mysqli_fetch_array($cekdetail)){
					$idbarang=$row_detail["idbarang"];
					$qty_update=$row_detail["qty"];
					
					//update stok
					//$tambahstok = mysqli_query($conn, "UPDATE barang set stok=stok+'$qty_update' WHERE id='$idbarang'");

					//update pembelian
					$kurangpembelian = mysqli_query($conn, "UPDATE pembelian_detail set qty=qty-'$qty_update' WHERE nota_pembelian='$nota_pembelian333' and idbarang='$idbarang'");
				}
			}

			$edit = mysqli_query($conn, "UPDATE  retur_pembelian_header set nota_retur_pembelian='$nota', tanggal='$tanggal_retur', nota_pembelian='".$_SESSION["SD_nota_pembelian"]."', status='Confirmed' where nota_retur_pembelian='$nota'");	

			//echo '<script>document.location="pembelian.php";</script>';			
			$nota=100000001;
			$cekpembelian = mysqli_query($conn, "SELECT * FROM retur_pembelian_header WHERE status='Unconfirm' order by nota_retur_pembelian desc");
			$jtbeli = mysqli_num_rows($cekpembelian);
			if($jtbeli>0){
				$dtbeli=mysqli_fetch_array($cekpembelian);
				$nota=$dtbeli["nota_retur_pembelian"];
			}else{
				$cekpembelian = mysqli_query($conn, "SELECT * FROM retur_pembelian_header order by nota_retur_pembelian desc");
				$jtbeli = mysqli_num_rows($cekpembelian);
				if($jtbeli>0){
					$dtbeli=mysqli_fetch_array($cekpembelian);
					$nota=$dtbeli["nota_retur_pembelian"];
					$nota=$nota+1;
				}
			}	
			$_SESSION["SD_nota_pembelian"]="";			
			echo '<script>
				setTimeout(function() {
					swal({
						title: "Berhasil!",
						text: "Retur pembelian telah ditambahkan!",
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
			$dlt = mysqli_query($conn, "DELETE From pembelian_detail where nota_pembelian='$nota' and idbarang='$idbarang'");
			$add = mysqli_query($conn, "INSERT INTO pembelian_detail (nota_pembelian, idbarang, harga, qty) VALUES ('$nota', '$idbarang', '$harga', '$qty')");
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
	
	if (isset($_POST['submit3'])) {
		$id = $_POST['id'];
		$qty = $_POST['qty'];
			$dlt = mysqli_query($conn, "UPDATE retur_pembelian_detail set qty='$qty' where id='$id'");
			echo '<script>
				setTimeout(function() {
					swal({
						title: "Berhasil!",
						text: "Jumlah retur telah diubah!",
						icon: "success"
						});
					}, 500);
			</script>';
	}
	
	if (isset($_POST['submit4'])) {
		$id = $_POST['id'];
			$dlt = mysqli_query($conn, "DELETE FROM retur_pembelian_detail where id='$id'");
			echo '<script>
				setTimeout(function() {
					swal({
						title: "Berhasil!",
						text: "Barang retur telah dihapus!",
						icon: "success"
						});
					}, 500);
			</script>';
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
									<form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off">								
									<div class="card-header">
									<h4><?php echo $page; ?></h4>
										<div class="card-header-action">
											<button type="submit" class="btn btn-primary" name="submit1">Simpan</button>
										</div>
									</div>
									</form>									
									<div class="card-body">
										<div class="form-group row">
										  <label class="col-sm-3 col-form-label">Nota Retur pembelian</label>
										  <div class="col-sm-9">
											<input type="text" class="form-control" name="jenis" required="" value="<?php echo $nota; ?>" readonly>
											<div class="invalid-feedback">
											  Mohon data diisi!
											</div>
										  </div>
										</div>
										<div class="form-group row">
										  <label class="col-sm-3 col-form-label">Tanggal Retur</label>
										  <div class="col-sm-9">
											<input type="date" class="form-control" name="tanggal_retur" required="" value="<?php echo $tanggal_retur; ?>" readonly>
											<div class="invalid-feedback">
											  Mohon data diisi!
											</div>
										  </div>
										</div>
										<form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off">
										<div class="form-group row">
										  <label class="col-sm-3 col-form-label">Nota Pembelian</label>
										  <div class="col-sm-9">
											<?php if(@$_POST["nota_pembelian"]){
												$_SESSION["SD_nota_pembelian"]=$_POST["nota_pembelian"];
												$cekheader = mysqli_query($conn, "SELECT * FROM retur_pembelian_header WHERE nota_retur_pembelian='$nota'");
												$barisheader = mysqli_num_rows($cekheader);
												if($barisheader>0){
													$edit = mysqli_query($conn, "UPDATE  retur_pembelian_header set nota_retur_pembelian='$nota', nota_pembelian='".$_SESSION["SD_nota_pembelian"]."', tanggal='$tanggal_retur', status='Unconfirm' where nota_retur_pembelian='$nota'");
												}else{
													$add = mysqli_query($conn, "INSERT INTO retur_pembelian_header (nota_retur_pembelian, tanggal, nota_pembelian,status) VALUES ('$nota', '$tanggal_retur', '".@$_SESSION["SD_nota_pembelian"]."', 'Unconfirm')");													
												}
												$dltdetail = mysqli_query($conn, "DELETE FROM retur_pembelian_detail where nota_retur_pembelian='$nota'");
												$cekdetail = mysqli_query($conn, "SELECT * FROM pembelian_detail WHERE nota_pembelian='".$_SESSION["SD_nota_pembelian"]."'");
												while($dtl=mysqli_fetch_array($cekdetail)){
													$idbarang3=$dtl["idbarang"];
													$harga3=$dtl["harga"];
													$qty3=$dtl["qty"];
													$add = mysqli_query($conn, "INSERT INTO retur_pembelian_detail (nota_retur_pembelian, idbarang, harga, qty) VALUES ('$nota', '$idbarang3', '$harga3', '$qty3')");
												}

											}											
											if (@$_SESSION["SD_nota_pembelian"]==""){
												$_SESSION["SD_nota_pembelian"]="";
												$tanggal_pembelian="";
												$nama_supplier="";
											}
											
											if ($_SESSION["SD_nota_pembelian"]!==""){												
												$cekbeliheader = mysqli_query($conn, "SELECT * FROM pembelian_header join supplier on pembelian_header.id=supplier.id WHERE pembelian_header.nota_pembelian='".$_SESSION["SD_nota_pembelian"]."'");
												$barisbeliheader = mysqli_num_rows($cekbeliheader);
												if($barisbeliheader>0){
													$dtbeli=mysqli_fetch_array($cekbeliheader);
													$tanggal_pembelian=$dtbeli["tanggal"];
													$nama_supplier=$dtbeli["nama_supplier"];
												}
											}
											?>
											
											<select class="form-control" name="nota_pembelian" required="" required onchange="submit()">
												<option value="">-Pilih-</option>
												<?php
												$query=mysqli_query($conn,"select * from pembelian_header join supplier on pembelian_header.id=supplier.id where pembelian_header.status='Confirmed' order by pembelian_header.nota_pembelian asc");
												while ($row_jl=mysqli_fetch_array($query)){
													if(@$_SESSION['SD_nota_pembelian']==$row_jl['nota_pembelian']){
														$sel='selected';
													}else{
														$sel='';
													}
													echo '<option value="'. $row_jl['nota_pembelian'] .'" '. $sel .' >'. $row_jl['nota_pembelian'].'</option>';
												} ?>
											</select>
											<div class="invalid-feedback">
											  Mohon data diisi!
											</div>
										  </div>
										</div>
										<div class="form-group row">
										  <label class="col-sm-3 col-form-label">Tanggal pembelian</label>
										  <div class="col-sm-9">
											<input type="date" class="form-control" name="tanggal_pembelian" required="" value="<?php echo @$tanggal_pembelian; ?>" readonly>
											<div class="invalid-feedback">
											  Mohon data diisi!
											</div>
										  </div>
										</div>
										<div class="form-group row">
										  <label class="col-sm-3 col-form-label">Supplier</label>
										  <div class="col-sm-9">
										  <input type="text" class="form-control" name="nama_supplier" required="" value="<?php echo @$nama_supplier; ?>" readonly>
											<div class="invalid-feedback">
											  Mohon data diisi!
											</div>
										  </div>
										</div>
										</form>
										<b><?php echo "Detail Barang"; ?></b>
										<form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off">
										<div class="card-header-action">
										  <input type="hidden" class="form-control" name="nota_pembelian" required="" value="<?php echo $_SESSION["SD_nota_pembelian"]; ?>" readonly>
										  <button type="submit" class="btn btn-primary" name="submit5">Reset</button>
										</div>
										</form>
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
														<th>Qty [beli]</th>
														<th>Qty [Retur]</th>
														<th>Total</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sql = mysqli_query($conn, "SELECT * FROM retur_pembelian_detail where nota_retur_pembelian='$nota'");
													$i = 0;
													while ($row = mysqli_fetch_array($sql)) {
														$i++;
														$cekbelidtl = mysqli_query($conn, "SELECT * FROM pembelian_detail WHERE nota_pembelian='".$_SESSION["SD_nota_pembelian"]."' and idbarang='".$row["idbarang"]."'");
														$barisbelidtl = mysqli_num_rows($cekbelidtl);
														$qty_beli=$row["qty"];
														if($barisbelidtl>0){
															$dtbelidtl=mysqli_fetch_array($cekbelidtl);
															$qty_beli=$dtbelidtl["qty"];															
														}
														$cekbrg = mysqli_query($conn, "SELECT * FROM barang WHERE id='".$row["idbarang"]."'");
														$barisbrg = mysqli_num_rows($cekbrg);
														$nama_barang="";
														$jenis="";
														$ukuran="";
														$deskripsi="";
														$harga="";
														if($barisbrg>0){
															$dtbrg=mysqli_fetch_array($cekbrg);
															$nama_barang=$dtbrg["nama_barang"];
															$jenis=$dtbrg["jenis"];
															$ukuran=$dtbrg["ukuran"];
															$deskripsi=$dtbrg["deskripsi"];
															$harga=$dtbrg["harga"];
														}
														
													?>
														<tr>
															<td><?php echo $i; ?></td>
															<td><?php echo ucwords($nama_barang); ?></td>
															<td><?php echo ucwords($jenis); ?></td>
															<td><?php echo ucwords($ukuran); ?></td>
															<td><?php echo ucwords($deskripsi); ?></td>
															<td><?php echo "Rp ".number_format($row['harga'],0); ?></td>
															<td><?php echo ucwords($qty_beli); ?></td>
															<td><?php echo ucwords($row['qty']); ?></td>
															<td><?php echo "Rp ".number_format(($row['qty']*$row['harga']),0); ?></td>
										</div>
										</td>
										<td>
											</span>
											<span data-target="#editReturBarang" data-toggle="modal" data-id="<?php echo $row['id']; ?>" data-nama_barang="<?php echo $nama_barang; ?>" data-jenis="<?php echo $jenis; ?>" data-ukuran="<?php echo $ukuran; ?>" data-deskripsi="<?php echo $deskripsi; ?>" data-harga="<?php echo $harga; ?>" data-qty_beli="<?php echo $qty_beli; ?>" data-qty="<?php echo $row['qty']; ?>">
											  <a class="btn btn-primary btn-action mr-1" title="Edit Jumlah Retur" data-toggle="tooltip"><i class="fas fa-pencil-alt"></i></a>
											</span>
											<span data-target="#hapusReturBarang" data-toggle="modal" data-id="<?php echo $row['id']; ?>" data-nama_barang="<?php echo $nama_barang; ?>" data-jenis="<?php echo $jenis; ?>" data-ukuran="<?php echo $ukuran; ?>" data-deskripsi="<?php echo $deskripsi; ?>" data-harga="<?php echo $harga; ?>" data-qty_beli="<?php echo $qty_beli; ?>" data-qty="<?php echo $row['qty']; ?>">
											  <a class="btn btn-danger btn-action mr-1" title="Hapus Barang Retur" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
											</span>
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
					<select class="form-control" id="id" name="id" required="" onchange="changeValue(this.value)" required>
						<option value="">-Pilih-</option>
						<?php
						$query_barang=mysqli_query($conn,"select * from barang order by nama_barang asc");
						while ($row=mysqli_fetch_array($query_barang)){
							echo '<option value="'. $row['id'] .'" '. ' >'. $row['nama_barang'] . ' (Jenis: '. $row['jenis'] .'; Ukuran: '. $row['ukuran'] .'; deskripsi: '. $row['deskripsi'] .')</option>';
						} ?>
					</select>			
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
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
	  
	  
	  <div class="modal fade" tabindex="-1" role="dialog" id="editReturBarang">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Jumlah Retur Barang</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Barang</label>
                  <div class="col-sm-9">
                    <input type="hidden" class="form-control" name="id" id="getId" required="" readonly>
                    <input type="text" class="form-control" name="nama_barang" id="getNama_barang" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Jenis</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="jenis" id="getJenis" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Ukuran</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="ukuran" id="getUkuran" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">deskripsi</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="deskripsi" id="getdeskripsi" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Qty [beli]</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="qty_beli" id="getQty_beli" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>			
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Qty [Retur]</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="qty" id="getQty" onchange="validate_qty2()" required="" value="">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>			
					<script type="text/javascript">
					function validate_qty2(){
						var jumlah_beli= document.getElementById("getQty_beli").value;
						var jumlah= document.getElementById("getQty").value;
						if(jumlah<=0){								
							document.getElementById("getQty").value=1;
						}
						
						if(jumlah>jumlah_beli){								
							document.getElementById("getQty").value=jumlah_beli;
						}
					}
					</script>
                  </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="submit3">Edit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
	  
	  
	  <div class="modal fade" tabindex="-1" role="dialog" id="hapusReturBarang">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Hapus Barang Retur </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-header">
              <h5 class="modal-title">Apakah anda yakin ingin menghapus data ini?</h5>
            </div>
            <div class="modal-body">
              <form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Barang</label>
                  <div class="col-sm-9">
                    <input type="hidden" class="form-control" name="id" id="getId" required="" readonly>
                    <input type="text" class="form-control" name="nama_barang" id="getNama_barang" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Jenis</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="jenis" id="getJenis" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Ukuran</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="ukuran" id="getUkuran" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">deskripsi</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="deskripsi" id="getdeskripsi" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Qty [beli]</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="qty_beli" id="getQty_beli" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>			
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Qty [Retur]</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="qty" id="getQty" required="" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>			
                  </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger" name="submit4">Yes</button>
              </form>
            </div>
          </div>
        </div>
      </div>
		<?php include 'part/footer.php'; ?>
	</div>
	</div>
	<?php include "part/all-js.php"; ?>

	<script>
		$('#editReturBarang').on('show.bs.modal', function(event) {
		  var button = $(event.relatedTarget)
		  var nama_barang = button.data('nama_barang')
		  var id = button.data('id')
		  var jenis = button.data('jenis')
		  var ukuran = button.data('ukuran')
		  var deskripsi = button.data('deskripsi')
		  var harga = button.data('harga')
		  var qty_beli = button.data('qty_beli')
		  var qty = button.data('qty')
		  var modal = $(this)
		  modal.find('#getId').val(id)
		  modal.find('#getNama_barang').val(nama_barang)
		  modal.find('#getJenis').val(jenis)
		  modal.find('#getUkuran').val(ukuran)
		  modal.find('#getdeskripsi').val(deskripsi)
		  modal.find('#getHarga').val(harga)
		  modal.find('#getQty_beli').val(qty_beli)
		  modal.find('#getQty').val(qty)
		})
	</script>
	<script>
		$('#hapusReturBarang').on('show.bs.modal', function(event) {
		  var button = $(event.relatedTarget)
		  var nama_barang = button.data('nama_barang')
		  var id = button.data('id')
		  var jenis = button.data('jenis')
		  var ukuran = button.data('ukuran')
		  var deskripsi = button.data('deskripsi')
		  var harga = button.data('harga')
		  var qty_beli = button.data('qty_beli')
		  var qty = button.data('qty')
		  var modal = $(this)
		  modal.find('#getId').val(id)
		  modal.find('#getNama_barang').val(nama_barang)
		  modal.find('#getJenis').val(jenis)
		  modal.find('#getUkuran').val(ukuran)
		  modal.find('#getdeskripsi').val(deskripsi)
		  modal.find('#getHarga').val(harga)
		  modal.find('#getQty_beli').val(qty_beli)
		  modal.find('#getQty').val(qty)
		})
	</script>
</body>

</html>