  <script src="../assets/modules/sweetalert/sweet2.js"></script>
  <link rel="stylesheet" href="../assets/modules/sweetalert/sweet2.css">

  <?php
    include 'connect.php';

    $tipe = $_GET['type'];
    $id = $_GET['id'];

	if ($tipe == "pembelian") {
		$sql = mysqli_query($conn, "DELETE FROM pembelian_detail WHERE nota_pembelian='$id'");
		$sql = mysqli_query($conn, "DELETE FROM pembelian_header WHERE nota_pembelian='$id'");
	}elseif ($tipe == "penjualan") {
		$sql = mysqli_query($conn, "DELETE FROM penjualan_detail WHERE nota_penjualan='$id'");
		$sql = mysqli_query($conn, "DELETE FROM penjualan_header WHERE nota_penjualan='$id'");
	}else{
		$sql = mysqli_query($conn, "DELETE FROM $tipe WHERE id='$id'");		
	}
    ?>
  <script>
      setTimeout(function() {
          swal({
              title: "Sukses",
              text: "Hapus data berhasil!",
              type: "success"
          }, function() {
              <?php
                if ($tipe == "pembelian_detail") {
                    echo 'window.location.href="../pembelian.php";';
				}elseif ($tipe == "penjualan_detail") {
                    echo 'window.location.href="../penjualan.php";';
                }elseif ($tipe == "pembelian") {
                    echo 'window.location.href="../laporan_pembelian.php";';
				}elseif ($tipe == "penjualan") {
                    echo 'window.location.href="../laporan_penjualan.php";';
                } else {
                    echo 'window.location.href="../'.$tipe.'.php";';
                }
                ?>
          });
      }, 500);
  </script>