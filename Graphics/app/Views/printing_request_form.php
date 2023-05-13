<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="refresh" content="delay_time; URL=../home" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Printing Request Form</title>
</head>

<style>
div.one {
  border-style: solid;
  border-color: green;
  border-width: 2px;
  border-radius: 10px;
}

div.two {
  border-style: solid;
  border-color: red;
  border-width: 2px;
  border-radius: 10px;
  padding-left: 10px;
  width: 15%;
}

p.one {
  margin-left: 25px;
}

p.two {
  background-color: yellow;
}

body {
  background-color: beige;
}

td.one {
  border-right: 2px solid green;
  padding-right: 10px;
}

td.two {
  border-right: 2px solid green;
  padding-left: 10px;
  padding-right: 10px;
}

td.three {
  padding-left: 10px;
  padding-right: 10px;
}

span.clock {
  font-weight: bold;
  font-style: italic;
}
</style>

<body>
  <span class=clock id='clock'></span>
  <div><em><b><?php echo $dt->format("m/d/Y") ?></b></em></div>
  <script>
    var span = document.getElementById('clock');
    function time() {
      var d = new Date().toLocaleTimeString();
      span.textContent = d;
    }
    setInterval(time, 1000);
  </script>

<h2><em>Printing Request Form</em></h2>
<h3><em>(If you are having trouble submitting, try using Google Chrome.)</em></h3>
<hr><hr><br>

<?php

echo form_open_multipart('form_print');

if($validation !== ''){
  if($validation->hasError('first')): echo "<div class=two>" . $validation->getError('first') . "</div>"; endif; 
}
echo form_label('First: ', 'first') . "<br>" . form_input($first) . "<br><br>";

if($validation !== ''){
  if(($validation->hasError('last'))): echo "<div class=two>" . $validation->getError('last') . "</div>"; endif;
}
echo form_label('Last: ', 'last') . "<br>" . form_input($last) . "<br><br>";

if($validation !== ''){
  if(($validation->hasError('email'))): echo "<div class=two>" . $validation->getError('email') . "</div>"; endif;
}
echo form_label('Email: ', 'email') . "<br>" . form_input($email) . "<br><br>";

if($validation !== ''){
  if(($validation->hasError('phone'))): echo "<div class=two>" . $validation->getError('phone') . "</div>"; endif;
}
echo form_label('Phone: ', 'phone') . "<br>" . form_input($phone) . "<br><br>";

if($validation !== ''){
  if(($validation->hasError('building'))): echo "<div class=two>" . $validation->getError('building') . "</div>"; endif;
}
echo form_label('Building and floor: ', 'building') . "<br>" . form_input($building) . "<br><br>";

if($validation !== ''){
  if(($validation->hasError('date'))): echo "<div class=two>" . $validation->getError('date') . "</div>"; endif;
}
echo form_label('Requested Completion Date: ', 'date') . "<br>" . form_input($date);

echo "<p class=two>*Requests must be submitted a week before the request completion date, or there is a chance that the request may not be done on time.*</p>";
echo "<p><b><u>Television Request</u></b></p>";

echo form_radio($tvsYes) . form_label('Yes, I would like the final product to be placed on display TVs in all the residence halls.', 'tvs') . "<br>";
echo form_radio($tvsNo) . form_label('No, thanks.', 'tvs') . "<br>";
echo '<p>Please note that the measurements are in inches not feet.<br>At maximum, at least one side needs to be less than or equal to 42" (42" x XX" or XX" x 42").</p>';

echo '<div class=one>';
if($validation !== ''){
  if(($validation->hasError('pAmount'))): echo "<br><div class=two style='margin-left: 20px;'>" . $validation->getError('pAmount') . "</div>"; endif;
}
echo '<p class=one>Posters:<br><br>';
echo "Width: " . form_input($pWidth) . '"<br><br>';
echo "Height: " . form_input($pHeight) . '"<br><br>';
echo "Amount: " . form_input($pAmount) . '<br>';
echo "</div>";

echo '<br><div class=one>';
if($validation !== ''){
  if(($validation->hasError('fAmount'))): echo "<br><div class=two style='margin-left: 20px;'>" . $validation->getError('fAmount') . "</div>"; endif;
}
echo '<p class=one>Flyers 9" x 11":<br>';
echo form_radio($fPortrait) . form_label('Portrait', 'flyers') . "<br>";
echo form_radio($fLandscape) . form_label('Landscape', 'flyers') . "<br>";
echo 'Amt: ' . form_input($fAmount) . "</p>";
echo "</div><br>";

echo '<div class=one style="padding: 20px;">';

if($validation !== ''){
  if(($validation->hasError('description'))): echo "<div class=two>" . $validation->getError('description') . "</div><br>"; endif;
}
echo form_label('Description of request:', 'description') . "<br>" . form_textarea($description);
echo "</div>";

echo '<p class=two>***This is some new information to help get your individual files uploaded into the system. 
If a graphic designer cannot access them, it is because the upload failed. Sometimes this is due to conflicts with the way the files are named or the software that was used to create them.***
<br><br>
Individual files need a very unique name. Try the following format WITHOUT the quotations: "lastName_requestTitle_todaysDate"<br>
Here is an example: smith_Res_life_party_1-22-2020<br>
Ensure that, once the files are not zipped, the file DOES NOT exceed 7 megabytes. </p>';
echo '<p>To give our graphic designers a better understanding of what you would like to see, we request that you search for any images you feel may inspire your design.</p>';

if($validation !== ''){
  if(($validation->hasError('file'))): echo "<div class=two>" . $validation->getError('file') . "</div>"; endif;
}
echo form_label('Attach file: ', 'file') . form_upload($file) . '(max of 7MB)</p>';

echo form_reset($reset);
echo form_submit($submit);
echo form_close();

echo "<br><div><table>";
echo "<tr><td class=one><a href=https://prd-stuaff01.southernct.edu/residencelife/reslife/portal/files.php?>Portal</a></td>";
echo "<td class=two><a href=https://reslifeportal.southernct.edu/index.php/ResLife/login>Program Portal</a></td>";
echo "<td class=three><a href=http://southernct.edu/residencelife/>Office of Reslife</a></td></tr>";
echo "</table></div><br>";
?>

<script>
  function filevalidation() {
    var fileInput = document.getElementById('file');
    // var fileInput = document.getElementsByTagName('uploadedfile');

    var filePath = fileInput.value;

    // Allowing file type
    var allowedExtensions =
      /(\.jpg|\.jpeg|\.png|\.pdf)$/i;

    if (!allowedExtensions.exec(filePath)) {
      alert('Invalid file type');
      fileInput.value = '';
      document.getElementById('valid_input').innerHTML = 'Not acceptable';
      return false;
    } else {

      // Image preview
      if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        document.getElementById('valid_input').innerHTML = 'Acceptable';
        reader.readAsDataURL(fileInput.files[0]);
      }
    }
  }
</script>

</body>
</html>