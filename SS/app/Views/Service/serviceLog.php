<?php
helper("custom1_helper");
$info_div = info_div();
echo $info_div;
?>
<h1 class="title">Other guests. This includes Students visiting to market, Office of Residence Life, Lab, and work orders staff</h1><br />
<br />
<table cellpadding="6" class="alternate-table" id="mytable">
  <thead>
    <tr>
      <th>Date entered</th>
      <th>First name</th>
      <th>Last name</th>
      <th>Service</th>
      <th>Room</th>
      <th>Sign out </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($query as $row) : ?>
      <tr>
        <td><?php echo  date('F j, Y, g:i a', strtotime($row->logintime)); ?></td>
        <td><?php echo $row->hostfirstname; ?></td>
        <td><?php echo $row->hostlastname; ?></td>
        <td><?php echo $row->service; ?></td>
        <td><?php echo $row->hostroom; ?></td>
        <td><?php echo anchor('SignOutService?id=' . $row->id, 'Sign Out', array('onClick' => "return confirm('ATTENTION: has student shown ID?')")); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php
$close_div = close_div();
echo $close_div;
?>