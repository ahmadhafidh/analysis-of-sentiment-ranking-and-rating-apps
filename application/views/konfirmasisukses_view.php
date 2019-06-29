<table width="100%" height="100%">
			<tr>
				<td align="center" valign="middle">
					<img src="<?php echo base_url('assets/admin/img/adminlogout.jpg');?>" width="200" height="200">
					<?php
							echo "<br>";
							echo "<font face='times new roman' size='5'><b> Anda telah berhasil melakukan Konfirmasi pembayaran </b></font><br>";
							echo "<font face='times new roman' color='red' size='5'><b> Silakan tunggu admin kami akan melakukan verifikasi terlebih dahulu maksimal 1x24  </b></font>";
							header('refresh:6;'.base_url("Home").'');
						
					?>
				</td>
			</tr>
		</table>