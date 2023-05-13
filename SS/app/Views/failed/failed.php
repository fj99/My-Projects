<?php
helper("custom1_helper");
echo info_div();
echo br(1);
echo attentionDiv();
echo "<b>This is one of the most important functionalities of the system, please report any errors by clicking the support tab.</b>";
echo close_div();
echo form_open('/regularFails');
echo br(2);
echo "<input type='submit' class='button' value='Regular Failed' />";
echo form_close();
echo br(3);
echo form_open('/overnightFails');
echo "<input type='submit' class='button' value='Overnight Failed' />";
echo form_close();
echo close_div();
