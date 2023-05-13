<?php
$session = session();
helper("custom1_helper");
echo info_div();
?>
<br />
<h1 class="title">Key Log</h1><br />
<table cellpadding="6" class="alternate-table" id="mytable">
  <thead>
    <tr>
      <th>Date entered</th>
      <th>First name</th>
      <th>Last name</th>
      <th>Email</th>
      <th>Room</th>
      <th>Key Number</th>
      <th>Checkout </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($query as $row) : ?>
      <tr>
        <td><?php echo date('F j, Y, g:i a', strtotime($row->logintime)); ?></td>
        <td><?php echo $row->hostfirstname; ?></td>
        <td><?php echo $row->hostlastname; ?></td>
        <td><?php echo $row->email; ?></td>
        <td><?php echo $row->hostroom; ?></td>
        <td><?php echo $row->keynum; ?></td>
        <td><?php echo anchor('/returnKey?id=' . $row->id, 'RETURN'); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php
echo close_div();
?>