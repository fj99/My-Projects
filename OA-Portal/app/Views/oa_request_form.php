<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OA TEST FORM</title>

    <!--link jquery ui css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .errorlist {
            color: red;
            padding-left: 50px;
        }

        .input_fields {
            padding-top: 20;
            padding-left: 50px;
            padding-bottom: 50px;
        }
    </style>
</head>

<body>


    <div class="errorlist">
        <?php
        if (isset($validation)) {
            print_r($validation->listErrors());
        }
        if (isset($message)) {
            echo '<br><br>' . ($message) . '<br><br>';
        }
        ?>
    </div>
    <?= form_open('form'); ?>
    <div class="input_fields">

        <h2> Operations Assistant Request Form </h2>
        <p><u> ALL FIELDS REQUIRED</u></p>

        <?php
        //! Find out which function I need to call so that I can show the validation errors in my view
        echo form_label($first_name[1]['label']) . form_input($first_name[0]) . '<br><br>';
        echo form_label($last_name[1]['label']) . form_input($last_name[0]) . '<br><br>';
        echo form_label($formDropDown[0]['label']) . form_dropdown($formDropDown[1], $formDropDown[2]) .
            form_label($room[1]['label']) . form_input($room[0]) . '<br><br>';
        echo form_label($requestType[6]['title']) . '<br>';
        echo form_radio($requestType[0]) . form_label($requestType[6]['1']) . '<br>';
        echo form_radio($requestType[1]) . form_label($requestType[6]['2']) . '<br>';
        echo form_radio($requestType[2]) . form_label($requestType[6]['3']) . '<br>';
        echo form_radio($requestType[3]) . form_label($requestType[6]['4']) . '<br>';
        echo form_radio($requestType[4]) . form_label($requestType[6]['5']) . '<br>';
        echo form_radio($requestType[5]) . form_label($requestType[6]['6']) . '<br><br>';

        echo form_label($requestPriority[6]['title']) . '<br>';
        echo form_radio($requestPriority[0]) . form_label($requestPriority[6]['1']) . '<br>';
        echo form_radio($requestPriority[1]) . form_label($requestPriority[6]['2']) . '<br>';
        echo form_radio($requestPriority[2]) . form_label($requestPriority[6]['3']) . '<br>';
        echo form_radio($requestPriority[3]) . form_label($requestPriority[6]['4']) . '<br>';
        echo form_radio($requestPriority[4]) . form_label($requestPriority[6]['5']) . '<br>';
        echo form_radio($requestPriority[5]) . form_label($requestPriority[6]['6']) . '<br><br>';

        echo form_label($datePicker[1]['label']) . form_input($datePicker[0]) . '<br><br>';
        ?>



        <?php


        echo form_label($residentAvailability[1]['label']) . '<br>' . form_textarea($residentAvailability[0]) . '<br>';
        echo form_label($descriptionRequest[1]['label']) . '<br>' . form_textarea($descriptionRequest[0]) . '<br><br>';
        echo form_submit($submit_button) . ' | ' . form_reset($reset_button);

        ?>

        <?= form_close() ?>

    </div>

    <!--load jquery-->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <!--load jquery ui js file-->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script type="text/javascript">
        $(function() {
            $("#datePicker").datepicker();
        });
    </script>

</body>

</html>