<?php
helper("custom1_helper");
$table = new \CodeIgniter\View\Table();
$tmpl = array('table_open'  => '<table class="alternate-table" id="mytable">');
$table->setTemplate($tmpl);
// $this->set_template($tmpl);
echo info_div();
echo "<div class='title'><h3><b>1111-11-11</b> or <b>9999-09-09</b> date means date is not available</h3><br /></div>";
if ($query) {
  if ($query->getNumRows() > 0) {
    $table->setHeading('First', 'Last', 'ID', 'DOB', 'Address', 'Banned buildings', 'From', 'To');
    foreach ($query->getResult() as $row) {
      $halls_banned = "";

      if ($row->banned_from != "") {
        $halls_banned .= $row->banned_from . "<br />";
      } elseif ($row->hall_name != "") {
        $halls_banned .= $row->hall_name . "<br />";
      }

      if ($row->all_halls == "1") {
        $halls_banned .=  "All Halls <br />";
      }
      if ($row->campus == "1") {
        $halls_banned .= "Campus";
      }
      $table->addRow($row->name_first, $row->name_last, $row->student_id, $row->DOB, $row->address, $halls_banned, $row->banned_start, $row->banned_end);
    }
    echo $table->generate();
  } else {
    //zero rows returned
  }
}
echo close_div();
