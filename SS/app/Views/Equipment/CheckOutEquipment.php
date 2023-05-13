<?php
helper("custom1_helper");
$info_div = info_div();
echo $info_div;
echo br(1);
echo "<h1 class='title'>Check Out Equipment";
echo br(2);
// anchor('/EquipmentLog', 'View log', '<button type="button" class="button" </button');
echo form_open('/EquipmentLog');
echo "<input type='submit'  class='button' value='View log'/>";
echo form_close();
echo "</h1>";
echo br(2);
echo form_open('/checkOutEquipment');
if (isset($data)) {
  $attentionDiv = attentionDiv();
  echo $attentionDiv;
  // $this->load->view('attentionDiv');
  echo $data;
  $close_div = close_div();
  echo $close_div;
}
$session = session();
?>

<table class="centered_table">
  <tr>
    <td style="vertical-align: middle;">
      <table>
        <tr>
          <td>Student ID</td>
          <td><input value="<?php echo $session->get('student_id'); ?>" type="text" name="studentId" placeholder="" onClick="this.select();" readonly autocomplete="off" /></td>
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
          <td>Hall</td>
          <td><input value="<?php echo $session->get('student_hall'); ?>" type="text" name="hall" placeholder="" readonly autocomplete="off" /></td>
        </tr>

        <tr>
          <td>Room</td>
          <td><input value="<?php echo $session->get('student_room'); ?>" type="text" name="room" placeholder="" readonly autocomplete="off" /></td>
        </tr>

        <tr>
          <td>Item Type</td>
          <td><input type="text" name="item_type" placeholder="" required autocomplete="off" /></td>
        </tr>

        <tr>
          <td>Quantity</td>
          <td><input type="number" name="quantity" required autocomplete="off" /></td>
        </tr>

        <tr>
          <td>Staff</td>
          <td><input value="<?php echo $session->get('staff'); ?>" type="text" name="staff" required autocomplete="off" /></td>
        </tr>


      </table>
    </td style="vertical-align: middle;">
    <td><?php
        //echo '<img class = "id_img" src="'.base_url('./uploads/'.$session->get('hall_name').'/'.$session->get('student_image').'.jpg').'"   alt="" >';
        if ($session->get('student_image') and $session->get('student_image') != "clean") {
          echo '<img class = "id_img" src="data:image/jpeg;base64,' . base64_encode($session->get('student_image')) . '"/>';
        } else {
          echo '<img class = "id_img" src="' . base_url('images/reslifelogo2.png') . '"   alt="" >';
        }

        ?>
    </td>
  </tr>

  <tr>
    <td colspan="2" style="text-align:center;"><input value="Sign-in Equipment" class="button" type="submit" /></td>
  </tr>
</table>

<?php
echo form_close();
$close_div = close_div();
echo $close_div;
?>