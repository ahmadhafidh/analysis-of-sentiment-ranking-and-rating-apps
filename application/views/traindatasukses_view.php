<table width="100%" height="100%">
			<tr>
				<td align="center" valign="middle">
					<img src="<?php echo base_url('assets/admin/img/adminlogin.png');?>" width="200" height="200">
					<?php
							echo "<br>";
							echo "<font face='times new roman' color='red' size='5'><b> Selamat</b></font>";
							echo "<font face='times new roman' size='5'><b> Anda telah berhasil melakukan Upload Dataset</b></font><br>";
							
							header('refresh:3;'.base_url("admin/seleksi_teks").'');
						
					?>
				</td>
			</tr>
		</table>