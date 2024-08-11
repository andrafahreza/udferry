<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	$page = "Data Pelanggan";
	session_start();
	include 'auth/connect.php';
	include "part/head.php";

	if (isset($_POST['submit3'])) {
		$id = $_POST['id'];
		$cekpembelian = mysqli_query($conn, "SELECT * FROM penjualan_header WHERE id='$id'");
		$jtbeli = mysqli_num_rows($cekpembelian);
		if($jtbeli>0){
			echo '<script>
						setTimeout(function() {
							swal({
							title: "Gagal Dihapus",
							text: "Data pelanggan tidak dapat dihapus, terdapat dalam data penjualan!",
							icon: "warning"
							});
							}, 500);
						</script>';		
		}else{
			$hps3 = mysqli_query($conn, "DELETE FROM pelanggan WHERE id='$id'");
			echo '<script>
						setTimeout(function() {
							swal({
							title: "Data Dihapus",
							text: "Data pelanggan berhasil dihapus!",
							icon: "success"
							});
							}, 500);
						</script>';
			
		}
	}
  
	if (isset($_POST['submit'])) {
		$id = $_POST['idpelanggan'];
		$nama = $_POST['nama'];
		$telepon = $_POST['telepon'];
		$alam = $_POST['alamat'];

			$up1 = mysqli_query($conn, "UPDATE pelanggan SET nama_pelanggan='$nama', telepon='$telepon', alamat='$alam' WHERE id='$id'");
			echo '<script>
			setTimeout(function() {
				swal({
					title: "Data Diubah",
					text: "Data berhasil diubah!",
					icon: "success"
					});
					}, 500);
					</script>';
	}

	if (isset($_POST['submit2'])) {
		$nama = $_POST['nama'];
		$telepon = $_POST['telepon'];
		$alam = $_POST['alamat'];

		$cekpelanggan = mysqli_query($conn, "SELECT * FROM pelanggan WHERE nama_pelanggan='$nama'");
		$baris = mysqli_num_rows($cekpelanggan);
		if ($baris >= 1) {
			echo '<script>
				setTimeout(function() {
					swal({
						title: "nama pelanggan sudah digunakan",
						text: "nama pelanggan sudah digunakan, masukkan pelanggan yang lain!",
						icon: "error"
						});
					}, 500);
			</script>';
		} else {
			$add = mysqli_query($conn, "INSERT INTO pelanggan (telepon, nama_pelanggan, alamat) VALUES ('$telepon', '$nama', '$alam')");
			echo '<script>
				setTimeout(function() {
					swal({
						title: "Berhasil!",
						text: "Pelanggan telah ditambahkan!",
						icon: "success"
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
											<a href="#" class="btn btn-primary" data-target="#addPelanggan" data-toggle="modal">Tambah Pelanggan</a>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-striped" id="table-1">
												<thead>
													<tr>
														<th class="text-center">
															#
														</th>
														<th>Nama Pelanggan</th>
														<th>Alamat</th>
														<th>Telepon</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sql = mysqli_query($conn, "SELECT * FROM pelanggan");
													$i = 0;
													while ($row = mysqli_fetch_array($sql)) {
														$i++;
													?>
														<tr>
															<td><?php echo $i; ?></td>
															<td><?php echo ucwords($row['nama_pelanggan']); ?></td>
															<td><?php echo ucwords($row['alamat']); ?></td>
															<td><?php echo ucwords($row['telepon']); ?></td>
										</div>
										</td>
										<td>
											<span data-target="#editPelanggan" data-toggle="modal" data-id="<?php echo $row['id']; ?>" data-nama="<?php echo $row['nama_pelanggan']; ?>" data-telepon="<?php echo $row['telepon']; ?>" data-alam="<?php echo $row['alamat']; ?>">
												<a class="btn btn-primary btn-action mr-1" title="Edit" data-toggle="tooltip"><i class="fas fa-pencil-alt"></i></a>
											</span>
											<span data-target="#hapusPelanggan" data-toggle="modal" data-id="<?php echo $row['id']; ?>" data-nama="<?php echo $row['nama_pelanggan']; ?>" data-telepon="<?php echo $row['telepon']; ?>" data-alam="<?php echo $row['alamat']; ?>">
												<a class="btn btn-danger btn-action mr-1" title="Hapus" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
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

		<div class="modal fade" tabindex="-1" role="dialog" id="addPelanggan">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Tambah Pelanggan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="" method="POST" class="needs-validation" novalidate="">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Nama Pelanggan</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="nama" required="">
									<div class="invalid-feedback">
										Mohon data diisi!
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Telepon</label>
								<div class="col-sm-9">
									<input type="number" class="form-control" name="telepon" required="">
									<div class="invalid-feedback">
										Mohon data diisi!
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Alamat</label>
								<textarea class="form-control" required="" name="alamat"></textarea>
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

		<div class="modal fade" tabindex="-1" role="dialog" id="editPelanggan">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit Data</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="" method="POST" class="needs-validation" novalidate="">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Nama Pelanggan</label>
								<div class="col-sm-9">
									<input type="hidden" class="form-control" name="idpelanggan" required="" id="getId">
									<input type="text" class="form-control" name="nama" required="" id="getNama">
									<div class="invalid-feedback">
										Mohon data diisi!
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Telepon</label>
								<div class="col-sm-9">
									<input type="number" class="form-control" name="telepon" required="" id="getTelepon">
									<div class="invalid-feedback">
										Mohon data diisi!
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Alamat</label>
								<textarea class="form-control" required="" name="alamat" id="getAddrs"></textarea>
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
		
		<div class="modal fade" tabindex="-1" role="dialog" id="hapusPelanggan">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Hapus Data</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-header">
						<h5 class="modal-title">Apakah anda ingin menghapus data ini?</h5>
					</div>
					<div class="modal-body">
						<form action="" method="POST" class="needs-validation" novalidate="">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Nama Pelanggan</label>
								<div class="col-sm-9">
									<input type="hidden" class="form-control" name="id" required="" id="getId">
									<input type="text" class="form-control" name="nama" required="" id="getNama" readonly>
									<div class="invalid-feedback">
										Mohon data diisi!
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Telepon</label>
								<div class="col-sm-9">
									<input type="number" class="form-control" name="telepon" required="" id="getTelepon"readonly>
									<div class="invalid-feedback">
										Mohon data diisi!
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Alamat</label>
								<div class="col-sm-9">
									<textarea class="form-control" required="" name="alamat" id="getAddrs" readonly></textarea>
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
		$('#editPelanggan').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var nama = button.data('nama')
			var telepon = button.data('telepon')
			var alam = button.data('alam')
			var id = button.data('id')
			var modal = $(this)
			modal.find('#getId').val(id)
			modal.find('#getNama').val(nama)
			modal.find('#getTelepon').val(telepon)
			modal.find('#getAddrs').val(alam)
		})
	</script>
	<script>
		$('#hapusPelanggan').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var nama = button.data('nama')
			var telepon = button.data('telepon')
			var alam = button.data('alam')
			var id = button.data('id')
			var modal = $(this)
			modal.find('#getId').val(id)
			modal.find('#getNama').val(nama)
			modal.find('#getTelepon').val(telepon)
			modal.find('#getAddrs').val(alam)
		})
	</script>
</body>

</html>