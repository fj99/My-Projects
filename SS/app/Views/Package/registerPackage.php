<?php
$session = session();
helper("custom1_helper");
$open_div = info_div();
echo $open_div;
echo "<h1 class='title'>Register a package</h1>";
echo form_open("registerPackage");
echo br(2);
if ($query->prefName) {
  $fname = $query->prefName;
} else {
  $fname = $query->FIRST_NAME;
}

if (!$query->BUILDING) {
  $hall = '';
} else {
  $halls = $query->BUILDING;
  if (substr($halls, 0, 3) === "NCT") {
    $hall = 'NCT';
  } else {
    if (substr($halls, 0, 2) === "NC") {
      $hall = 'NCM';
    }
  }
}
?>
<div style="float:left;">
  <table class="centered_table" style='min-width: 300px; '>
    <tr>
      <td></td>
      <td><input value="<?php echo $hall ?>" type="hidden" name="hallname" required /></td>
    <tr>
      <td>First name</td>
      <td><input value="<?php echo $fname ?>" type="text" name="hostfirstname" placeholder="" required readonly /></td>
    <tr>
      <td>Last name</td>
      <td><input value="<?php echo $query->LAST_NAME ?>" type="text" name="hostlastname" placeholder="" required readonly /></td>
    <tr>
      <td>Room</td>
      <td> <input value="<?php echo $query->ROOM_NUM ?>" type="text" name="hostroom" placeholder="" required readonly /></td>
    <tr>
      <td>Tracking #</td>
      <td><input value="" type="text" name="tracking_num" placeholder="" required /></td>
    <tr>
      <td>Carrier</td>
      <td><input value="" type="text" name="carrier" placeholder="" required /></td>
    <tr>
      <td>Staff</td>
      <td>
        <input type="text" value="<?php echo $session->get('staff'); ?>" name="staff_id" placeholder="" readonly />
      </td>
    <tr>
      <td>Email</td>
      <td><input type="hidden" name="email" value="<?php echo $query->EMAIL_ADDR; ?>" />
        <span style='font-weight:normal;'><?php echo $query->EMAIL_ADDR; ?></span>
      </td>
    <tr>
      <td colspan="2"><input type="submit" class="button" value="Register Package" /></td>
  </table>
</div>

<aside>
  <?php echo '<img src=data:image/jpeg;base64,' . base64_encode($query->IMAGE) . ' size="250" height="250" alt="" />'; ?>
</aside>
<?php
echo form_close();
$close_div = close_div();
echo $close_div;
?>