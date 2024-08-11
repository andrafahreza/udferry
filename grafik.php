<div class="card">
	<div class="card-header">
		<div class="card-header-action">
			<?php		
			if(!isset($_SESSION["statistik"])){
				$_SESSION["statistik"]="Penjualan";
			}
			if(!isset($_SESSION["status"])){
				$_SESSION["status"]="tahun";
				$_SESSION["tahun"]=date("Y");
			}
			if (@$_POST["statistik"]=="Pembelian"){
				$_SESSION["statistik"]="Pembelian";
			}
			elseif (@$_POST["statistik"]=="Penjualan"){
				$_SESSION["statistik"]="Penjualan";
			}
			elseif (@$_POST["statistik"]=="Stok Barang"){
				$_SESSION["statistik"]="Stok Barang";
			}
			?>
			<form method="post" style="display:block">
				<div class="btn-group">
					<input <?php if(@$_SESSION["statistik"]=="Pembelian"){echo 'class="btn btn-primary btn-action"'; }else{ echo 'class="btn btn-success btn-action"';} ?> type="submit" name="statistik" value="Pembelian"/>
					<input <?php if(@$_SESSION["statistik"]=="Penjualan"){echo 'class="btn btn-primary btn-action"'; }else{ echo 'class="btn btn-success btn-action"';} ?> type="submit" name="statistik" value="Penjualan"/>
					<input <?php if(@$_SESSION["statistik"]=="Stok Barang"){echo 'class="btn btn-primary btn-action"'; }else{ echo 'class="btn btn-success btn-action"';} ?> type="submit" name="statistik" value="Stok Barang"/>
				</div>
			</form>
		</div>
	</div>
	<?php 
	if($_SESSION["statistik"]=="Stok Barang"){
		include("grafik_stok_barang.php");
	}elseif($_SESSION["statistik"]=="Pembelian"){
		include("grafik_pembelian.php");
	}else{					
		include("grafik_penjualan.php");
	}
	?>
</div>