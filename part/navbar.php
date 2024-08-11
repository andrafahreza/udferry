<?php  
$id="";
$nama_pegawai="";
$username="";
$alamat="";
$passwor_lama="";
$passwor_baru="";

if (isset($_POST['submit_navbar'])) {
	$id = $_POST['iduser'];
	$nama_pegawai = $_POST['nama_pegawai'];
	$username = $_POST['username'];
	$alamat = $_POST['alamat'];
	$old_pass = $_POST['old_password'];
	$new_pass = $_POST['new_password'];

	if ($old_pass == "" && $new_pass == "") {
		$up1 = mysqli_query($conn, "UPDATE pegawai SET nama_pegawai='$nama_pegawai', username='$username', alamat='$alamat' WHERE id='$id'");
		echo '<script>
		setTimeout(function() {
			swal({
				title: "Data Diubah",
				text: "Data berhasil diubah!",
				icon: "success"
				});
				}, 500);
				</script>';
	} elseif ($old_pass != "" && $new_pass != "") {
		$cekpass = mysqli_query($conn, "SELECT * FROM pegawai WHERE id='$id' AND password='$old_pass'");
		$cekada = mysqli_num_rows($cekpass);
		if ($cekada == 0) {
			echo '<script>
					setTimeout(function() {
						swal({
							title: "Password salah",
							text: "Password salah, cek kembali form password anda!",
							icon: "error"
							});
							}, 500);
							</script>';
		} else {
			$up2 = mysqli_query($conn, "UPDATE pegawai SET nama_pegawai='$nama_pegawai', username='$username', password='$new_pass', alamat='$alamat' WHERE id='$id'");
			echo '<script>
			setTimeout(function() {
				swal({
				title: "Data Diubah",
				text: "Data atau Password berhasil diubah!",
				icon: "success"
				});
				}, 500);
			</script>';
		}
	}
}

?>
<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
	<?php
	if(@$_SESSION['id_pegawai']){
		$sessionid=@$_SESSION['id_pegawai'];
		$nama = mysqli_query($conn, "SELECT * FROM pegawai WHERE id='$sessionid'");	
		$output = mysqli_fetch_array($nama);
		$id=$output["id"];
		$nama_pegawai=$output["nama_pegawai"];
		$username=$output["username"];
		$alamat=$output["alamat"];
		$passwor_lama=$output["password"];
		$passwor_baru=$output["password"];
		
		if($output["jabatan"] == "1"){
			$avatar="avatar-2.png";
		  }elseif($output["jabatan"] == "2"){
			$avatar="avatar-5.png";
		  }else{
			$avatar="avatar-4.png";
		  }
		?>
		  <img alt="image" src="assets/img/avatar/<?php echo $avatar; ?>" class="rounded-circle mr-1">
		  <div class="d-sm-none d-lg-inline-block">Hi, <?php echo ucwords($output['nama_pegawai']); ?></div></a>
		  <div class="dropdown-menu dropdown-menu-right">
			<div class="dropdown-title"><i class="fas fa-circle text-success"></i>
			  <?php
			  if($output["jabatan"] == "1"){
				echo "Pemilik";
			  }elseif($output["jabatan"] == "2"){
				echo "Admin/Kasir";
			  }else{
				echo "Bagian Gudang";
			  }
			  ?>
			</div>
			<div class="dropdown-divider"></div>
			<a  href="#" data-target="#editProfil" data-toggle="modal" class="dropdown-item has-icon text-primary">
			  <i class="fas fa-user"></i> Edit Profil
			</a>
			<div class="dropdown-divider"></div>
			<a href="#" data-target="#ModalLogout" data-toggle="modal" class="dropdown-item has-icon text-danger">
			  <i class="fas fa-sign-out-alt"></i> Logout
			</a>
		  </div>
	<?php }else{ ?>
		  <img alt="image" src="assets/img/avatar/avatar-3.png" class="rounded-circle mr-1">
		  <div class="d-sm-none d-lg-inline-block">Pengguna</div></a>
		  <div class="dropdown-menu dropdown-menu-right">
			<div class="dropdown-divider"></div>
			<a href="auth/" class="dropdown-item has-icon text-danger">
			  <i class="fas fa-sign-out-alt"></i> Login
			</a>
		  </div>
	<?php } ?>
    </li>
  </ul>
</nav>

	<!--EDIT PROFIL-->
	<div class="modal fade" tabindex="-1" role="dialog" id="editProfil">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Profil</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="" method="POST" class="needs-validation" novalidate="">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Nama Lengkap</label>
							<div class="col-sm-9">
								<input type="hidden" class="form-control" name="iduser" required="" value="<?php echo $id; ?>">
								<input type="text" class="form-control" name="nama_pegawai" required="" value="<?php echo $nama_pegawai; ?>">
								<div class="invalid-feedback">
									Mohon data diisi!
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Username</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="username" required="" value="<?php echo $username; ?>" readonly>
								<div class="invalid-feedback">
									Mohon data diisi!
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Alamat</label>
							<div class="col-sm-9">
								<textarea class="form-control" required="" name="alamat"><?php echo $alamat; ?></textarea>	
							</div>
						</div>
						<div class="alert alert-light text-center">
							Jika password tidak diganti, form dibawah dikosongi saja.
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Password Lama</label>
							<div class="col-sm-9">
								<input type="password" name="old_password" id="old_password2" class="form-control"   onfocus="unlockpassword4()"  onfocusout="lockpassword4()"  value="<?php echo $passwor_lama; ?>">
								<script>
									function unlockpassword4(){
											document.getElementById('old_password2').type='text';
									} 
									function lockpassword4(){
											document.getElementById('old_password2').type='password';
									} 
								</script>
							</div>							
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Password Baru</label>
							<div class="col-sm-9">
								<input type="password" name="new_password" id="new_password2"  class="form-control"  onfocus="unlockpassword5()" onfocusout="lockpassword5()" value="<?php echo $passwor_baru; ?>">
								<script>
									function unlockpassword5(){
										document.getElementById('new_password2').type='text';
									} 
									function lockpassword5(){
										document.getElementById('new_password2').type='password';
									} 
								</script>
							</div>
						</div>
				</div>
				<div class="modal-footer bg-whitesmoke br">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit_navbar" class="btn btn-primary" name="submit_navbar">Edit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
<div class="modal fade" tabindex="-1" role="dialog" id="ModalLogout">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Logout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda Yakin Ingin Logout?</p>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="window.location.href = 'auth/logout.php';" class="btn btn-danger">Ya</button>
      </div>
    </div>
  </div>
</div>