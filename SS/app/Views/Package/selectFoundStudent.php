<?php
helper("custom1_helper");
$open_div = info_div();
echo $open_div;
$properties = '';
?>
<h1>Packages waiting to be received</h1><br />
<br />
<table cellpadding="6">
  <tr>
    <th>First name</th>
    <th>Last name</th>
    <th>BUILDING</th>
    <th>ROOOM #</th>
    <th>Preferred Name</th>
    <th>IMAGE</th>
    <th>SELECT</th>
  </tr>
  <?php foreach ($query as $row) :
    $mime = null;
  ?>

    <tr style="vertical-align:middle;">
      <td><?php echo utf8_encode($row->FIRST_NAME); ?></td>
      <td><?php echo utf8_encode($row->LAST_NAME); ?></td>
      <td><?php echo $row->BUILDING; ?></td>
      <td><?php echo $row->ROOM_NUM; ?></td>
      <td><?php echo $row->prefName; ?></td>
      <td><?php echo '<img size="125" height="125" src="data:image/jpeg;base64,' . base64_encode($row->IMAGE) . '"/>'; ?> </td>
      <td><?php echo anchor('GetSearchSelectedStudent?id=' . $row->BANNER_ID, 'Select'); ?></td>
    </tr>
  <?php endforeach; ?>
</table>
<?php
$close_div = close_div();
echo $close_div;
?>