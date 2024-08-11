<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $page = "Profil";
  session_start();
  include 'auth/connect.php';
  include "part/head.php";
  //include 'part_func/tgl_ind.php';
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
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">	
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<div class="card card-statistic-1">
						<div class="card-wrap">
						  <div class="card-header">
							<center><h3>Usaha Dagang Ferry</h3></center>
						  </div>
						</div>
					</div>
					<div class="col-lg-12" align="justify">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;						
						Usaha Dagang Ferry merupakan salah satu Toko atau Grosir yang ada di Desa Sambosar Raya, Kecamatan Raya Kahean, Kabupaten Simalungn. Pada awal tahun 2010, seorang wirausahawan mendirikan sebuah usaha penjualan barang-barang harian, yang menual kebutuhan sehari-hari, Bahan-bahan pertanian, kebutuha  pokok, BRI-Link, dan alat kecantikan di kawasan Desa Sambosar Raya. Pemilik usaha ini bernama Alimin Zuhri seorang wirausahawan yang berhasil memanfaatkan perkembangan kebutuhan masyarakat yang ada di sekitar wilayah tempat tinggalnya. Pada awalnya Bpk. Alimin ini hanya menjual sebatas barang-barang kebutuhan harian saja, seperti sembako. Namun seiring dengan perkembangan kebutuhan masyarakat yang semakin meningkat dan beragam, maka Bpk. Alimin Zuhri menyiasati perubahan kebutuhan itu dengan menambah barang dagangannya. Maka pada tahun 2010 Bpk. Alimin mendirikan sebuah usaha grosir yang diberi nama Usaha Dagang FERRY. Pemberian nama yang unik ini dianggap sebagai salah satu pemberi daya tarik bagi masyarakat untuk berbelanja di swalayan ini. Karena perkembangan usaha yang semakin meningkat ini, maka usaha yang awalnya hanyalah sebuah usaha grosiran ini lama kelamaan menjelma menjadi salah satu grosir yang besar di Desa tersebut. Usaha yang pada awalnya hanya memiliki beberapa orang karyawan ini, sekarang telah memiliki 10 Karyawan. Dan memiliki omset penjualan yang semakin meningkat 

					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="card">
					<div class="card card-statistic-1">
						<div class="card-wrap">
						  <div class="card-header">
							<h3><center>Gambar Toko</center></h3>
						  </div>
						</div>
					</div>
					<div class="col-lg-12">
					<center>
						<img src="assets/img/toko.jpg" height="294px"><br><br>
					</center>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="card">
					<div class="card card-statistic-1">
						<div class="card-wrap">
						  <div class="card-header">
							<h3><center>Logo</center></h3>
						  </div>
						</div>
					</div>
					<div class="col-lg-12">
					<center>
						<img src="assets/img/logo.jpg" height="294px"><br><br>
					</center>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<div class="card card-statistic-1">
						<div class="card-wrap">
						  <div class="card-header">
							<h3>Lokasi Toko</h3>
						  </div>
						</div>
					</div>
					<div class="col-lg-12">
					<center>
						<a target="_blank" href="https://www.google.com/maps/place/AGEN+BRILINK+UD.MM/data=!4m7!3m6!1s0x3031779e87b7db3d:0x716bda701385e051!8m2!3d3.1292278!4d98.9566684!16s%2Fg%2F11hf57q0tq!19sChIJPdu3h553MTARUeCFE3Daa3E?authuser=0&hl=id&rclk=1"><img src="assets/img/lokasi_toko.jpg" width="99%"></a><br><br>
					</center>
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