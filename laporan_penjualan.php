<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	$page = "Laporan Penjualan";
	session_start();
	include 'auth/connect.php';
	include "part/head.php";
	include "part_func/tgl_ind.php";
	include "part_func/umur.php";
	
	
	if (isset($_POST['submit3'])) {
			$id = $_POST['nota_penjualan'];
			$hps1 = mysqli_query($conn, "DELETE FROM penjualan_detail WHERE nota_penjualan='$id'");
			$hps2 = mysqli_query($conn, "DELETE FROM penjualan_header WHERE nota_penjualan='$id'");
			echo '<script>
						setTimeout(function() {
							swal({
							title: "Data Dihapus",
							text: "Data penjualan berhasil dihapus!",
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
                    <h4>Penjualan</h4>
                    <div class="card-header-action">
						<form method="POST" action="print_penjualan.php" target="_blank">
							<div class="btn-group">
							  <button type="submit" class="btn btn-primary" name="printone" title="Print" data-toggle="tooltip"><i class="fas fa-print"></i> Cetak</button>
							</div>
						</form>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
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
                            //$idbarang = $row2['idbarang'];
                            $i++;
                          ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo ucwords($row['nota_penjualan']) ?></td>
                              <td><?php echo date('d F Y', strtotime($row['tanggal'])) ?></td>
                              <td>Rp. <?php echo number_format($total, 0, ".", "."); ?></td>
                            </tr>
							<tr>
							  <td rowspan="" valign="top"></td>
                              <td colspan="3">
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
          </div>
        </section>
      </div>
	  
	  <div class="modal fade" tabindex="-1" role="dialog" id="hapusPenjualan">
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
                  <label class="col-sm-3 col-form-label">Nota Penjualan</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="nota_penjualan" required="" id="getNota_penjualan" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Tanggal</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="tanggal" required="" id="getTanggal"  readonly>
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
    $('#hapusPenjualan').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var nota_penjualan = button.data('nota_penjualan')
      var tanggal = button.data('tanggal')
      var modal = $(this)
      modal.find('#getNota_penjualan').val(nota_penjualan)
      modal.find('#getTanggal').val(tanggal)
    })
  </script>

</body>

</html>