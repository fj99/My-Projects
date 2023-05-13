<?php
helper("custom1_helper");
$info_div = info_div();
echo $info_div;
?>
<br>
<div class="title">
    <b style='background-color:#6495ED;'>Regular</b> <b style='background-color:#9B6A12;'>Overnight</b><br /><br />
</div>

<table cellpadding="6" style="margin:0 auto;" class="alternate-table" id="mytable">
    <thead>
        <tr>
            <th>Signed in</th>
            <th>Room</th>
            <th>Host first</th>
            <th>Host last</th>
            <th>Guest first</th>
            <th>Guest last</th>
            <th>Overnight</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($query as $row) : ?>
            <tr <?php if ($row->overnight != 0) echo "style='background-color:#9B6A12;'";
                else echo "style='background-color:#6495ED;'"; ?>>
                <td><?php echo  date('F j, Y, g:i a', strtotime($row->logintime)); ?></td>
                <td><?php echo $row->hostroom; ?></td>
                <td><?php echo $row->hostfirstname; ?></td>
                <td><?php echo $row->hostlastname; ?></td>
                <td><?php echo $row->guestfirstname; ?></td>
                <td><?php echo $row->guestlastname; ?></td>
                <td><?php if ($row->overnight == 1) echo "Yes";
                    else echo "No"; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$close_div = close_div();
echo $close_div;
?>