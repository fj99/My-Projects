<?php
    //connect to db
    include 'DB/connect_to_db.php';    

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // Initialize sessions
    session_start();
    $status = 'Not Signed In';
    $signout = "<a hidden></a>";
    $parent = '<li class="nav-item"><a class="nav-link" href="Forms\Parent\Sign_in.php" >Parent<br><img src="assets/img/SignIn.png" width="35px" height="40px"></a></li>';
    $employee = '<li class="nav-item"><a class="nav-link" href="Forms\Employee\Sign_in.php" >Employee<br><img src="assets/img/employee.png" width="35px" height="40px"></a></li>';

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {      
        $parent = "<a hidden></a>";
        $employee = "<a hidden></a>";
             

        if($_SESSION['employee'])
        {
            $status = "Employee";   
            $signout='<a class="nav-link" href="sign_out.php" ><img src="assets/img/employee-out.png" width="35px" height="40px"></a>';              
        }
        elseif($_SESSION['parent'])
        {
            $status = "Parent"; 
            $signout='<a class="nav-link" href="sign_out.php" ><img src="assets/img/SignOut.png" width="35px" height="40px"></a>';                
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Children Daycare</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-logo.svg" alt="..." width="200px"/></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">                        
                        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>                        
                        <li class="nav-item"><a class="nav-link" href="Delete.php">Delete</a></li> 
                        <?php echo $employee;?>                     
                        <?php echo $parent;?>
                        <li class="nav-item"><a class="nav-link" href="Status.php"><?php echo $status;?></a></li>
                        <li class="nav-item"><?php echo $signout;?></li>                        
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading">Welcome To Happy Children Daycare!</div>
                <div class="masthead-heading text-uppercase">It's Nice To Meet You</div>
                <a class="btn btn-primary btn-xl text-uppercase" href="#services">More About Us</a>
            </div>
        </header>

        <!-- Services-->
        <section class="page-section" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Services</h2>
                </div>
                <div class="row text-center">
                    <div class="col-md-4">
                        <a href = Forms/Parent/Sign_up_Parent.php>
                            <span class="fa-stack fa-4x" >
                                <i class="fas fa-circle fa-stack-2x text-primary"></i>
                                <i class="fas fa-people-arrows fa-stack-1x fa-inverse"></i>
                            </span>
                            <h4 class="my-3">Parent</h4>
                        </a>                       
                        
                    </div>
                    <div class="col-md-4">
                        <a href = Forms/Child/Sign_up_Child.php>
                            <span class="fa-stack fa-4x">
                                <i class="fas fa-circle fa-stack-2x text-primary"></i> 
                                <i class="fas fa-child fa-stack-1x fa-inverse"></i>
                            </span>
                            <h4 class="my-3">Children</h4>
                        </a>                        
                        
                    </div>
                    <div class="col-md-4">
                        <a href = Forms/Employee/Sign_up_Employee.php>
                            <span class="fa-stack fa-4x">
                                <i class="fas fa-circle fa-stack-2x text-primary"></i>
                                <i class="fas fa-user-tie fa-stack-1x fa-inverse"></i>
                            </span>
                            <h4 class="my-3">Employee</h4>
                        </a>                        
                        
                    </div>
                </div>
            </div>
        </section>
        <!-- About-->
        
        <section class="page-section" id="about">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">About</h2>
                    <h1 style=" text-align: justify; font-style: italic; font-size: 25px;" > 
                        This platform aims to put parents at ease leaving their children 
                        so they can go about their lives at peace. Using our automated systems to keep 
                        parents updated, staff informed, and children happy, we seek to  make the daycare 
                        experience as smooth and efficient as possible.</h1> 
                 </div>
            </div>
        </section>    
        <!-- Team-->
        <section class="page-section bg-light" id="team">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Our Team</h2>
                    
                </div>

                <div class="row">
                    <div class="col-lg-4" style="margin:auto;">>
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="https://i.pinimg.com/736x/5b/9d/50/5b9d5065b8b90cf44433ae5d1e4db0b7.jpg" alt="..." />
                            <h4>Felix Fernandez</h4>
                            <p class="text-muted">Full-Stack Dev</p>
                           
                        </div>
                    </div>                    
                </div>            
                
            </div>
        </section>
        <section class="page-section" id="contact">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Contact Us</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
                </div>
                <!-- * * * * * * * * * * * * * * *-->
                <!-- * * SB Forms Contact Form * *-->
                <!-- * * * * * * * * * * * * * * *-->
                <!-- This form is pre-integrated with SB Forms.-->
                <!-- To make this form functional, sign up at-->
                <!-- https://startbootstrap.com/solution/contact-forms-->
                <!-- to get an API token!-->
                <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                    <div class="row align-items-stretch mb-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- Name input-->
                                <input class="form-control" id="name" type="text" placeholder="Your Name *" data-sb-validations="required" />
                                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                            </div>
                            <div class="form-group">
                                <!-- Email address input-->
                                <input class="form-control" id="email" type="email" placeholder="Your Email *" data-sb-validations="required,email" />
                                <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                                <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                            </div>
                            <div class="form-group mb-md-0">
                                <!-- Phone number input-->
                                <input class="form-control" id="phone" type="tel" placeholder="Your Phone *" data-sb-validations="required" />
                                <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-textarea mb-md-0">
                                <!-- Message input-->
                                <textarea class="form-control" id="message" placeholder="Your Message *" data-sb-validations="required"></textarea>
                                <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                            </div>
                        </div>
                    </div>
                    <!-- Submit success message-->
                    <!---->
                    <!-- This is what your users will see when the form-->
                    <!-- has successfully submitted-->
                    <div class="d-none" id="submitSuccessMessage">
                        <div class="text-center text-white mb-3">
                            <div class="fw-bolder">Form submission successful!</div>
                            To activate this form, sign up at
                            <br />
                            <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                        </div>
                    </div>
                    <!-- Submit error message-->
                    <!---->
                    <!-- This is what your users will see when there is-->
                    <!-- an error submitting the form-->
                    <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                    <!-- Submit Button-->
                    <div class="text-center"><button class="btn btn-primary btn-xl text-uppercase disabled" id="submitButton" type="submit">Send Message</button></div>
                </form>
            </div>
        </section>
        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">Copyright &copy; Your Website 2021</div>
                    <div class="col-lg-4 my-3 my-lg-0">
                        <!-- <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a> -->
                        <a class="btn btn-dark btn-social mx-2" href="https://github.com/fj99?tab=repositories"><i class="fab fa-github"></i></a> 
                        <a class="btn btn-dark btn-social mx-2" href="https://www.linkedin.com/in/felix-fernandez-92a0021b5/"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                        <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                    </div>
                </div>
            </div>
        </footer>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
       <!-- Bootstrap core JS-->
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
       <!-- Core theme JS-->
       
       
       <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
       <!-- * *                               SB Forms JS                               * *-->
       <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
       <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
       <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>  
       
    </body>
</html>
