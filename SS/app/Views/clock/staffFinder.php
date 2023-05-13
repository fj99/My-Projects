<?php
echo form_open('/staff');
?>
<table>
  <tr>
    <td>Staff ID</td>
    <td><input type="text" name="staffId" placeholder="Enter Staff ID" onClick="this.select();" autocomplete="off" /></td>
    <td></td>
    <td><input type="submit" class="button" value="Look up" /></td>
  </tr>
</table>
<?php
echo form_close();
?>