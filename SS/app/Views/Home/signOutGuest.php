<?php
helper("custom1_helper");
$info_div = info_div();
echo $info_div;
?>
<h1 class="title">Current guest<br /></h1>
<div class="title">
  <b style='background-color:#6495ED;'>Regular</b> <b style='background-color:#9B6A12;'>Overnight</b><br /><br />
</div>

<table cellpadding="6" class="alternate-table" id="mytable">
  <thead>
    <tr>
      <th>Signed in</th>
      <th>Room</th>
      <th>Host First</th>
      <th>Host Last</th>
      <th>Guest First</th>
      <th>Guest Last</th>
      <th>Check Out</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($query as $row) : ?>
      <!-- <form action=""></form> -->
      <tr <?php if ($row->overnight == 1) echo "style='background-color:#9B6A12;'";
          else echo "style='background-color:#6495ED;'"; ?>>
        <td><?php echo  date('F j, Y, g:i a', strtotime($row->logintime)); ?></td>
        <td><?php echo $row->hostroom; ?></td>
        <td><?php echo $row->hostfirstname; ?></td>
        <td><?php echo $row->hostlastname; ?></td>
        <td><?php echo $row->guestfirstname; ?></td>
        <td><?php echo $row->guestlastname; ?></td>
        <td><?php echo anchor('signOut?id=' . $row->id, 'Sign Out'); ?></td>
      </tr>
    <?php endforeach; ?>
  <tbody>
</table>
<?php
$close_div = close_div();
echo $close_div;
?>