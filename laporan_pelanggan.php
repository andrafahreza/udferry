<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $page = "Laporan Pelanggan";
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
                    <h4>Pelanggan</h4>
                    <div class="card-header-action">
						<form method="POST" action="print_pelanggan.php" target="_blank">
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
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>telepon</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = mysqli_query($conn, "SELECT * FROM pelanggan");
                          $i = 0;
                          while ($row = mysqli_fetch_array($sql)) {
                            $idpelanggan = $row['id'];
                            $i++;
                          ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <th><?php echo ucwords($row['nama_pelanggan']); ?></th>
                              <th><?php echo ucwords($row['alamat']); ?></th>
                              <th><?php echo ucwords($row['telepon']); ?></th>
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