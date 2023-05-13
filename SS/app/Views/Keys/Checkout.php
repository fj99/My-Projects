<?php
$session = session();
helper("custom1_helper");
echo info_div();
echo "<h1 class='title'>Check Out Key<br />";
echo form_open('/KeyLog');
echo "<input type='submit'  class='button' value='View log'/>";
echo form_close();
echo "</h1>";
echo form_open('/checkOutKey');
echo br(2);
if (isset($data)) {
  echo attentionDiv();
  echo $data;
  echo close_div();
}
?>
<table class="centered_table" style="background: #fff;">
  <tr>
    <td style="vertical-align: middle;">
      <table>
        <tr>
          <td>Student ID</td>
          <td><input value="<?php echo  $session->get('student_id'); ?>" type="text" name="studentId" placeholder="" onClick="this.select();" readonly autocomplete="off" /></td>
        </tr>

        <tr>
          <td>First name</td>
          <td><input value="<?php echo $session->get('student_first'); ?>" type="text" name="first_name" placeholder="" readonly autocomplete="off" /></td>
        </tr>

        <tr>
          <td>Last name</td>
          <td><input value="<?php echo $session->get('student_last'); ?>" type="text" name="last_name" placeholder="" readonly autocomplete="off" /></td>
        </tr>

        <tr>
          <td>E-mail</td>
          <td><input value="<?php echo $session->get('student_email'); ?>" type="text" name="email" placeholder="" readonly autocomplete="off" /></td>
        </tr>

        <tr>
          <td>Hall</td>
          <td><input value="<?php echo $session->get('student_hall'); ?>" type="text" name="hall" placeholder="" readonly autocomplete="off" /></td>
        </tr>

        <tr>
          <td>Room</td>
          <td><input value="<?php echo $session->get('student_room'); ?>" type="text" name="room" placeholder="" readonly autocomplete="off" /></td>
        </tr>

        <tr>
          <td>Key Number</td>
          <td><input type="text" name="key" placeholder="" required autocomplete="off" /></td>
        </tr>

        <tr>
          <td>Staff</td>
          <td><input value="<?php echo $session->get('staff'); ?>" type="text" name="staff" required autocomplete="off" /></td>
        </tr>
      </table>
    </td style="vertical-align: middle;">

    <td>
      <?php
      if ($session->get('student_image') and $session->get('student_image') != "clean") {
        echo '<img class = "id_img" src="data:image/jpeg;base64,' . base64_encode($session->get('student_image')) . '"/>';
      } else {
        echo '<img src="https://scsuowls.com/images/2020/1/24/logo_for_website.jpg?width=1416&height=797&mode=crop&quality=80&format=jpg" height="100px;" style="border-radius: 50%;">';
      }
      ?>
    </td>
  </tr>

  <tr>
    <td colspan="2" style="text-align:center;"><input value="Check Out Key" class="button" type="submit" /></td>
  </tr>
</table>

<?php
echo form_close();
echo close_div();
?>