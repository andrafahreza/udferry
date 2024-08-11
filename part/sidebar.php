<?php
$judul = "UD. FERY";
$alamat = "Desa Sambosar Raya, Kecamatan Raya Kahean, Kabupaten Simalungun";
$pecahjudul = explode(" ", $judul);
$acronym = "";

foreach ($pecahjudul as $w) {
  $acronym .= $w[0];
}

$notif_barang = "";
$sql = mysqli_query($conn, "SELECT * FROM barang");
$jlh=0;
while ($row = mysqli_fetch_array($sql)){
	if($row["stok"]<=10){
		$jlh++;
	}
}
if($jlh>0){
	$notif_barang=$jlh;
}else{
	$notif_barang="";
}


?>
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
		  <a href="index.php"><br>
		  <img src="assets/img/logo.jpg" alt="logo" width="110" class="shadow-dark rounded"><br><br>
		  <?php echo "<font color='black'>".$judul."</font>"; ?></a><br>
		  <?php echo "<font color='black'>".$alamat."</font>"; ?></a>
		  <hr style="border:solid #fff 1px">
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
	  <a href="index.php"><br>
	  <img src="assets/img/logo.jpg" alt="logo" width="30" class="" style=""><br>
	  <hr style="border:solid #fff 1px">
	  </a>
    </div>
    <ul class="sidebar-menu">
		<li <?php echo ($page == "Dashboard") ? "class=active" : ""; ?>><a class="nav-link" href="index.php"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
		<?php if (@$_SESSION['jabatan_user']!=""){?>
		<li class="menu-header">Menu</li>
		<?php } ?>
		<li <?php echo ($page == "Profil" || @$page1 == "det") ? "class=active" : ""; ?>><a class="nav-link" href="profil.php"><i class="fab fa-creative-commons-by"></i> <span>Profil</span></a></li>
		<?php if (@$_SESSION['jabatan_user']==2 or @$_SESSION['jabatan_user']==1){?>
			<li <?php echo ($page == "Data Pegawai") ? "class=active" : ""; ?>><a href="pegawai.php" class="nav-link"><i class="fas fa-user"></i> <span>Data Pegawai</span></a></li>
		<?php } ?>
		<?php if (@$_SESSION['jabatan_user']==3 or @$_SESSION['jabatan_user']==1){?>
			<li <?php echo ($page == "Data Supplier" || @$page1 == "det") ? "class=active" : ""; ?>><a class="nav-link" href="supplier.php"><i class="fab fa-creative-commons-by"></i> <span>Data Supplier</span></a></li>
		<?php } ?>
		<?php if (@$_SESSION['jabatan_user']==3 or @$_SESSION['jabatan_user']==2 or @$_SESSION['jabatan_user']==1){?>
			<li <?php echo ($page == "Data Barang") ? "class=active" : ""; ?>><a class="nav-link" href="barang.php"><i class="fas fa-cube"></i> <span>Barang</span><div style="background:#a5f2ed;border-radius:20px 20px;width:40px;"><Center><?php echo $notif_barang; ?></center></div></a></li>
		<?php } ?>
		<?php if (@$_SESSION['jabatan_user']==3 or @$_SESSION['jabatan_user']==2){?>
			<li <?php echo ($page == "Transaksi") ? "class=active" : ""; ?>><a class="nav-link" href="#"><span><b>TRANSAKSI</b></span></a></li>
		<?php } ?>
		<?php if (@$_SESSION['jabatan_user']==3){?>
			<li <?php echo ($page == "Pembelian") ? "class=active" : ""; ?>><a class="nav-link" href="data_pembelian.php"><i class="fas fa-cart-arrow-down"></i> <span>Pembelian</span></a></li>
			<li <?php echo ($page == "Retur Pembelian") ? "class=active" : ""; ?>><a class="nav-link" href="data_retur_pembelian.php"><i class="fas fa-arrow-left"></i> <span>Retur Pembelian</span></a></li>
		<?php } ?>
		<?php if (@$_SESSION['jabatan_user']==2){?>
			<li <?php echo ($page == "Penjualan") ? "class=active" : ""; ?>><a class="nav-link" href="data_penjualan.php"><i class="fas fa-cart-plus"></i> <span>Penjualan</span></a></li>
		<?php } ?>
		<?php if (@$_SESSION['jabatan_user']==1 or @$_SESSION['jabatan_user']==2 or @$_SESSION['jabatan_user']==3){?>
			<li <?php echo ($page == "Laporan") ? "class=active" : ""; ?>><a class="nav-link" href="#"><span><b>LAPORAN</b></span></a></li>
			<li <?php echo ($page == "Laporan Supplier") ? "class=active" : ""; ?>><a class="nav-link" href="laporan_supplier.php"><i class="fab fa-creative-commons-by"></i> <span>Supplier</span></a></li>
			<li <?php echo ($page == "Laporan Barang") ? "class=active" : ""; ?>><a class="nav-link" href="laporan_barang.php"><i class="fas fa-cube"></i> <span>Barang</span></a></li>
			<li <?php echo ($page == "Laporan Pembelian") ? "class=active" : ""; ?>><a class="nav-link" href="laporan_pembelian.php"><i class="fas fa-cart-arrow-down"></i> <span>Pembelian</span></a></li>
			<li <?php echo ($page == "Laporan Penjualan") ? "class=active" : ""; ?>><a class="nav-link" href="laporan_penjualan.php"><i class="fas fa-cart-plus"></i> <span>Penjualan</span></a></li>			
		<?php } ?>
	</ul>
  </aside>
</div>