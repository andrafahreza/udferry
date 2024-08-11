<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $page = "Laporan Barang";
  session_start();
  include 'auth/connect.php';
  include "part/head.php";
  include "part_func/tgl_ind.php";
  include "part_func/umur.php";
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
                    <h4>Barang</h4>
                    <div class="card-header-action">
						<form method="POST" action="print_barang.php" target="_blank">
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
                            <th>Nama Barang</th>
                            <th>Jenis</th>
                            <th>Ukuran</th>
                            <th>Deskripsi</th>
                            <th>Stok</th>
                            <th>Harga</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = mysqli_query($conn, "SELECT * FROM barang");
                          $i = 0;
                          while ($row = mysqli_fetch_array($sql)) {
                            $idbarang = $row['id'];
                            $i++;
                          ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo ucwords($row['nama_barang']) ?></td>
                              <td><?php echo ucwords($row['jenis']) ?></td>
                              <td><?php echo ucwords($row['ukuran']) ?></td>
                              <td><?php echo ucwords($row['deskripsi']) ?></td>
                              <td><?php echo $row['stok'] . ""; ?></td>
                              <td>Rp. <?php echo number_format($row['harga'], 0, ".", "."); ?></td>
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
      <?php include 'part/footer.php'; ?>
    </div>
  </div>
  <?php include "part/all-js.php"; ?>
</body>

</html>