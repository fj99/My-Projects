<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Done</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
</head>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600;700;800;900&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

  :root {
    --font1: 'Heebo', sans-serif;
    --font2: 'Fira Sans Extra Condensed', sans-serif;
    --font3: 'Roboto', sans-serif
  }

  body {
    font-family: var(--font3);
    background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
    text-align: center;
  }

  h2 {
    font-weight: 900
  }

  .container-fluid {
    max-width: 1200px
  }

  .card {
    /* background: #fff; */
    background: var(--normal);
    box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
    transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
    border: 0;
    border-radius: 1rem;
    color: #fff;
    padding-top: 10px;
  }

  .card-img,
  .card-img-top {
    border-radius: calc(1rem - 1px);
    /* border-radius: 50%; */
    background-color: #203472;
    width: 50% !important;
    /* margin: auto; */
  }

  .card h5 {
    overflow: hidden;
    height: 56px;
    font-weight: 900;
    font-size: 1rem
  }

  .card-img-top {
    width: 100%;
    /* max-height: 180px; */
    object-fit: contain;
    /* padding: 30px */
    padding: 0px
  }

  .card h2 {
    font-size: 1rem
  }

  .card:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06)
  }

  .label-top {
    position: absolute;
    background-color: #8bc34a;
    color: #fff;
    top: 8px;
    right: 8px;
    padding: 5px 10px 5px 10px;
    font-size: .7rem;
    font-weight: 600;
    border-radius: 3px;
    text-transform: uppercase
  }

  .top-right {
    position: absolute;
    top: 24px;
    left: 24px;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    font-size: 1rem;
    font-weight: 900;
    background: #ff5722;
    line-height: 90px;
    text-align: center;
    color: white
  }

  .top-right span {
    display: inline-block;
    vertical-align: middle
  }

  @media (max-width: 768px) {
    .card-img-top {
      max-height: 250px
    }
  }

  .over-bg {
    background: rgba(53, 53, 53, 0.85);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(0.0px);
    -webkit-backdrop-filter: blur(0.0px);
    border-radius: 10px
  }

  .btn {
    font-size: 1rem;
    font-weight: 500;
    text-transform: uppercase;
    padding: 5px 50px 5px 50px
  }

  .box .btn {
    font-size: 1.5rem
  }

  @media (max-width: 1025px) {
    .btn {
      padding: 5px 40px 5px 40px
    }
  }

  @media (max-width: 250px) {
    .btn {
      padding: 5px 30px 5px 30px
    }
  }

  .btn-warning {
    background: none #203472;
    color: #ffffff;
    fill: #ffffff;
    border-color: var(--highlight);
    /* border: 20px; */
    text-decoration: none;
    outline: 1;
    box-shadow: -1px 6px 19px rgba(247, 129, 10, 0.25);
    border-radius: 100px
  }

  .bg-success {
    font-size: 1rem;
    background-color: #203472 !important
  }

  .bg-danger {
    font-size: 1rem
  }

  .price-hp {
    font-size: 1rem;
    font-weight: 600;
    color: darkgray
  }

  .amz-hp {
    font-size: .7rem;
    font-weight: 600;
    color: darkgray
  }

  .fa-question-circle:before {
    color: darkgray
  }

  .fa-plus:before {
    color: darkgray
  }

  .box {
    border-radius: 1rem;
    background: #fff;
    box-shadow: 0 6px 10px rgb(0 0 0 / 8%), 0 0 6px rgb(0 0 0 / 5%);
    transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12)
  }

  .box-img {
    max-width: 300px
  }

  .thumb-sec {
    max-width: 300px
  }

  @media (max-width: 576px) {
    .box-img {
      max-width: 200px
    }

    .thumb-sec {
      max-width: 200px
    }
  }

  .inner-gallery {
    width: 60px;
    height: 60px;
    border: 1px solid #ddd;
    border-radius: 3px;
    margin: 1px;
    display: inline-block;
    overflow: hidden;
    -o-object-fit: cover;
    object-fit: cover
  }

  @media (max-width: 370px) {
    .box .btn {
      padding: 5px 40px 5px 40px;
      font-size: 1rem
    }
  }

  .disclaimer {
    font-size: .9rem;
    color: darkgray
  }

  .related h3 {
    font-weight: 900
  }

  footer {
    background: #212529;
    height: 80px;
    color: #fff
  }

  .center {
    margin: 0, auto;
  }

  a {
    text-align: center;
    display: inline-block;
    text-decoration: none;
    color: #fff;
  }

  :root {
    --normal: #203472;
    /* --highlight: #53b0d6; */
    --highlight: #DAE12A;
    /* yellow_color = #ffca2c */
  }

  span:hover {
    background-color: var(--highlight) !important;
  }

  .card-img:hover,
  .card-img-top:hover {
    background-color: var(--highlight);
  }

  .btn-warning:hover {
    background: none var(--highlight);
    color: var(--normal);
    box-shadow: -1px 6px 13px rgba(255, 150, 43, 0.35);
  }

  .col {
    width: 50%;
    margin: auto;
  }

  img {
    width: 50%;
    margin: auto;
  }
</style>

<body>
  <main>
    <br>
    <h1>Your Form has been submitted</h1>
    <!-- //* add text when you hover -->
    <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
      <div class="row row-cols-1 row-cols-xs-1 row-cols-sm-1 row-cols-lg-1 g-1 center">

        <div class="col">
          <di class="card h-100 shadow-sm">
            Thank you for submitting your form your card should now work.
            <br>
            If you are having trouble please submit a tech request<a href="https://prd-stuaff01.southernct.edu/residencelife/reslife/forms/misc/tech_request_form.php">Here</a>
            <br>
            <img src="https://prd-stuaff01.southernct.edu/residencelife/reslife/portal/images/new_scsu_logo.png">
            <div class="card-body">
              <div class="text-center my-4">
                <a href="home" class="btn btn-warning">Home</a>
              </div>
              <hr>
            </div>
        </div>
      </div>

    </div>
    </div>
  </main>
</body>

</html>