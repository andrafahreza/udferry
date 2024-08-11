<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $page = "Dashboard";
  session_start();
  include 'auth/connect.php';
  include "part/head.php";
  //include 'part_func/tgl_ind.php';

  $pegawai = mysqli_query($conn, "SELECT * FROM pegawai WHERE jabatan='2' or jabatan='3'");
  $jumpegawai = mysqli_num_rows($pegawai);
  $pegawai_lapangan = mysqli_query($conn, "SELECT * FROM pegawai WHERE jabatan='3'");
  $jumpegawai_lapangan = mysqli_num_rows($pegawai_lapangan);
  $admin = mysqli_query($conn, "SELECT * FROM pegawai WHERE jabatan='2'");
  $jumadmin = mysqli_num_rows($admin);
  $supplier = mysqli_query($conn, "SELECT * FROM supplier");
  $jumsupplier = mysqli_num_rows($supplier);
  $barang = mysqli_query($conn, "SELECT * FROM barang");
  $jumbarang = mysqli_num_rows($barang);
  $pembelian = mysqli_query($conn, "SELECT * FROM pembelian_header where status='Confirmed'");
  $jumpembelian= mysqli_num_rows($pembelian);
  $penjualan = mysqli_query($conn, "SELECT * FROM penjualan_header where status='Confirmed'");
  $jumpenjualan= mysqli_num_rows($penjualan);
  ?>
  <style>
    #link-no {
      text-decoration: none;
    }
  </style>
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
		<?php 
		$ssssid=@$_SESSION['id_pegawai'];
		if($ssssid==""){
			echo "<script>document.location='barang.php';</script>";
		} ?>
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Pegawai</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $jumpegawai; ?>
                  </div>
                </div>
              </div>
            </div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fab fa-creative-commons-by"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Supplier</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $jumsupplier; ?>
                  </div>
                </div>
              </div>
            </div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-cube"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Barang</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $jumbarang; ?>
                  </div>
                </div>
              </div>
            </div>
			
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-cart-arrow-down"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Transaksi Pembelian</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $jumpembelian; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-cart-plus"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Transaksi Penjualan</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $jumpenjualan; ?>
                  </div>
                </div>
              </div>
            </div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<?php include("grafik.php"); ?>
			</div>
        </section>
      </div>
      <?php include 'part/footer.php'; ?>
    </div>
  </div>

  <?php include "part/all-js.php"; ?>
</body>

</html>