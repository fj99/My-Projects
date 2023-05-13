<?php
helper("custom1_helper");
$open_div = info_div();
echo $open_div;
?>
<h1 class="title">Packages waiting to be received</h1><br />
<br />
<table cellpadding="6" class="alternate-table" id="mytable">
  <thead>
    <tr>
      <th>Date entered</th>
      <th>First name</th>
      <th>Last name</th>
      <th>Room</th>
      <th>Tracking #</th>
      <th>Carrier</th>
      <th>Checkout </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($query as $row) : ?>
      <tr>
        <td><?php echo  date('F j, Y, g:i a', strtotime($row->logintime)); ?></td>
        <td><?php echo $row->hostfirstname; ?></td>
        <td><?php echo $row->hostlastname; ?></td>
        <td><?php echo $row->hostroom; ?></td>
        <td><?php echo $row->tracking_num; ?></td>
        <td><?php echo $row->carrier; ?></td>
        <td><?php echo anchor('checkOutPackage?id=' . $row->id, 'PICK UP', array('onClick' => "return confirm('ATTENTION: Did you verify ID?')")); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php
$close_div = close_div();
echo $close_div;
?>