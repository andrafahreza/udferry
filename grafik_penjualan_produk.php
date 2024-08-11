<div class="card-body">
	<div class="table-responsive">
		<center>
			<div style="border:solid 0px red;width:1050px;padding:3px;" class="tabel">
					<table width="99%" border="0" align="center" cellpadding="6" cellspacing="0" class="tabel" >
					  <tr class="tr" >
						<td align="left">
						<form method="post" style="display:block">
							<div class="form-group row">
							<div class="input-group col-sm-6">
							<label class="col-sm-0 col-form-label"> Periode </label>
							<?php if(@$_SESSION["tgl_awal"]=="" or @!$_SESSION["tgl_awal"]){
								$_SESSION["tgl_awal"]=date("Y-m-d");
							} ?>
							<?php if(@$_POST["tgl_awal"]){
								$_SESSION["tgl_awal"]=$_POST["tgl_awal"];
							} ?>
							<input type="date"  class="form-control"name="tgl_awal" value="<?php echo $_SESSION["tgl_awal"]; ?>" id="tgl_awal" class=""  onchange="submit()"/>
							<label class="col-sm-0 col-form-label"> S/D </label>
							<?php if(@$_SESSION["tgl_akhir"]=="" or @!$_SESSION["tgl_akhir"]){
								$_SESSION["tgl_akhir"]=date("Y-m-d");
							} ?>
							<?php if(@$_POST["tgl_akhir"]){
								$_SESSION["tgl_akhir"]=$_POST["tgl_akhir"];
							} ?>
							<input type="date"  class="form-control" name="tgl_akhir" id="tgl_akhir" value="<?php echo $_SESSION["tgl_akhir"]; ?>"class="" onchange="submit()"/>
							<input type="submit" class="btn btn-warning" name="button" id="button2" value="Tampil" class="tombol"/>
							</div>
							</div>
						</form>
						</td>
					  </tr>
					</table>

					<table width="90%" align="center" border="0" cellpadding="9" cellspacing="0"><tr><td>
						<?php
						$max=0;
						$jlh_dt=0;
						$query1=mysqli_query($conn,"select * from barang order by id");
						while ($data=mysqli_fetch_array($query1)){
							$jlh_dt++;
							$stus[$jlh_dt]=0;
							$jlh=0;
							$query_total=mysqli_query($conn,"select * from penjualan_detail where id='".$data["id"]."'");
							if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
								$tgl1=$_SESSION["tgl_awal"];
								$tgl2=$_SESSION["tgl_akhir"];
								$query_total=mysqli_query($conn,"select * from penjualan_detail join penjualan_header on penjualan_detail.nota_penjualan=penjualan_header.nota_penjualan where penjualan_detail.id='".$data["id"]."' and (penjualan_header.tanggal BETWEEN '$tgl1' AND '$tgl2') order by penjualan_detail.nota_penjualan");
							}
							while($data_total=mysqli_fetch_array($query_total)){
								$jlh=$jlh+$data_total["qty"];
							}
							if($jlh>=$max){
								$max=$jlh;
							}					
						}
						$mrg=3+$jlh_dt;
						
						$query=mysqli_query($conn,"select * from barang order by id");
						if (mysqli_num_rows($query)>0){
						$lebar=80;
						$lebar2=$lebar -5 ."px";
						?>
						<table width="99%" height="100" border="0" align="center" cellpadding="2" cellspacing="0" style="border: solid 0px #6c6969; border-radius:0px 0px">
							<tr>
								<td valign="bottom" colspan="<?php echo $mrg; ?>" height="10" align="center">
									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 0px #6c6969">
									  <tr>
										<td valign="bottom" height="1" bgcolor="black" align="center">
									  </tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="10" valign="top" ><?php echo $max; ?></td>
								<td rowspan="3" width="10px" bgcolor="black">
									<?php
									$query1=mysqli_query($conn,"select * from barang order by id");
									$no=0;
									while ($data=mysqli_fetch_array($query1)){
									$no++;?>
									<td rowspan="3" width="100%" height="100">
										<?php 
										$query_stus=mysqli_query($conn,"select * from penjualan_detail where id='".$data["id"]."'");
										if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
											$tgl1=$_SESSION["tgl_awal"];
											$tgl2=$_SESSION["tgl_akhir"];
											$query_stus=mysqli_query($conn,"select * from penjualan_detail join penjualan_header on penjualan_detail.nota_penjualan=penjualan_header.nota_penjualan where penjualan_detail.id='".$data["id"]."' and (penjualan_header.tanggal BETWEEN '$tgl1' AND '$tgl2') order by penjualan_detail.nota_penjualan");
										}
										if(mysqli_num_rows($query_stus)>0){
											while($data_stus=mysqli_fetch_array($query_stus)){
												$stus[$no]=$stus[$no]+$data_stus["qty"];
											}
										}
										if($max==0){
											$persen[$no]=0;
										}else{
											$persen[$no]=$stus[$no]/$max*100;
										}
										?>
										<table width="<?php echo $lebar; ?>" height="100" border="0" align="left" cellpadding="0" cellspacing="0" style="border: solid 0px green;">
										<tr>
											<td valign="bottom" height="100" align="center">
												<div style="border:solid 0px red;width:<?php echo $lebar2; ?>;color:white;" align="center"><?php if($persen>=10){ echo number_format($persen[$no],0)."%";} ?></div>
												<img src="assets/img/grafik_penjualan.jpg" width="80%" height="<?php echo number_format($persen[$no],0)."%"; ?>"/>
											</td>
										</tr>
										</table>
									</td>
									<?php } ?>
							</tr>
							<tr>
								<td ><?php echo $max/2; ?></td>
							</tr>
							<tr>
								<td valign="bottom">0%</td>
							</tr>
							<tr>
								<td></td>
								<td colspan="<?php echo $mrg; ?>" valign="bottom" height="1" bgcolor="black" align="center">
								</td>
							</tr>
							<tr>
								<td>No:<br>Jlh<br>%</td>
								<td></td>
									<?php
									$query2=mysqli_query($conn,"select * from barang order by id");
									$no=0;
									while ($data2=mysqli_fetch_array($query2)){ 
									$no++;?>
									<td valign="bottom" height="1" bgcolor="white" align="center">
										<?php 
										$id=substr($data2["id"],0,5)."";
										$nama_barang=$data2["nama_barang"];
										$query_dt=mysqli_query($conn,"select * from penjualan_detail where id='".$data2["id"]."' order by nota_penjualan desc");
										if(mysqli_num_rows($query_dt)>0){
											$data_pkj=mysqli_fetch_array($query_dt);
											//$id=$data_pkj["id"];
										}
										?>
										<a href="" title="<?php echo $nama_barang; ?>">
										<table width="<?php echo $lebar; ?>" border="0" align="left" cellpadding="0" cellspacing="0" style="border: solid 1px orange; border-radius:0px 0px">
										<tr>
										<td valign="bottom" align="center">
											<?php echo $id; ?>
										</td>
										</tr>
										<tr>
										<td valign="bottom" align="center">
											<?php echo $stus[$no]; ?>
										</td>
										</tr>
										<tr>
										<td valign="bottom" align="center">
											<?php echo number_format($persen[$no],0)."%"; ?>
										</td>
										</tr>
										</table>
										</a>
									</td>
									<?php } ?>
							</tr>
						</table>
							<?php 
							}else{
								echo "<font size='8' color='#F4DE64'><center>Belum ada proyek</center></font>";
							}
						?>				
					</td></tr></table><br>
			</div>
		</center>
		</div>
</div>
