<?php
helper("custom1_helper");
$info_div = info_div();
echo $info_div;
//print_r($query);
?>
<h1 class="title">Equipment Log</h1><br />
<br />
<table cellpadding="6" class="alternate-table" id="mytable">
  <thead>
    <tr>
      <th>Date entered</th>
      <th>First name</th>
      <th>Last name</th>
      <th>Room</th>
      <th>Item</th>
      <th>Quantity</th>
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
        <td><?php echo $row->item; ?></td>
        <td><?php echo $row->quantity; ?></td>
        <td><?php echo anchor('/returnEquipment?id=' . $row->id, 'RETURN'); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php
$close_div = close_div();
echo $close_div;
?>