<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test</title>
</head>

<body>
  Testing
  <?php
  // echo $notifications->num_rows();
  $counter = 0;
  foreach ($notifications->getResult() as $row) {
    $counter += 1;
  }

  echo "<h1>$counter</h1>";
  // echo $num;
  echo "<br>";
  echo var_dump($notifications);
  ?>
</body>

</html>