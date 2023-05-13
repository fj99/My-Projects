<script type="text/javascript">
	function toggle_visibility(id) {
		var e = document.getElementById(id);
		if (e.style.display == 'block')
			e.style.display = 'none';
		else
			e.style.display = 'block';
	}
</script>
<?php
$session = session();
helper("custom1_helper");
$info_div = info_div();
echo $info_div;
echo br(1);
echo "<h1 class='title'> Use GUEST field<br /><br />";
// echo anchor('serviceLog', 'Sign Out Guest');
?>
<!-- <br> -->
<button> <?php echo anchor('serviceLog', 'Sign Out Guest'); ?></button>
<?php
echo form_open('ServiceIn');
echo "</h1>";
echo br(2);
if (isset($data)) {
	$this->load->view('attentionDiv');
	echo $data;
	$this->load->view('closeDiv');
}
?>
<table>
	<tr>
		<td style="vertical-align: middle;">
			<table>
				<tr>
					<td>ID</td>
					<td><input value="<?php echo  $session->get('guest_id'); ?>" type="text" name="guest_Id" placeholder="" onClick="this.select();" required /></td>
				</tr>
				<tr>
					<td>First</td>
					<td><input value="<?php echo  $session->get('guest_first'); ?>" type="text" name="guest_first_name" placeholder="" onClick="this.select();" required /></td>
				</tr>
				<tr>
					<td>Last</td>
					<td><input value="<?php echo  $session->get('guest_last'); ?>" type="text" name="guest_last_name" placeholder="" onClick="this.select();" required /></td>
				</tr>
				<tr>
					<td>ID type</td>
					<td><select name="guest_id_type" required>
							<option></option>
							<option selected>HootLoot</option>
							<option>State DMV</option>
							<option>Military ID</option>
							<option>Passport</option>
							<option>Other</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Service</td>
					<td>
						<select name="service" required>
							<option></option>
							<option value="carpentry">Carpentry</option>
							<option value="computer_lab">Computer Lab</option>
							<option value="custodial">Custodial</option>
							<option value="electrical">Electrical</option>
							<option value="energy">Energy</option>
							<option value="grounds">Grounds</option>
							<option value="hvac">HVAC</option>
							<option value="locksmith">Locksmith</option>
							<option value="market">Market</option>
							<option value="moving">Moving</option>
							<option value="other">Other</option>
							<option value="painting">Painting</option>
							<option value="plumbing">Plumbing</option>
							<option value="Reslife_Office">Reslife Office</option>
							<option value="vpas">VPAS</option>
							<option value="wellness_center">Wellness Center</option>
							<option value="womens_hall_of_fame">Womens Hall of Fame</option>
							<option value="thrifty_owl">Thrifty Owl</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>Work order</td>
					<td><input type="checkbox" value="1" name="guest_check" onclick="toggle_visibility('overnight');" /></td>
				</tr>
				<!--************************BEGINNING OF OPTIONAL OVERNIGHT FIELDS************************-->
				<tr>
					<td colspan="2">
						<table id="overnight" style="display:none; background-color:#FFA500;">
							<tr>
								<td>Work order</td>
								<td><input type="text" name="work_order" placeholder="Service only" /></td>
							</tr>

							<tr>
								<td>Room</td>
								<td><input type="text" name="room" placeholder="Service only" /></td>
							</tr>
							<tr>
								<td>Staff</td>
								<td><input type="text" value="<?php echo $session->get('staff'); ?>" name="staff" /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;"><input type="submit" class="button" value="Sign in service" /></td>
				</tr>
			</table>
		</td>
		<td>
			<?php
			if ($session->get('guest_image') and $session->get('guest_image') != "clean") {
				echo '<img class = "id_img" src="data:image/jpeg;base64,' . base64_encode($session->get('guest_image')) . '"/>';
			} else {
				echo '<img class = "id_img" src="' . base_url('images/reslifelogo2.png') . '"   alt="" >';
			}
			?>
		</td>
	</tr>

</table>

<?php
echo form_close();
$close_div = close_div();
echo $close_div;
?>