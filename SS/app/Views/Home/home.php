<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<div class="info_top">
	<div class="inner_info_top">
		<br>
		<?php
		$session = session();
		echo form_open('/cleardata');
		?>
		<table>
			<tr>
				<td><input type="submit" class="button" value="Clear Screen" /> </td>
			</tr>
		</table>
		<?php
		echo form_close();
		?>
		<br>
		<table width='100%' style="text-align:center;">
			<?php
			helper("custom1_helper");
			$open_div = open_div();
			$close_div = close_div();
			if (isset($hd_message)) {
				echo $open_div;
				echo $hd_message;

				echo $close_div;
				echo '<br>';
			}

			if (isset($data)) {
				echo $open_div;
				echo $data;
				echo $close_div;
			}
			// echo form_open('signIn_controller/signIn');
			echo form_open('signIn');
			?>
			<br>
			<tr>
				<td>
					<!-- echo view('studentInfo');  -->
					<table style='width: 450px;'>
						<h1>Student Information </h1>
						<tr>
							<td style="vertical-align: top;">
								<table>
									<tr>
										<td>ID #</td>
										<td>
											<?php echo form_input($studentID); ?>
										</td>
									</tr>

									<tr>
										<td>First</td>
										<td>
											<?php echo form_input($fname); ?>
										</td>
									</tr>

									<tr>
										<td>Last</td>
										<td>
											<?php echo form_input($lname); ?>
										</td>
									</tr>

									<tr>
										<td>E-mail</td>
										<td>
											<?php echo form_input($email); ?>
										</td>
									</tr>

									<tr>
										<td>Hall</td>
										<td>
											<?php echo form_input($hall); ?>
										</td>
									</tr>

									<tr>
										<td>Room</td>
										<td>
											<?php echo form_input($room); ?>
										</td>
									</tr>

								</table>
							</td style="vertical-align: middle;">
							<td>
								<?php
								if ($session->get('student_image') and $session->get('student_image') != "clean") {
									echo '<img class = "id_img" src="data:image/jpeg;base64,' . base64_encode($session->get('student_image')) . '"/>';
								} else {
									echo img([
										'src' => base_url("images/new_scsu_logo.png"),
										'style' => "width: 200px; height: 200px;",
										'alt' => 'SCSU Logo'
									]);
								}
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<h1>Guest Information</h1>
					<table style='width: 450px;'>
						<tr>
							<td style="vertical-align: top;">
								<table>
									<tr>
										<td>ID #</td>
										<td>
											<?php
											echo form_input($guest_id);
											?>
										</td>
									</tr>
									<tr>
										<td>First</td>
										<td>
											<?php
											echo form_input($guest_fname);
											?>
										</td>
									</tr>
									<tr>
										<td>Last</td>
										<td>
											<?php
											echo form_input($guest_lname);
											?>
										</td>
									</tr>

									<tr>
										<td>Hall</td>
										<td><?php echo  $session->get('guest_hall'); ?></td>
									</tr>
									<tr>
										<td>Room</td>
										<td><?php echo  $session->get('guest_room'); ?></td>
									</tr>
									<tr>
										<td>ID type</td>
										<td>
											<?php
											echo form_dropdown($guest_id_type[0], $guest_id_type[1]);
											?>
											<!-- //* trying out methods of validation -->
											<!-- <small class="text-success font-weight-bold"> 
												<?php /*if (form_error('date') == FALSE) {
													echo 'Input Ok <i class="fa fa-check-circle"></i>';
												} */ ?>
											</small> -->
										</td>
										<?php if (date("H:i:s", strtotime('now')) > "00:00:00") { ?>
									</tr>
									<!--************************ STATE ****************************-->
									<tr>
										<td colspan="2">
											<table id="state_box" style="display:none; background-color:#FFA500;">
												<tr>
													<td>State</td>
													<td>
														<?php
														echo form_dropdown($state[0], $state[1], $state[2]);
														?>
													</td>
												</tr>
											</table>
										</td>
									</tr>

									<tr>
										<td colspan="2">
											<table id="other_box" style="display:none; background-color:#FFA500;">
												<tr>
													<td>Other</td>
													<td>
														<?php
														echo form_input($other_type_of_id);
														?>
													</td>
												</tr>
											</table>
										</td>
									</tr>

									<tr>
										<td colspan="2">
											<table id="bday_box" style="display:none; background-color:#FFA500;">
												<tr>
													<td>Birthday</td>
													<td>
														<?php
														echo form_input($bday);
														?>
													</td>
												</tr>
											</table>
										</td>
									</tr>

									<tr>
										<td>Overnight</td>
										<td>
											<?php
											echo form_checkbox($overnight);
											?>
											<br>
										</td>
									</tr>
									<!--************************BEGINNING OF OPTIONAL OVERNIGHT FIELDS************************-->
									<tr>
										<td colspan="2">
											<table id="failed" style="display:none; background-color:#FFA500;">
												<tr>
													<td>
														ATTENTION: <br>
														Overnights should only be signed in between 7pm and 1:50am, you should check with your hall director first.
													</td>
												</tr>
											</table>

											<table id="overnight" style="display:none; background-color:#FFA500;">
												<tr>
													<td>License Plate</td>
													<td>
														<?php
														echo form_input($guest_license_plate);
														?>
													</td>
												</tr>

												<tr>
													<td>Car type</td>
													<td>
														<?php
														echo form_input($guest_type_of_car);
														?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<!--************************END OF OPTIONAL OVERNIGHT FIELDS************************-->
								<?php } ?>
								</table>
							</td style="vertical-align: middle;">
							<td>
								<?php
								if ($session->get('guest_image') and $session->get('guest_image') != "clean") {
									echo '<img class = "id_img" src="data:image/jpeg;base64,' . base64_encode($session->get('guest_image')) . '"/>';
								} else {
									echo img([
										'src' => base_url("images/new_scsu_logo.png"),
										'style' => "width: 200px; height: 200px;",
										'alt' => 'SCSU Logo',
									]);
								}
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<table width="100%">
			<tr>
				<td style="text-align:left;">
					<?php echo anchor('showStudentGuests', '<button type="button" class = "button_guest">Sign out Guest</button>'); ?>
				</td>
				<td style="text-align:right;"><input class="button_guest" type="submit" value="Sign-In Guest" /></td>
			</tr>
			<?php echo form_close(); ?>
		</table>
		<br> <br>
	</div>
</div>