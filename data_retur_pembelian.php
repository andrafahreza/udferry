<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	$page = "Retur Pembelian";
	session_start();
	include 'auth/connect.php';
	include "part/head.php";
	include "part_func/tgl_ind.php";
	include "part_func/umur.php";

	if (isset($_POST['submit3'])) {
			$id = $_POST['nota_retur_pembelian'];
			$hps1 = mysqli_query($conn, "DELETE FROM retur_pembelian_detail WHERE nota_retur_pembelian='$id'");
			$hps2 = mysqli_query($conn, "DELETE FROM retur_pembelian_header WHERE nota_retur_pembelian='$id'");
			echo '<script>
						setTimeout(function() {
							swal({
							title: "Data Dihapus",
							text: "Data retur pembelian berhasil dihapus!",
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
                  <div class="card-header">
                    <h4>Retur Pembelian</h4>
                    <div class="card-header-action">
					  <a href="retur_pembelian.php" class="btn btn-primary">Tambah</a> 					
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th>Nota Retur Pembelian</th>
                            <th>Nota Pembelian</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Sub Total</th>
							<?php if (@$_SESSION['jabatan_user']==3){?>
                            <th>Action</th>
							<?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = mysqli_query($conn, "SELECT * FROM retur_pembelian_header join pembelian_header on retur_pembelian_header.nota_pembelian=pembelian_header.nota_pembelian join supplier on pembelian_header.id=supplier.id order by retur_pembelian_header.nota_retur_pembelian desc");
                          $i = 0;
                          while ($row = mysqli_fetch_array($sql)) {
							$total=0;
							$sql2 = mysqli_query($conn, "SELECT * FROM retur_pembelian_detail where nota_retur_pembelian='".$row["nota_retur_pembelian"]."'");
							while($row2 = mysqli_fetch_array($sql2)){
								$jlh=$row2["harga"]*$row2["qty"];
								$total=$total+$jlh;
								}
                            $idbarang = $row['id'];
                            $i++;
                          ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo ucwords($row['nota_retur_pembelian']) ?></td>
                              <td><?php echo ucwords($row['nota_pembelian']) ?></td>
                              <td><?php echo date('d F Y', strtotime($row['tanggal'])) ?></td>
                              <td><?php echo ucwords($row['nama_supplier']) ?></td>
                              <td>Rp. <?php echo number_format($total, 0, ".", "."); ?></td>
							  <?php if (@$_SESSION['jabatan_user']==3){?>
							  <td rowspan="2">
                                <span data-target="#hapusPembelian" data-toggle="modal" data-nota_retur_pembelian="<?php echo $row['nota_retur_pembelian']; ?>" data-tanggal="<?php echo $row['tanggal']; ?>" data-nama_supplier="<?php echo $row['nama_supplier']; ?>">
                                  <a class="btn btn-danger btn-action mr-1" title="Hapus" data-toggle="tooltip"><i class="fas fa-trash"></i></a>
                                </span>
							  </td>
							  <?php } ?>
                            </tr>
							<tr>
							  <td></td>
                              <td colspan="4">
								<table class="table table-striped" id="table-0">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th>Nama Barang</th>
											<th>Jenis</th>
											<th>Ukuran</th>
											<th>Dekripsi</th>
											<th>Harga</th>
											<th>Qty</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql_detail = mysqli_query($conn, "SELECT * FROM retur_pembelian_detail join barang on retur_pembelian_detail.idbarang=barang.id where nota_retur_pembelian='".$row["nota_retur_pembelian"]."'");
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
          </div>
        </section>
      </div>
	  
	  
	  <div class="modal fade" tabindex="-1" role="dialog" id="hapusPembelian">
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
              <form action="" method="POST" class="needs-validation" novalidate="">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nota Retur Pembelian</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nota_retur_pembelian" required="" id="getNota_retur_pembelian" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tanggal</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="tanggal" required="" id="getTanggal"  readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nama Supplier</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nama_supplier" required="" id="getNama_supplier"  readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
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
	  </div>
	  
      <?php include 'part/footer.php'; ?>
    </div>
  </div>
  <?php include "part/all-js.php"; ?>
  
  <script>
    $('#hapusPembelian').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var nota_retur_pembelian = button.data('nota_retur_pembelian')
      var tanggal = button.data('tanggal')
      var nama_supplier = button.data('nama_supplier')
      var modal = $(this)
      modal.find('#getNota_retur_pembelian').val(nota_retur_pembelian)
      modal.find('#getTanggal').val(tanggal)
      modal.find('#getNama_supplier').val(nama_supplier)
    })
  </script>
</body>

</html>