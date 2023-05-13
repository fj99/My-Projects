<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f8f8;
    }

    h1 {
      font-size: 36px;
      color: #333;
      margin-bottom: 20px;
    }

    p {
      font-size: 24px;
      color: #666;
      margin-bottom: 20px;
    }

    a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      font-size: 20px;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.2s ease-in-out;
    }

    a:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <h1>Oops! Something went wrong.</h1>
  <p>An error occurred:</p>
  <?php
  if (isset($error_message)) {
    echo $error_message;
  }
  echo anchor('Home', 'Go to Homepage');
  ?>
</body>

</html>