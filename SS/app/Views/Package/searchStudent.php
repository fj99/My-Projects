<?php
helper("custom1_helper");
$open_div = info_div();
echo $open_div;
echo form_open('searchStudent');
echo '<b><h1 class="title">Find Student by name</h1></b><br />';
?>
<table>
  <tr>
    <td>First name</td>
    <td><input type="text" name="first" tabindex=1 pattern=".{2,}" placeholder="At least 2 characters" onClick="this.select();" required autocomplete="off" /></td>
    <td rowspan="3" style="vertical-align: top;">

      <?php echo anchor('viewPackageLogOnly', '<button type="button" class = "button_guest">View log</button>'); ?>
    </td>
  </tr>
  <tr>
    <td>Last name</td>
    <td><input type="text" name="last" tabindex=2 pattern=".{2,}" placeholder="At least 2 characters" onClick="this.select();" required autocomplete="off" /></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" class="button" value="Look up" /></td>
  </tr>

</table>

<?php
//close form here 
echo form_close();
$close_div = close_div();
echo $close_div;
?>