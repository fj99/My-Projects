<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
</head>
<body>
    <h1>This is a Page to test </h1>
    <?php
    foreach ($form_data->getResult() as $row2) {
    //  foreach ($form_data as $row2) {
        echo var_dump($row2);
    }
    ?>
</body>
</html>