<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $page = "Data Barang";
  session_start();
  include 'auth/connect.php';
  include "part/head.php";

	if (isset($_POST['submit3'])) {
		$id = $_POST['id'];
		$cekpembelian = mysqli_query($conn, "SELECT * FROM pembelian_detail WHERE idbarang='$id'");
		$jtbeli = mysqli_num_rows($cekpembelian);
		$cekpenjualan = mysqli_query($conn, "SELECT * FROM penjualan_detail WHERE idbarang='$id'");
		$jtjual = mysqli_num_rows($cekpenjualan);
		if($jtbeli>0){
			echo '<script>
						setTimeout(function() {
							swal({
							title: "Gagal Dihapus",
							text: "Data barang tidak dapat dihapus, terdapat dalam data pembelian!",
							icon: "warning"
							});
							}, 500);
						</script>';		
		}elseif($jtjual>0){		
			echo '<script>
						setTimeout(function() {
							swal({
							title: "Gagal Dihapus",
							text: "Data barang tidak dapat dihapus, terdapat dalam data penjualan!",
							icon: "warning"
							});
							}, 500);
						</script>';		
		}else{
			$hps3 = mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");
			$stok_gambar="assets/img/barang/".$id.".jpg";
			@unlink($stok_gambar);
			echo '<script>
						setTimeout(function() {
							swal({
							title: "Data Dihapus",
							text: "Data barang berhasil dihapus!",
							icon: "success"
							});
							}, 500);
						</script>';
			
		}
	}
  
	if (isset($_POST['submit'])) {
		$id = $_POST['id'];
		$nama = $_POST['nama'];
		$jenis = $_POST['jenis'];
		$ukuran = $_POST['ukuran'];
		$deskripsi = $_POST['deskripsi'];
		$stok = $_POST['stok'];
		$harga = $_POST['harga'];
		$id_supplier = $_POST['id_supplier'];
		$modif = date("Y-m-d");		

		$up2 = mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', jenis='$jenis',ukuran='$ukuran',deskripsi='$deskripsi',stok='$stok', harga='$harga', id_supplier='$id_supplier', modif='$modif' WHERE id='$id'");

		if(isset($_FILES['gambar'])){
			$nama_gambar = $id;
			$nama_file=$_FILES['gambar']['tmp_name'];
			$file_upload="assets/img/barang/".$nama_gambar.".jpg";
			move_uploaded_file($nama_file,$file_upload);
		}
		
		echo '<script>
					setTimeout(function() {
						swal({
						title: "Data Diubah",
						text: "Data Barang berhasil diubah!",
						icon: "success"
						});
						}, 500);
					</script>';
	}

	if (isset($_POST['submit2'])) {
		$nama = $_POST['nama'];
		$jenis = $_POST['jenis'];
		$ukuran = $_POST['ukuran'];
		$deskripsi = $_POST['deskripsi'];
		$stok = $_POST['stok'];
		$harga = $_POST['harga'];
		$id_supplier = $_POST['id_supplier'];
		$modif = date("Y-m-d");
		
		$add = mysqli_query($conn, "INSERT INTO barang (nama_barang, jenis, ukuran, deskripsi, stok, harga, id_supplier, modif) VALUES ('$nama', '$jenis', '$ukuran', '$deskripsi', '$stok', '$harga', '$id_supplier', '$modif')");

		$sl = mysqli_query($conn, "SELECT * from barang WHERE nama_barang='$nama'");
		$row45=mysqli_fetch_array($sl);
		$id=$row45["id"];
		if(isset($_FILES['gambar'])){
			$nama_gambar = $id;
			$nama_file=$_FILES['gambar']['tmp_name'];
			$file_upload="assets/img/barang/".$id.".jpg";
			move_uploaded_file($nama_file,$file_upload);
		}
		echo '<script>
					setTimeout(function() {
						swal({
							title: "Berhasil!",
							text: "Barang baru telah ditambahkan!",
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
		  <?php if(@$_SESSION['jabatan_user']==1 or @$_SESSION['jabatan_user']==2 or @$_SESSION['jabatan_user']==3){ ?>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4><?php echo $page; ?></h4>
                    <div class="card-header-action">
					<?php if(@$_SESSION["jabatan_user"]==3){ ?>
                      <a href="#" class="btn btn-primary" data-target="#addBarang" data-toggle="modal">Tambahkan Barang Baru</a>
					<?php } ?>
					<span data-target="#notifbarang" data-toggle="modal" >
						<a class="btn btn-danger btn-action mr-1" title="" data-toggle="tooltip"><i class="fas fa-bell"></i></a>
					</span>					  
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Ukuran</th>
                            <th>Deskripsi</th>
                            <th>Stok</th>
                            <th>Harga per unit</th>
                            <th>Nama Supplier</th>
							<?php if(@$_SESSION["jabatan_user"]==3){ ?>
                            <th class="text-center">Action</th>
							<?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = mysqli_query($conn, "SELECT * FROM barang order by id asc");
                          $i = 0;
                          while ($row = mysqli_fetch_array($sql)) {
                            $i++;
                            $stok=$row["stok"];
							$gambar="assets/img/barang/".$row['id'].".jpg";
							$id_supplier=$row["id_supplier"];
							$sql_supp = mysqli_query($conn, "SELECT * FROM supplier where id='$id_supplier'");
							$nama_supplier="";
							if(mysqli_num_rows($sql_supp)>0){
								$row_supp=mysqli_fetch_array($sql_supp);
								$nama_supplier=$row_supp["nama_supplier"];								
							}
							
                          ?>
                            <tr <?php if($stok<=10){echo "bgcolor='red'";} ?>>
                              <td><?php echo $i; ?></td>
                              <td><?php echo ucwords($row['nama_barang']) ?></td>
                              <td><?php echo ucwords($row['jenis']) ?></td>
                              <td><?php echo ucwords($row['ukuran']) ?></td>
                              <td><?php echo ucwords($row['deskripsi']) ?></td>
                              <td><?php echo $row['stok'] . ""; ?></td>
                              <td>Rp. <?php echo number_format($row['harga'], 0, ".", "."); ?></td>
                              <td><?php echo $nama_supplier; ?></td>
							<?php if(@$_SESSION["jabatan_user"]==3){ ?>
                              <td align="center">
								
                                <span data-target="#editBarang" data-toggle="modal" data-id="<?php echo $row['id']; ?>" data-nama="<?php echo $row['nama_barang']; ?>" data-jenis="<?php echo $row['jenis']; ?>" data-ukuran="<?php echo $row['ukuran']; ?>" data-deskripsi="<?php echo $row['deskripsi']; ?>" data-harga="<?php echo $row['harga']; ?>" data-stok="<?php echo $row['stok']; ?>" data-gambar="<?php echo $gambar; ?>" data-id_supplier="<?php echo $row["id_supplier"]; ?>">
                                  <a class="btn btn-warning btn-action mr-1" title="Edit Data Barang" data-toggle="tooltip"><i class="fas fa-pencil-alt"></i></a>
                                </span>
								
                                <span data-target="#hapusBarang" data-toggle="modal" data-id="<?php echo $row['id']; ?>" data-nama="<?php echo $row['nama_barang']; ?>" data-jenis="<?php echo $row['jenis']; ?>" data-ukuran="<?php echo $row['ukuran']; ?>" data-deskripsi="<?php echo $row['deskripsi']; ?>" data-harga="<?php echo $row['harga']; ?>" data-stok="<?php echo $row['stok']; ?>" data-gambar="<?php echo $gambar; ?>" data-nama_supplier="<?php echo $nama_supplier; ?>">
                                  <a class="btn btn-danger btn-action mr-1" title="Hapus Data Barang" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
                                </span>
                              </td>
							<?php } ?>
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

		  <?php }else{ ?>
          <div class="section-body">
			<div class="row">
				<?php $sql = mysqli_query($conn, "SELECT * FROM barang  order by nama_barang desc");
					if(@$_POST["cari_barang"]){ 
						$cari_barang=$_POST["cari_barang"];
						echo '<script>
							document.location="barang.php?cari_barang='.$cari_barang.'";
						</script>';
					}
					if(@$_GET["id"]){ 
						$id=$_GET["id"];
						$_SESSION["id_barang"]=$id;
						$sql = mysqli_query($conn, "SELECT * FROM barang where id='$id'");							
					}?>
					<?php 
					
					if(@$_GET["cari_barang"] ){ 
						$cari_barang=$_GET["cari_barang"];
						$sql = mysqli_query($conn, "SELECT * FROM barang where nama_barang like '%".$cari_barang."%'");	
					}
					?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="section-body">
							<div class="row">
								<div class="col-12">
									<div class="card">
										<div class="card-header">
											<form action="barang.php" method="POST" class="needs-validation" novalidate="" autocomplete="off" enctype="multipart/form-data" >																							 
												  <div class="input-group col-sm-12">
													<input type="text" class="form-control" name="cari_barang" required="" placeholder="Cari barang" value="<?php echo @$_GET["cari_barang"] ?>">
													<button type="submit" class="btn btn-primary" name="submit_cari"><i class="fas fa-search"></i> </button>
													<div class="invalid-feedback">
													  Mohon data diisi!
													</div>
												  </div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>					
					</div>					
					<?php
					if(mysqli_num_rows($sql)>0){ ?>
					<?php 
						while($row=mysqli_fetch_array($sql)){ ?>
						<div class="col-lg-<?php if (@$_GET["id"]){echo "12"; }else{ echo 3;} ?> col-md-12 col-sm-12 col-12">
							<?php 
							$id_barang = $row["id"];
							$nama_barang = $row["nama_barang"];
							$ukuran = $row["ukuran"];
							$stok = $row["stok"];
							$harga=$row["harga"];
							$harga = "Rp ".number_format($row["harga"],0);
							$deskripsi = $row["deskripsi"];
							$nama_gambar = $row["id"].".jpg";
							$gambar = "assets/img/barang/".$nama_gambar;
							if(!file_exists($gambar)){
								$gambar = "assets/img/logo.jpg";
							}
						?>
								<div class="section-body">
									<div class="row">
										<div class="col-12">
											<div class="card">
												<div class="card-header" style="height:80px">
													<h5><?php echo substr(ucwords($nama_barang),0,20).""; ?></h5>
												</div>
												<div class="row">
													<div class="card-body">
														<a href="produk.php?id=<?php echo $row["id"]; ?>" class="table-responsive" title="Detail Produk" data-toggle="tooltip"><img src="<?php echo $gambar; ?>" style="width:100%"/></a>													
														<p align='justify'>
														Stok tersedia : <b><?php echo $stok; ?></b><br>
														Harga : <b><?php echo "<font color='red'>".$harga."</font>"; ?></b><br>
														<?php echo "<b>Deskrripsi : </b><br>".$deskripsi; ?>
														</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>	  			
					<?php }else{?>
					<div class="col-lg-12 col-md-6 col-sm-6 col-12">
						<div class="section-body">
							<div class="row">
								<div class="col-12">
									<div class="card">
										<div class="card-header">
											<div class="input-group col-sm-12">												  
													<div style="color:red;">
													  Produk tidak ditemukan!
													</div>
											  </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>					
					<?php } ?>	  			
			<?php } ?>
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
              <form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off" enctype="multipart/form-data" >
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Barang</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="nama" required="" id="getNama">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Jenis</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="jenis" required="" value="">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Ukuran</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="ukuran" required="" value="">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Deskripsi</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="deskripsi" required="" value="">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Stok Barang</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="stok" required="" value="">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Harga</label>
                  <div class="input-group col-sm-9">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        Rp
                      </div>
                    </div>
                    <input type="number" class="form-control" name="harga" required="" value="0">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
				<div class="form-group row">
                  <label class="col-sm-3 col-form-label">Gambar</label>
                  <div class="col-sm-9">
					<input type="file" class="myImg" name="gambar" id="getGambar" accept="image/*" required="">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
				<div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Supplier</label>
                  <div class="col-sm-9">
					<select class="form-control" name="id_supplier" id="getId_supplier" required="">
						<option value="">-Pilih-</option>
						<?php
						$query=mysqli_query($conn,"select * from supplier order by nama_supplier asc");
						while ($row_supp=mysqli_fetch_array($query)){
							if(@$_SESSION['SD_supp']==$row_supp['id']){
								$sel='selected';
							}else{
								$sel='';
							}
							echo '<option value="'. $row_supp['id'] .'" '. $sel .' >'. $row_supp['nama_supplier'] .'</option>';
						} ?>
					</select>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
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
	  
	  <div class="modal fade" tabindex="-1" role="dialog" id="notifbarang">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Barang/Stok yang baru di tambah/ubah</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
			<?php 
			$sql111 = mysqli_query($conn, "SELECT * FROM barang where modif='".date("Y-m-d")."' order by modif desc");
			$i = 0;
			if(mysqli_fetch_array($sql111)>0){
			while ($row11 = mysqli_fetch_array($sql111)) { ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				  <div class="card card-statistic-1">
					<div class="card-icon bg-secondary">
					  <img src="assets/img/barang/<?php echo $row11["id"] ?>.jpg" height="90px">
					</div>
					<div class="card-wrap">
					  <div class="card-header">
						<h4><?php echo $row11["nama_barang"]; ?></h4>
					  </div>
					  <div class="card-body">
						<h4>Stok : <?php echo $row11["stok"]; ?></h4>
					  </div>
					</div>
				  </div>
				</div>
			<?php }}else{ ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				  <div class="card card-statistic-1">
					<div class="card-wrap">
					  <div class="card-header">
						Tidak ada penambahan barang/stok
					  </div>
					</div>
				  </div>
				</div>
			<?php } ?>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" tabindex="-1" role="dialog" id="editBarang">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off" enctype="multipart/form-data" >
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Barang</label>
                  <div class="col-sm-9">
                    <input type="hidden" class="form-control" name="id" required="" id="getId">
                    <input type="text" class="form-control" name="nama" required="" id="getNama">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Jenis</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="jenis" required="" id="getJenis">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Ukuran</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="ukuran" required="" id="getUkuran">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Deskripsi</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="deskripsi" required="" id="getDeskripsi">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Stok Barang</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="stok" required="" id="getStok">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Harga</label>
                  <div class="input-group col-sm-9">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        Rp
                      </div>
                    </div>
                    <input type="number" class="form-control" name="harga" required="" id="getHarga">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Gambar</label>
                  <div class="col-sm-9">
					 <img id="gambar2" src="" width="100%">
					 <input type="file" class="myImg" name="gambar" accept="image/*">
                  </div>
                </div>
				<div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Supplier</label>
                  <div class="col-sm-9">
					<select class="form-control" name="id_supplier" id="getId_supplier" required="">
						<option value="">-Pilih-</option>
						<?php
						$query=mysqli_query($conn,"select * from supplier order by nama_supplier asc");
						while ($row_supp=mysqli_fetch_array($query)){
							if(@$_SESSION['SD_supp']==$row_supp['id']){
								$sel='selected';
							}else{
								$sel='';
							}
							echo '<option value="'. $row_supp['id'] .'" '. $sel .' >'. $row_supp['nama_supplier'] .'</option>';
						} ?>
					</select>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>				
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="submit">Edit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
	  
	  <div class="modal fade" tabindex="-1" role="dialog" id="hapusBarang">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Hapus Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-header">
              <h5 class="modal-title">Apakah anda yakin ingin menghapus data ini?</h5>
            </div>
            <div class="modal-body">
              <form action="" method="POST" class="needs-validation" novalidate="" autocomplete="off" enctype="multipart/form-data" >
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Barang</label>
                  <div class="col-sm-9">
                    <input type="hidden" class="form-control" name="id" required="" id="getId">
                    <input type="text" class="form-control" name="nama" required="" id="getNama" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Jenis</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="jenis" required="" id="getJenis"  readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Ukuran</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="ukuran" required="" id="getUkuran"  readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Deskripsi</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="deskripsi" required="" id="getDeskripsi"  readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Stok Barang</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="stok" required="" id="getStok"  readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Harga</label>
                  <div class="input-group col-sm-9">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        Rp
                      </div>
                    </div>
                    <input type="number" class="form-control" name="harga" required="" id="getHarga"  readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
				<div class="form-group row">
                  <label class="col-sm-3 col-form-label">Gambar</label>
                  <div class="col-sm-9">
					 <img id="gambar3" src="" width="100%">
                  </div>
                </div>	
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Supplier</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="nama_supplier" required="" id="getNama_supplier"  readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>				
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit3" class="btn btn-danger" name="submit3">Yes</button>
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
    $('#editBarang').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var nama = button.data('nama')
      var id = button.data('id')
      var jenis = button.data('jenis')
      var ukuran = button.data('ukuran')
      var deskripsi = button.data('deskripsi')
      var stok = button.data('stok')
      var harga = button.data('harga')
      var id_supplier = button.data('id_supplier')
      var gambar = button.data('gambar')	  
      var modal = $(this)
      modal.find('#getId').val(id)
      modal.find('#getNama').val(nama)
      modal.find('#getJenis').val(jenis)
      modal.find('#getUkuran').val(ukuran)
      modal.find('#getDeskripsi').val(deskripsi)
      modal.find('#getStok').val(stok)
      modal.find('#getHarga').val(harga)
      modal.find('#getId_supplier').val(id_supplier)
	  modal.find('#getGambar').val(gambar)
	  document.getElementById('gambar2').src="assets/img/logo.png";
	  document.getElementById('gambar2').src=gambar;	  
    })
  </script>
  <script>
    $('#hapusBarang').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var nama = button.data('nama')
      var id = button.data('id')
      var jenis = button.data('jenis')
      var ukuran = button.data('ukuran')
      var deskripsi = button.data('deskripsi')
      var stok = button.data('stok')
      var harga = button.data('harga')
	  var nama_supplier = button.data('nama_supplier')
      var gambar = button.data('gambar')	  
      var modal = $(this)
      modal.find('#getId').val(id)
      modal.find('#getNama').val(nama)
      modal.find('#getJenis').val(jenis)
      modal.find('#getUkuran').val(ukuran)
      modal.find('#getDeskripsi').val(deskripsi)
      modal.find('#getStok').val(stok)
      modal.find('#getHarga').val(harga)
      modal.find('#getNama_supplier').val(nama_supplier)
      modal.find('#getGambar').val(gambar)
	  document.getElementById('gambar3').src="assets/img/logo.png";
	  document.getElementById('gambar3').src=gambar;	  
    })
  </script>
</body>

</html>