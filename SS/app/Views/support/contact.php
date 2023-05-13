<?php
$session = session();
helper("custom1_helper");
echo info_div();
echo form_open('/getSupport');
if (isset($data)) {
  echo attentionDiv();
  echo $data;
  echo close_div();
}
?>
<table>
  <br>
  <tr>
    <td>Name</td>
    <td><input type="text" name="staff" value="<?php echo $session->get('staff'); ?>" placeholder="name" /></td>
  </tr>

  <tr>
    <td>Subject</td>
    <td><input type="text" name="subject" placeholder="subject" required /></td>
  </tr>
  <tr>
    <td>Hall</td>
    <td><input type="text" name="hall" placeholder="Hall name" required /></td>
  </tr>

  <tr>
    <td>Message</td>
    <td style="vertical-align: top;"><textarea name="message" rows="10" cols="50" required></textarea/></td>
	</tr>

	<tr>		
		<td colspan="2"><input type="submit" class="button" value="Send Message" /></td>
	</tr>
</table>
<?php
echo form_close();
echo close_div();
?>