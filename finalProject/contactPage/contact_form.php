<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us | Any-Plate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../styles.css" />
    <link rel="stylesheet" href="../fonts.css" />
    <!--Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <style>
        h2,
        .alert {
            text-align: center;
        }

        .alert {
            margin: 3rem;
        }

        label {
            font-weight: bold;
        }

        .contactForm {
            margin-bottom: 50px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        img {
            max-width: 480px;
        }

        .col-md-8 {
            padding: 50px;
        }

        .linkButton {
            background-color: #00bf6380;

        }

        .linkButton:hover {
            background-color: #00BFA4;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Toggle hamburger menu
            const navbarToggler = document.querySelector(".navbar-toggler");
            const navContent = document.querySelector(".navbar-collapse");

            navbarToggler.addEventListener("click", function() {
                navContent.classList.toggle("show");
            });

            window.addEventListener("mouseup", function(e) {
                if (
                    !navbarToggler.contains(e.target) &&
                    !navContent.contains(e.target)
                ) {
                    navContent.classList.remove("show");
                }
            });

            // Dynamically display the current year in footer
            const currentYear = new Date().getFullYear();
            document.querySelector("#currentYear").textContent = currentYear;
        });
    </script>
</head>

<body>
    <!--Navigation Menu-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded poppins-regular">
        <div class="container">
            <a class="navbar-brand" href="../index.html"><img src="../images/logo.png" width="200px" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navContent">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_form.php">Contact Us</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="../admin/registration/login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="py-3 mb-3 border-bottom">
        <div class="jumbotron text-center py-4">
            <h1 class="display-5 poppins-semibold">
                Savor Every Bite, Explore Every Recipe: <br />Any-Plate
            </h1>
            <p class="lead poppins-light">
                Your go-to destination for a world of delicious recipes
            </p>
        </div>
    </header>


    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center poppins-light m-4">
                    Do you have a question, suggestion, or technical issue?
                </h2>
                <h3 class="text-center poppins-medium mb-4">We would love to hear from you!</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 offset-lg-3 mt-4">
                <img src="../images/cooking.jpg" class="rounded mx-auto d-block img-fluid" alt="Computer on kitchen counter displaying recipe website">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="alert alert-light mb-4 poppins-regular" role="alert">
                    <p class="text-center">Please reach out to us with your recipe recommendations, questions regarding a specific recipe, as well as assist with any technical issues on our website.</p>
                    <p class="text-center">Complete the form below, and we will reach back out to you as soon as possible.</p>
                </div>
            </div>
        </div>
    </div>


    <!--Contact Form-->
    <main>
        <div class="container poppins-regular">
            <div class="row">
                <div class="col-md-8 offset-md-2 bg-light border rounded-3">
                    <form action="formHandler.php" method="POST" class="contactForm py-4">
                        <div class="mb-3">
                            <label for="contact_name" class="form-label">Contact Name:</label>
                            <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact_email">Contact Email Address:</label>
                            <input type="text" class="form-control" id="contact_email" name="contact_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="reason">Reason for Contact:</label>
                            <select class="form-select" id="reason" name="reason" required>
                                <option value="">Select a reason</option>
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Technical Support">Technical Support</option>
                                <option value="Feedback">Feedback</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="comments">Comments:</label>
                            <textarea class="form-control" id="comments" name="comments" rows="4" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn border border-secondary linkButton mt-4">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="bg-light text-center border-top">
        <p>&copy; <span id="currentYear"></span> Any-Plate</p>
    </footer>

    <!--JS & Popper Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>