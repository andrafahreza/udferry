<div class="card-body">
	<div class="table-responsive">
		<table class="table">
		  <tr>
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

		<table width="100%" align="center" border="0" cellpadding="9" cellspacing="0"><tr><td>
					<?php
					if(@$_SESSION["tgl_awal"]!="" and @$_SESSION["tgl_awal"]!=""){
						$tgl1=$_SESSION["tgl_awal"];
						$tgl2=$_SESSION["tgl_akhir"];
					}
					$min=0;
					$med=0;
					$max=0;
					$no=0;
					$query_data=mysqli_query($conn,"select * from pembelian_header where (tanggal BETWEEN '$tgl1' AND '$tgl2') group by tanggal order by tanggal asc");
					while ($data=mysqli_fetch_array($query_data)){
						$no++;
						$tgl[$no]=$data["tanggal"];
						$qty[$no]=0;
						$query_total=mysqli_query($conn,"select * from pembelian_detail join pembelian_header on pembelian_detail.nota_pembelian=pembelian_header.nota_pembelian where pembelian_header.tanggal='".$tgl[$no]."'");
						while($data_total=mysqli_fetch_array($query_total)){
							$qty[$no]=$qty[$no]+$data_total["qty"];
						}
						if($qty[$no]>=$max){
							$max=$qty[$no];
						}							
					}
					if($max==0){
						$med=0;
					}else{
						$med=$max/2;
					}
					$jlh_dt=$no;
					$mrg=3+$jlh_dt;
					
					
					if($no>0){
						$lebar=110;
						$lebar2=$lebar -5 ."px";
						?>
						<table width="99%" height="100" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 0px #6c6969; border-radius:0px 0px">
							<tr>
								<td width="40px" valign="top" >Jlh</td>
								<td width="3px" bgcolor="black"></td>
								<?php for ($a=1;$a<=$no; $a++){ ?>
									<td width="<?php echo $lebar; ?>px" align="center"><?php echo $qty[$a]; ?></td>
								<?php } ?>
								<td width="auto" bgcolor=""></td>
							</tr>
							<tr>
								<td valign="top" >%</td>
								<td bgcolor="black"></td>
								<?php for ($a=1;$a<=$no; $a++){
									if($max==0){
										$persen[$a]=0;
									}else{
										$persen[$a]=$qty[$a]/$max*100;
									}
									?>
									<td width="<?php echo $lebar; ?>px" align="center"><?php echo number_format($persen[$a],0)."%"; ?></td>
								<?php } ?>
								<td width="auto" bgcolor=""></td>
							</tr>
							<tr>
								<td colspan="<?php echo $mrg; ?>" height="1" bgcolor="green"></td>
							</tr>
							<tr>
								<td valign="top" ><?php echo $max; ?></td>
								<td rowspan="3" bgcolor="black"></td>
								<?php
								for ($a=1;$a<=$no; $a++){ ?>
									<td rowspan="3" width="80px" height="100" align="center" valign="bottom">									
									<?php if($a%2==0){ ?>
										<img src="assets/img/grafik_pembelian.jpg" width="80%" height="<?php echo number_format($persen[$a],0)."%"; ?>"/>
									<?php }else{?>
										<img src="assets/img/grafik.jpg" width="80%" height="<?php echo number_format($persen[$a],0)."%"; ?>"/>
									<?php }?>
									</td>
								<?php } ?>
								<td rowspan="3" width="auto" bgcolor=""></td>
							</tr>
							<tr>
								<td ><?php echo $max/2; ?></td>
							</tr>
							<tr>
								<td valign="bottom">0%</td>
							</tr>
							<tr>
								<td colspan="<?php echo $mrg; ?>" valign="bottom" height="3" bgcolor="black" align="center">
								</td>
							</tr>
							<tr>
								<td>Tgl</td>
								<td bgcolor="black"></td>
								<?php
								for ($a=1;$a<=$no; $a++){ ?>
									<td valign="bottom" height="1" bgcolor="" align="center">
										<?php echo date('d M Y', strtotime($tgl[$a])); ?>
									</td>
								<?php } ?>
								<td width="auto" bgcolor=""></td>
							</tr>
						</table>
					<?php 
					}else{
						echo "<font size='8' color='#F4DE64'><center>Belum ada data</center></font>";
					}
					?>				
				</td>
			</tr>
		</table>
	</div>
</div>
