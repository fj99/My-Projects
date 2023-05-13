<?php
// TODO maybe create a helper for this
helper("custom1_helper");
$open_div = info_div();
echo $open_div;
//visitor Finder  
$session = session();
?>
<table width="100%">
  <tr style="text-align: center;">
    <td>
      <span id=tick2>
      </span>
      <script>
        /*By JavaScript Kit
        http://javascriptkit.com
        Credit MUST stay intact for use
        */
        function show2() {
          if (!document.all && !document.getElementById)
            return
          thelement = document.getElementById ? document.getElementById("tick2") : document.all.tick2
          var Digital = new Date()
          var hours = Digital.getHours()
          var minutes = Digital.getMinutes()
          var seconds = Digital.getSeconds()
          var month = Digital.getMonth()
          var day = Digital.getDay()
          var year = Digital.getFullYear()
          var dn = "PM"
          if (hours < 12)
            dn = "AM"
          if (hours > 12)
            hours = hours - 12
          if (hours == 0)
            hours = 12
          if (minutes <= 9)
            minutes = "0" + minutes
          if (seconds <= 9)
            seconds = "0" + seconds
          var ctime = hours + ":" + minutes + ":" + seconds
          thelement.innerHTML = "<b class='blue'><?php echo date('m-d-Y'); ?> " + ctime + "</b>"
          setTimeout("show2()", 1000)
        }
        window.onload = show2
      </script>
    </td>
    <td>
      <!-- StudentFinder Form -->
      <?php
      // echo form_open('student_controller/getStudent');
      echo form_open('getStudent');
      ?>
      <table>
        <tr>
          <td>HOST</td>
          <td>
            <?php
            $studentId = [
              "value" => $session->get('student_id'),
              "name" => "studentId",
              "placeholder" => "Enter Student ID",
              "onClick" => "this.select();",
              "autocomplete" => "off",
            ];

            echo form_input($studentId);
            ?>
            <!-- <input type="text" value="<?php echo $session->get('student_id'); ?>" name="studentId" placeholder="Enter Student ID" onClick="this.select();" <?php if ($session->get('found') == "guest") echo "autofocus"; ?> autocomplete="off" /> -->
          </td>
          <td>
            <?php echo form_submit("", "Lookup", "class = button"); ?>
          </td>
        </tr>
      </table>
      <?php
      //close form here 
      echo form_close();
      ?>
    </td>
    <td>
      <!-- guestFinder -->
      <?php
      // echo form_open('student_controller/getVisitor');
      echo form_open('getVisitor');
      ?>
      <table>
        <tr>
          <td>GUEST</td>
          <td>
            <input type="text" value="<?php echo  $session->get('guest_id'); ?>" name="studentId" placeholder="Enter Visitor's ID" onClick="this.select();" <?php if ($session->get('found') == "student") echo "autofocus"; ?> autocomplete="off" />
          </td>
    </td>
    <td>
      <input type="submit" class="button" value="Lookup" />
    </td>
  </tr>
</table>
<?php echo form_close(); ?>
</td>
<!-- <td><img src=<?php echo base_url('images/reslifelogo.png'); ?> style="width: 146px; height:67px; "/></td> -->
<td><?php $session->get('portal_active'); ?> </td>
</tr>
<br>
</table>

<br> <br>

</div>
</div>
<?php
// the following button below will only be display if accessed from the staff portal
if ($session->get('portal_active') == "1") {
  echo '<div class="info_top">'; //outer div
  echo '<div class="inner_info_top">';
  echo anchor('reslife/logOutPortal', '<button type="button" class = "button_guest" style="width:500px;">Log out, back to Portal</button>');

  if ($session->get('hall_name') == "testing") {
    echo anchor('reslife/sendFailedEmails', '<button type="button" class = "button_guest" style="width:500px;">Test! DON\'T TOUCH!!</button>');
    echo anchor('reslife/updateFailed', '<button type="button" class = "button_guest" style="width:500px;">Update!!</button>');
  }

  echo '</div></div>';
}
?>
<br>
<div id="wrapper">