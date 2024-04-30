<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Error | Any-Plate</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- Font Families -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <!-- Custom Stylesheets -->
    <link rel="stylesheet" href="../../styles.css" />
    <link rel="stylesheet" href="../../fonts.css" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dynamically display the current year in footer
            const currentYear = new Date().getFullYear();
            document.querySelector("#currentYear").textContent = currentYear;

            // Toggle hamburger menu
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navContent = document.querySelector('.navbar-collapse');

            navbarToggler.addEventListener('click', function() {
                navContent.classList.toggle('show');
            });

            window.addEventListener('mouseup', function(e) {
                if (!navbarToggler.contains(e.target) && !navContent.contains(e.target)) {
                    navContent.classList.remove('show');
                }
            });
        });
    </script>

    <style>
        footer {
            color: gray;
            padding: 20px;
        }

        .btn {
            background-color: #00bf6380;
        }

        .btn a {
            color: white;
        }

        a {
            color: #00BBBF;
        }

        a:hover {
            color: #005CBF;
        }

        a:link {
            text-decoration: none;
        }

        a:visited {
            text-decoration: none;
        }

        .btn a:hover {
            text-decoration: none;
            color: #005CBF;
            font-weight: 400;
        }

        a:active {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <!--Navigation Menu-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded poppins-regular">
        <div class="container">
            <a class="navbar-brand" href="../index.html"><img src="../../images/logo.png" width="200px" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../contactPage/contact_form.php">Contact Us</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="../registration/login.php">Login</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-md-0">
                    <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="search" name="search" />
                </form>
            </div>
        </div>
    </nav>

    <header class="py-3 mb-5 border-bottom">
        <div class="jumbotron text-center py-4">
            <h1 class="display-5 poppins-regular">
                Savor Every Bite, Explore Every Recipe: <br />Any-Plate
            </h1>
            <p class="lead poppins-light">
                Your go-to destination for a world of delicious recipes
            </p>
        </div>
    </header>
    <main>
        <div class="container text-center py-4 poppins-semibold"">
        <h1 class=" mb-5">Oops! Sorry about that.</h1>
            <h2>Looks like there was a problem on our end. </h2>
            <h2>Please try again. </h2>
            <br>
            <h3>If the error persists, <a href="../../contactPage/contact_form.php" class="contactAdminLink">contact your administrator.</a></h3>

            <button class="btn btn-lg btn-block mt-5"><a href="../../index.html" class="poppins-light">Return to Home Page</a></button>
        </div>
    </main>
    <footer class="bg-light text-center border-top mt-5">
        <p>&copy; <span id="currentYear"></span> Any-Plate</p>
    </footer>
</body>

</html>