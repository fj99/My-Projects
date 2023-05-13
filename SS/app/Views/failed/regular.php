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
helper("custom1_helper");
echo info_div();
if (isset($rows) and $rows == 0) {
  echo attentionDiv();
  echo " " . img('images/success.png') . "<br />
  The regular failed sign out list is empty ";
  echo close_div();
}
if (isset($data)) {
  echo attentionDiv();
  echo $data;
  echo close_div();
}
?>
<h1 class="title">Regular Failed Sign Outs</h1><br />
<br />
<table cellpadding="6" class="alternate-table" id="mytable">
  <thead>
    <tr>
      <th>Failed Date</th>
      <th>Hall Name</th>
      <th>Guest ID</th>
      <th>Guest First Name</th>
      <th>Guest Last Name</th>
      <th>Student ID</th>
      <th>Student First Name</th>
      <th>Student Last Name</th>
      <th>Room Number</th>
      <th>Sign In Time</th>
    </tr>
  </thead>
  <tbody>
    <?php
    // echo $query['rows'];
    if (isset($query) and $query['rows'] > 0) {
      foreach ($query['query'] as $row) : ?>
        <tr>
          <td><?php echo date('m-d-Y', strtotime($row->failed_date)); ?></td>
          <td><?php echo $row->hall_name; ?></td>
          <td><?php echo $row->guest_id; ?></td>
          <td><?php echo $row->guest_first_name; ?></td>
          <td><?php echo $row->guest_last_name; ?></td>
          <td><?php echo $row->student_id; ?></td>
          <td><?php echo $row->host_first_name; ?></td>
          <td><?php echo $row->host_last_name; ?></td>
          <td><?php echo $row->room_number; ?></td>
          <td><?php echo date('m-d-Y g:i:s a', strtotime($row->sign_in_time)); ?></td>
        </tr>
    <?php
      endforeach;
    }
    ?>
  </tbody>
</table>
<?php
echo close_div();
?>