<div class="card-body">
	<div class="table-responsive">
		<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>
					<?php
					$min=0;
					$med=0;
					$max=0;
					$no=0;
					$query_data=mysqli_query($conn,"select * from barang order by nama_barang asc");
					while ($data=mysqli_fetch_array($query_data)){
						$no++;
						$nama_barang[$no]=$data["nama_barang"];
						$qty[$no]=$data["stok"];
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
								for ($a=1;$a<=$no; $a++){
									?>
									<td rowspan="3" width="80px" height="100" align="center" valign="bottom">
									<?php if($a%2==0){ ?>
										<img src="assets/img/grafik_barang.jpg" width="80%" height="<?php echo number_format($persen[$a],0)."%"; ?>"/>
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
								<td>Barang</td>
								<td bgcolor="black"></td>
								<?php
								for ($a=1;$a<=$no; $a++){ ?>
									<td valign="bottom" height="1" bgcolor="" align="center">
										<?php echo ucwords($nama_barang[$a]); ?>
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
