<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap');

    *,
    body {
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
        -moz-osx-font-smoothing: grayscale;
    }

    html,
    body {
        height: 100%;
        /* background-color: #152733; */
        background-color: #203472;
        overflow: hidden;
    }

    .form-holder {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        min-height: 100vh;
    }

    .form-holder .form-content {
        position: relative;
        text-align: center;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-align-items: center;
        align-items: center;
        padding: 60px;
    }

    .form-content .form-items {
        border: 3px solid #fff;
        padding: 40px;
        display: inline-block;
        width: 100%;
        min-width: 540px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        text-align: left;
        -webkit-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }

    .form-content h3 {
        color: #fff;
        text-align: left;
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .form-content h3.form-title {
        margin-bottom: 30px;
    }

    .form-content p {
        color: #fff;
        text-align: left;
        font-size: 17px;
        font-weight: 300;
        line-height: 20px;
        margin-bottom: 30px;
    }

    .form-content label,
    .was-validated .form-check-input:invalid~.form-check-label,
    .was-validated .form-check-input:valid~.form-check-label {
        color: #fff;
    }

    .form-content input[type=text],
    .form-content input[type=password],
    .form-content input[type=email],
    .form-content select {
        width: 100%;
        padding: 9px 20px;
        text-align: left;
        border: 0;
        outline: 0;
        border-radius: 6px;
        background-color: #fff;
        font-size: 15px;
        font-weight: 300;
        color: #8D8D8D;
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease;
        margin-top: 16px;
    }

    .btn-primary {
        background-color: #6C757D;
        outline: none;
        border: 0px;
        box-shadow: none;
    }

    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active {
        background-color: #495056;
        outline: none !important;
        border: none !important;
        box-shadow: none;
    }

    .form-content textarea {
        position: static !important;
        width: 100%;
        padding: 8px 20px;
        border-radius: 6px;
        text-align: left;
        background-color: #fff;
        border: 0;
        font-size: 15px;
        font-weight: 300;
        color: #8D8D8D;
        outline: none;
        resize: none;
        height: 120px;
        -webkit-transition: none;
        transition: none;
        margin-bottom: 14px;
    }

    .form-content textarea:hover,
    .form-content textarea:focus {
        border: 0;
        background-color: #ebeff8;
        color: #8D8D8D;
    }

    .mv-up {
        margin-top: -9px !important;
        margin-bottom: 8px !important;
    }

    .invalid-feedback {
        color: #ff606e;
    }

    .valid-feedback {
        color: #2acc80;
    }

    .home {
        text-align: left;
        padding-left: 10px;
        padding-top: 10px;
    }

    .btn {
        border-radius: 1rem;
    }
</style>

<body>
    <div class="home">
        <a href="home">
            <img src="https://prd-stuaff01.southernct.edu/residencelife/reslife/portal/images/Card_app/home-icon(W).png" class="btn btn-primary">
        </a>
    </div>
    <div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Enter Info to Return Card</h3>
                        <p>Fill in the data below.</p>
                        <!-- Add a drop down of which card you want to return -->
                        <form action="returning_card" method="post" class="requires-validation" novalidate>

                            <div class="col-md-12">
                                <select class="form-select mt-3" name="card" required>
                                    <option selected disabled value="">Card Number</option>
                                    <?php
                                    foreach ($card_numbers->getResult() as $row) {
                                        $x = $row->id;
                                        $i = $row->card_number;
                                        echo "<option value='$x'>$i</option>";
                                    }
                                    ?>
                                </select>
                                <div class="valid-feedback">You selected a card number!</div>
                                <div class="invalid-feedback">Please select a card number!</div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                <label class="form-check-label">I confirm that all the data is correct</label>
                                <div class="invalid-feedback">Please confirm that the entered data is all correct!</div>
                            </div>

                            <div class="form-button mt-3">
                                <button id="submit" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    (function() {
        'use strict'
        const forms = document.querySelectorAll('.requires-validation')
        Array.from(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>

</html>