
<div class="section-body">
	<div class="row">
		<div class="col-12">
			<div class="card">		
				<div class="card-header">
					<div class="card-header-action">
								<form method="post" style="display:block">								
								<div class="form-group">
								<br>
										<?php if(@$_SESSION["tahun"]=="" or @!$_SESSION["tahun"]){
											$_SESSION["tahun"]=date("Y");
										} ?>
										<?php if(@$_POST["tahun"]){
											$_SESSION["tahun"]=$_POST["tahun"];
										} ?>
																				
										</select>
										<?php
										$tahun_now=date("Y");
										for ($thn=$tahun_now-9; $thn<=$tahun_now; $thn++){ ?>
										<input <?php if(@$_SESSION["tahun"]==$thn){echo 'class="btn btn-danger btn-action"'; }else{ echo 'class="btn btn-primary btn-action"';} ?> type="submit" name="tahun" id="button2" value="<?php echo $thn; ?>" class="tombol"/>
										<?php } ?>
								</div>
								</form>
					</div>
				</div>


				<!-- Statistik Pembelian Per Tahun-->
				<div class="card-header">						
					<h4><?php echo "Statistik Pembelian Barang Per Tahun ".@$_SESSION["tahun"]; ?></h4>
				</div>
				<div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-3">
                        <thead>
                          <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Produk</th>
                            <th colspan="13"><center><?php echo @$_SESSION["tahun"]; ?></center></th>
						  </tr>
						  <tr>
						   <?php for ($bln=1; $bln<=12; $bln++){ ?>
								<?php 
								if($bln<10){
								$periode=$_SESSION["tahun"]."-0".$bln;										
								}else{
								$periode=$_SESSION["tahun"]."-".$bln;										
								}?>
									
                            <td><b><?php echo $bln ?></b></td>
						   <?php } ?>
							<td><b><font color="red">Total</font><b></td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = mysqli_query($conn, "SELECT * FROM barang");
                          $i = 0;
                          while ($row = mysqli_fetch_array($sql)) {
                            $i++;
							$idbarang=$row["id"];
                          ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td>
								<?php echo $row["nama_barang"]."<br>"; ?>
								<?php echo "Jenis: ".$row["jenis"]; ?>
								<?php echo "<br>Ukuran: ".$row["ukuran"]; ?>
								<?php echo "<br>Ketebalan: ".$row["ketebalan"].""; ?>
							  </td>
							  <?php for ($bln=1; $bln<=12; $bln++){ ?>
                              <td>
								<?php 
									if($bln<10){
										$periode=$_SESSION["tahun"]."-0".$bln;										
									}else{
										$periode=$_SESSION["tahun"]."-".$bln;										
									}
									$query1=mysqli_query($conn,"select * from pembelian_detail join pembelian_header on pembelian_detail.nota_pembelian=pembelian_header.nota_pembelian where pembelian_detail.idbarang='$idbarang' and pembelian_header.tanggal like '%".$periode."%'");
									$jumlah=0;
									while($row1=mysqli_fetch_array($query1)){
										$jumlah=$jumlah+$row1["qty"];
									}
									echo $jumlah;
								?>
							  </td>
							  <?php } ?>
                              <td>
								<?php 
									$query1=mysqli_query($conn,"select * from pembelian_detail join pembelian_header on pembelian_detail.nota_pembelian=pembelian_header.nota_pembelian where pembelian_detail.idbarang='$idbarang' and pembelian_header.tanggal like '%".$_SESSION["tahun"]."%'");
									$jumlah=0;
									while($row1=mysqli_fetch_array($query1)){
										$jumlah=$jumlah+$row1["qty"];
									}
									echo $jumlah;
								?>
							  </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                </div>
	
				
				<!-- Statistik Penjualan Per Tahun-->
				<div class="card-header">						
					<h4><?php echo "Statistik Penjualan Barang Per Tahun ".@$_SESSION["tahun"]; ?></h4>
				</div>
				<div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-3">
                        <thead>
                          <tr>
                            <th rowspan="2">No</th>
							<th rowspan="2">Produk</th>
						    <th colspan="13"><center><?php echo @$_SESSION["tahun"]; ?></center></th>
						  </tr>
						  <tr>
						   <?php for ($bln=1; $bln<=12; $bln++){ ?>
								<?php 
								if($bln<10){
								$periode=$_SESSION["tahun"]."-0".$bln;										
								}else{
								$periode=$_SESSION["tahun"]."-".$bln;										
								}?>
									
                            <td><b><?php echo $bln ?></b></td>
						   <?php } ?>
							<td><b><font color="red">Total</font><b></td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = mysqli_query($conn, "SELECT * FROM barang");
                          $i = 0;
                          while ($row = mysqli_fetch_array($sql)) {
                            $i++;
							$idbarang=$row["id"];
                          ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td>
								<?php echo $row["nama_barang"]."<br>"; ?>
								<?php echo "Jenis: ".$row["jenis"]; ?>
								<?php echo "<br>Ukuran: ".$row["ukuran"]; ?>
								<?php echo "<br>Ketebalan: ".$row["ketebalan"].""; ?>
							  </td>
							   <?php for ($bln=1; $bln<=12; $bln++){ ?>
                              <td>
								<?php 
									if($bln<10){
										$periode=$_SESSION["tahun"]."-0".$bln;										
									}else{
										$periode=$_SESSION["tahun"]."-".$bln;										
									}
									$query1=mysqli_query($conn,"select * from penjualan_detail join penjualan_header on penjualan_detail.nota_penjualan=penjualan_header.nota_penjualan where penjualan_detail.idbarang='$idbarang' and penjualan_header.tanggal like '%".$periode."%'");
									$jumlah=0;
									while($row1=mysqli_fetch_array($query1)){
										$jumlah=$jumlah+$row1["qty"];
									}
									echo $jumlah;
								?>
							  </td>							  
							  <?php } ?>
                              <td>
								<?php 									
									$query1=mysqli_query($conn,"select * from penjualan_detail join penjualan_header on penjualan_detail.nota_penjualan=penjualan_header.nota_penjualan where penjualan_detail.idbarang='$idbarang' and penjualan_header.tanggal like '%".$_SESSION["tahun"]."%'");
									$jumlah=0;
									while($row1=mysqli_fetch_array($query1)){
										$jumlah=$jumlah+$row1["qty"];
									}
									echo $jumlah;
								?>
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

<div class="section-body">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<div class="card-header-action">
								<form method="post" style="display:block">
									<label><?php echo "Tanggal"; ?></label>
									<?php if(@$_SESSION["tgl_awal"]=="" or @!$_SESSION["tgl_awal"]){
										$_SESSION["tgl_awal"]=date("Y-m-d");
									} ?>
									<?php if(@$_POST["tgl_awal"]){
										$_SESSION["tgl_awal"]=$_POST["tgl_awal"];
									} ?>
									<input class="btn btn-primary btn-action mr-1" type="date" name="tgl_awal" value="<?php echo $_SESSION["tgl_awal"]; ?>" id="tgl_awal" class="" />
									<label><?php echo "S/D"; ?></label>
									<?php if(@$_SESSION["tgl_akhir"]=="" or @!$_SESSION["tgl_akhir"]){
										$_SESSION["tgl_akhir"]=date("Y-m-d");
									} ?>
									<?php if(@$_POST["tgl_akhir"]){
										$_SESSION["tgl_akhir"]=$_POST["tgl_akhir"];
									} ?>
									<input class="btn btn-primary btn-action mr-1" type="date" name="tgl_akhir" id="tgl_akhir" value="<?php echo $_SESSION["tgl_akhir"]; ?>"class=""/>
									<input class="btn btn-danger btn-action" type="submit" name="button" id="button2" value="Tampil" class="tombol"/>
								</form>
					</div>
				</div>

				<!--Transaksi Pembelian-->
				<div class="card-header">
						<?php
						$min=0;
						$max=0;
						if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
							$tgl1=$_SESSION["tgl_awal"];
							$tgl2=$_SESSION["tgl_akhir"];
						}
						$query1=mysqli_query($conn,"select * from pembelian_detail join pembelian_header on pembelian_detail.nota_pembelian=pembelian_header.nota_pembelian where (pembelian_header.tanggal BETWEEN '$tgl1' AND '$tgl2') group by tanggal order by pembelian_detail.nota_pembelian asc");
						while ($data=mysqli_fetch_array($query1)){
							$jlh=0;
							$query_total=mysqli_query($conn,"select * from pembelian_detail where idbarang='".$data["id"]."'");
							if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
								$tgl1=$_SESSION["tgl_awal"];
								$tgl2=$_SESSION["tgl_akhir"];
								$query_total=mysqli_query($conn,"select * from pembelian_detail join pembelian_header on pembelian_detail.nota_pembelian=pembelian_header.nota_pembelian where pembelian_header.tanggal='".$data["tanggal"]."' order by pembelian_detail.nota_pembelian asc");
							}
							while($data_total=mysqli_fetch_array($query_total)){
								$jlh=$jlh+$data_total["qty"];
							}
							if($jlh>=$max){
								$max=$jlh;
							}
						} 

						if($max==0){
							$med=0;
						}else{
							$med=$max/2;							
						}
						if($max==0){
							$med=0;
						}else{
							$med=$max/2;							
						}
						?>
						
					<table align="center" width="100%" border="0" cellpadding="4" cellspacing="" bgcolor="#d5ebef" style="border:solid 1px #3097aa">
						<tr>
							<td colspan="3" bgcolor="white" align="left"><h4>Statistik Transaksi Pembelian</h4></td>
						</tr>
						<tr>
							<td width="33,33333333333333%" align="left"><b><?php echo $min; ?></b></td>
							<td width="33,33333333333333%" align="center"><b><?php echo $med; ?></b></td>
							<td width="33,33333333333333%" align="right"><b><?php echo $max; ?></b></td>
						</tr>					
						<tr>
							<td colspan="3" bgcolor="black" align="left"></td>
						</tr>					
						<?php
						$no=0;
						if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
							$tgl1=$_SESSION["tgl_awal"];
							$tgl2=$_SESSION["tgl_akhir"];
						}
						$query1=mysqli_query($conn,"select * from pembelian_detail join pembelian_header on pembelian_detail.nota_pembelian=pembelian_header.nota_pembelian where (pembelian_header.tanggal BETWEEN '$tgl1' AND '$tgl2') group by tanggal order by pembelian_detail.nota_pembelian asc");
						while ($data=mysqli_fetch_array($query1)){
						$no++;
							$jlh=0;
							$query_dt=mysqli_query($conn,"select * from pembelian_detail where idbarang='".$data["id"]."'");
							if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
								$tgl1=$_SESSION["tgl_awal"];
								$tgl2=$_SESSION["tgl_akhir"];
								$query_dt=mysqli_query($conn,"select * from pembelian_detail join pembelian_header on pembelian_detail.nota_pembelian=pembelian_header.nota_pembelian where pembelian_header.tanggal='".$data["tanggal"]."' order by pembelian_detail.nota_pembelian asc");
							}
							while($dt=mysqli_fetch_array($query_dt)){
								$jlh=$jlh+$dt["qty"];
							}
							
							if($jlh==0){
								$lebar=0;
							}else{
								$lebar=($jlh/$max)*100;								
							}
						?>					
						<tr style="border:solid grey 1px;">
							<td colspan="3" bgcolor="white" align="left">
								<label style="position:absolute;">
								<?php echo "&nbsp;&nbsp;".$no.". &nbsp;&nbsp;".$data["tanggal"]; ?>
								<?php echo " .. Qty : ".$jlh ." (".number_format($lebar,0)."%) ::.."; ?>
								</label>
								<img src="assets/img/grafik_pembelian1.jpg" width="<?php echo $lebar; ?>%"height="25px" style="border:solid 0px black">
							</td>
						</tr>
						<?php } ?>
					</table><br>
				</div>
				
				<!--Pembelian Barang-->
				<div class="card-header">
						<?php
						$min=0;
						$max=0;
						$query1=mysqli_query($conn,"select * from barang order by nama_barang asc");
						while ($data=mysqli_fetch_array($query1)){
							$jlh=0;
							$query_total=mysqli_query($conn,"select * from pembelian_detail where idbarang='".$data["id"]."'");
							if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
								$tgl1=$_SESSION["tgl_awal"];
								$tgl2=$_SESSION["tgl_akhir"];
								$query_total=mysqli_query($conn,"select * from pembelian_detail join pembelian_header on pembelian_detail.nota_pembelian=pembelian_header.nota_pembelian where pembelian_detail.idbarang='".$data["id"]."' and (pembelian_header.tanggal BETWEEN '$tgl1' AND '$tgl2') order by pembelian_detail.nota_pembelian asc");
							}
							while($data_total=mysqli_fetch_array($query_total)){
								$jlh=$jlh+$data_total["qty"];
							}
							if($jlh>=$max){
								$max=$jlh;
							}
						} 
						
						if($max==0){
							$med=0;
						}else{
							$med=$max/2;							
						}
						?>
						
					<table align="center" width="100%" border="0" cellpadding="4" cellspacing="" bgcolor="#d5ebef" style="border:solid 1px #3097aa">
						<tr>
							<td colspan="3" bgcolor="white" align="left"><h4>Statistik Pembelian Barang</h4></td>
						</tr>
						<tr>
							<td width="33,33333333333333%" align="left"><b><?php echo $min; ?></b></td>
							<td width="33,33333333333333%" align="center"><b><?php echo $med; ?></b></td>
							<td width="33,33333333333333%" align="right"><b><?php echo $max; ?></b></td>
						</tr>					
						<tr>
							<td colspan="3" bgcolor="black" align="left"></td>
						</tr>					
						<?php
						$no=0;
						$query1=mysqli_query($conn,"select * from barang order by nama_barang asc");
						while ($data=mysqli_fetch_array($query1)){
						$no++;
							$jlh=0;
							$query_dt=mysqli_query($conn,"select * from pembelian_detail where idbarang='".$data["id"]."'");
							if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
								$tgl1=$_SESSION["tgl_awal"];
								$tgl2=$_SESSION["tgl_akhir"];
								$query_dt=mysqli_query($conn,"select * from pembelian_detail join pembelian_header on pembelian_detail.nota_pembelian=pembelian_header.nota_pembelian where pembelian_detail.idbarang='".$data["id"]."' and (pembelian_header.tanggal BETWEEN '$tgl1' AND '$tgl2') order by pembelian_detail.nota_pembelian asc");
							}
							while($dt=mysqli_fetch_array($query_dt)){
								$jlh=$jlh+$dt["qty"];
							}
							if($jlh==0){
								$lebar=0;
							}else{
								$lebar=($jlh/$max)*100;								
							}
						?>					
						<tr style="border:solid grey 1px;">
							<td colspan="3" bgcolor="white" align="left">
								<label style="position:absolute;">
								<?php echo "&nbsp;&nbsp;".$no.". &nbsp;&nbsp;".$data["nama_barang"]; ?>
								<?php echo "&nbsp;&nbsp;[Jenis:".$data["jenis"]; ?>
								<?php echo "&nbsp;&nbsp;Ukuran:".$data["ukuran"]; ?>
								<?php echo "&nbsp;&nbsp;Ketebalan:".$data["ketebalan"]."]"; ?>
								<?php echo "&nbsp;&nbsp;Qty : ".$jlh ." (".number_format($lebar,0)."%) ::.."; ?>
								</label>
								<img src="assets/img/grafik_pembelian2.jpg" width="<?php echo $lebar; ?>%"height="25px" style="border:solid 0px black">
							</td>
						</tr>
						<?php } ?>
					</table><br>
				</div>

				<!--Transaksi Penjualan-->
				<div class="card-header">
						<?php
						$min=0;
						$max=0;
						if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
							$tgl1=$_SESSION["tgl_awal"];
							$tgl2=$_SESSION["tgl_akhir"];
						}
						$query1=mysqli_query($conn,"select * from penjualan_detail join penjualan_header on penjualan_detail.nota_penjualan=penjualan_header.nota_penjualan where (penjualan_header.tanggal BETWEEN '$tgl1' AND '$tgl2') group by tanggal order by penjualan_detail.nota_penjualan asc");
						while ($data=mysqli_fetch_array($query1)){
							$jlh=0;
							$query_total=mysqli_query($conn,"select * from penjualan_detail where idbarang='".$data["id"]."'");
							if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
								$tgl1=$_SESSION["tgl_awal"];
								$tgl2=$_SESSION["tgl_akhir"];
								$query_total=mysqli_query($conn,"select * from penjualan_detail join penjualan_header on penjualan_detail.nota_penjualan=penjualan_header.nota_penjualan where penjualan_header.tanggal='".$data["tanggal"]."' order by penjualan_detail.nota_penjualan asc");
							}
							while($data_total=mysqli_fetch_array($query_total)){
								$jlh=$jlh+$data_total["qty"];
							}
							if($jlh>=$max){
								$max=$jlh;
							}
						} 

						if($max==0){
							$med=0;
						}else{
							$med=$max/2;							
						}
						if($max==0){
							$med=0;
						}else{
							$med=$max/2;							
						}
						?>
						
					<table align="center" width="100%" border="0" cellpadding="4" cellspacing="" bgcolor="#d5ebef" style="border:solid 1px #3097aa">
						<tr>
							<td colspan="3" bgcolor="white" align="left"><h4>Statistik Transaksi Penjualan</h4></td>
						</tr>
						<tr>
							<td width="33,33333333333333%" align="left"><b><?php echo $min; ?></b></td>
							<td width="33,33333333333333%" align="center"><b><?php echo $med; ?></b></td>
							<td width="33,33333333333333%" align="right"><b><?php echo $max; ?></b></td>
						</tr>					
						<tr>
							<td colspan="3" bgcolor="black" align="left"></td>
						</tr>					
						<?php
						$no=0;
						if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
							$tgl1=$_SESSION["tgl_awal"];
							$tgl2=$_SESSION["tgl_akhir"];
						}
						$query1=mysqli_query($conn,"select * from penjualan_detail join penjualan_header on penjualan_detail.nota_penjualan=penjualan_header.nota_penjualan where (penjualan_header.tanggal BETWEEN '$tgl1' AND '$tgl2') group by tanggal order by penjualan_detail.nota_penjualan asc");
						while ($data=mysqli_fetch_array($query1)){
						$no++;
							$jlh=0;
							$query_dt=mysqli_query($conn,"select * from penjualan_detail where idbarang='".$data["id"]."'");
							if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
								$tgl1=$_SESSION["tgl_awal"];
								$tgl2=$_SESSION["tgl_akhir"];
								$query_dt=mysqli_query($conn,"select * from penjualan_detail join penjualan_header on penjualan_detail.nota_penjualan=penjualan_header.nota_penjualan where penjualan_header.tanggal='".$data["tanggal"]."' order by penjualan_detail.nota_penjualan asc");
							}
							while($dt=mysqli_fetch_array($query_dt)){
								$jlh=$jlh+$dt["qty"];
							}
							
							if($jlh==0){
								$lebar=0;
							}else{
								$lebar=($jlh/$max)*100;								
							}
						?>					
						<tr style="border:solid grey 1px;">
							<td colspan="3" bgcolor="white" align="left">
								<label style="position:absolute;">
								<?php echo "&nbsp;&nbsp;".$no.". &nbsp;&nbsp;".$data["tanggal"]; ?>
								<?php echo " .. Qty : ".$jlh ." (".number_format($lebar,0)."%) ::.."; ?>
								</label>
								<img src="assets/img/grafik_penjualan1.jpg" width="<?php echo $lebar; ?>%"height="25px" style="border:solid 0px black">
							</td>
						</tr>
						<?php } ?>
					</table><br>
				</div>				

				<!--Penjualan Barang-->
				<div class="card-header">
						<?php
						$min=0;
						$max=0;
						$query1=mysqli_query($conn,"select * from barang order by nama_barang asc");
						while ($data=mysqli_fetch_array($query1)){
							$jlh=0;
							$query_total=mysqli_query($conn,"select * from penjualan_detail where idbarang='".$data["id"]."'");
							if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
								$tgl1=$_SESSION["tgl_awal"];
								$tgl2=$_SESSION["tgl_akhir"];
								$query_total=mysqli_query($conn,"select * from penjualan_detail join penjualan_header on penjualan_detail.nota_penjualan=penjualan_header.nota_penjualan where penjualan_detail.idbarang='".$data["id"]."' and (penjualan_header.tanggal BETWEEN '$tgl1' AND '$tgl2') order by penjualan_detail.nota_penjualan asc");
							}
							while($data_total=mysqli_fetch_array($query_total)){
								$jlh=$jlh+$data_total["qty"];
							}
							if($jlh>=$max){
								$max=$jlh;
							}
						} 

						if($max==0){
							$med=0;
						}else{
							$med=$max/2;							
						}
						?>
						
					<table align="center" width="100%" border="0" cellpadding="4" cellspacing="" bgcolor="#d5ebef" style="border:solid 1px #3097aa">
						<tr>
							<td colspan="3" bgcolor="white" align="left"><h4>Statistik Barang Terlaris</h4></td>
						</tr>
						<tr>
							<td width="33,33333333333333%" align="left"><b><?php echo $min; ?></b></td>
							<td width="33,33333333333333%" align="center"><b><?php echo $med; ?></b></td>
							<td width="33,33333333333333%" align="right"><b><?php echo $max; ?></b></td>
						</tr>					
						<tr>
							<td colspan="3" bgcolor="black" align="left"></td>
						</tr>					
						<?php
						$no=0;
						$query1=mysqli_query($conn,"select * from barang order by nama_barang asc");
						while ($data=mysqli_fetch_array($query1)){
						$no++;
							$jlh=0;
							$query_dt=mysqli_query($conn,"select * from penjualan_detail where idbarang='".$data["id"]."'");
							if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
								$tgl1=$_SESSION["tgl_awal"];
								$tgl2=$_SESSION["tgl_akhir"];
								$query_dt=mysqli_query($conn,"select * from penjualan_detail join penjualan_header on penjualan_detail.nota_penjualan=penjualan_header.nota_penjualan where penjualan_detail.idbarang='".$data["id"]."' and (penjualan_header.tanggal BETWEEN '$tgl1' AND '$tgl2') order by penjualan_detail.nota_penjualan asc");
							}
							while($dt=mysqli_fetch_array($query_dt)){
								$jlh=$jlh+$dt["qty"];
							}
							
							if($jlh==0){
								$lebar=0;
							}else{
								$lebar=($jlh/$max)*100;								
							}
						?>					
						<tr style="border:solid grey 1px;">
							<td colspan="3" bgcolor="white" align="left">
								<label style="position:absolute;">
								<?php echo "&nbsp;&nbsp;".$no.". &nbsp;&nbsp;".$data["nama_barang"]; ?>
								<?php echo "&nbsp;&nbsp;[Jenis:".$data["jenis"]; ?>
								<?php echo "&nbsp;&nbsp;Ukuran:".$data["ukuran"]; ?>
								<?php echo "&nbsp;&nbsp;Ketebalan:".$data["ketebalan"]."]"; ?>
								<?php echo "&nbsp;&nbsp;Qty : ".$jlh ." (".number_format($lebar,0)."%) ::.."; ?>
								</label>
								<img src="assets/img/grafik_penjualan2.jpg" width="<?php echo $lebar; ?>%"height="25px" style="border:solid 0px black">
							</td>
						</tr>
						<?php } ?>
					</table><br>
				</div>

				<!--Stok Barang-->
				<div class="card-header">
						<?php
						$min=0;
						$max=0;
						$query1=mysqli_query($conn,"select * from barang order by stok desc");
						$brs=mysqli_num_rows($query1);
						if($brs>0){
							$data=mysqli_fetch_array($query1);
							$max=$data["stok"];
						}
						if($max==0){
							$med=0;
						}else{
							$med=$max/2;
						}
						?>

					<table align="center" width="100%" border="0" cellpadding="4" cellspacing="" bgcolor="#d5ebef" style="border:solid 1px #3097aa">
						<tr>
							<td colspan="3" bgcolor="white" align="left"><h4>Statistik Stok/Persediaan Barang</h4></td>
						</tr>
						<tr>
							<td width="33,33333333333333%" align="left"><b><?php echo $min; ?></b></td>
							<td width="33,33333333333333%" align="center"><b><?php echo $med; ?></b></td>
							<td width="33,33333333333333%" align="right"><b><?php echo $max; ?></b></td>
						</tr>					
						<tr>
							<td colspan="3" bgcolor="black" align="left"></td>
						</tr>					
						<?php
						$no=0;
						$query1=mysqli_query($conn,"select * from barang order by nama_barang asc");
						$jlh=0;
						while ($data=mysqli_fetch_array($query1)){
							$no++;
							$jlh=$data["stok"];
							if($jlh==0){
								$lebar=0;
							}else{
								$lebar=($jlh/$max)*100;								
							}
						?>					
						<tr style="border:solid grey 1px;">
							<td colspan="3" bgcolor="white" align="left">
								<label style="position:absolute;">
								<?php echo "&nbsp;&nbsp;".$no.". &nbsp;&nbsp;".$data["nama_barang"]; ?>
								<?php echo "&nbsp;&nbsp;[Jenis:".$data["jenis"]; ?>
								<?php echo "&nbsp;&nbsp;Ukuran:".$data["ukuran"]; ?>
								<?php echo "&nbsp;&nbsp;Ketebalan:".$data["ketebalan"]."]"; ?>
								<?php echo "&nbsp;&nbsp;Stok : ".$jlh ." (".number_format($lebar,0)."%) ::.."; ?>
								</label>
								<img src="assets/img/grafik_barang.jpg" width="<?php echo $lebar; ?>%"height="25px" style="border:solid 0px black">
							</td>
						</tr>
						<?php } ?>
					</table><br>
				</div>
	
			</div>
		</div>
	</div>
</div>