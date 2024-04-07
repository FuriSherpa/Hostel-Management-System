<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayEase</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">StayEase</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About Us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Login
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="student/index.php">Student Login</a>
                        <a class="dropdown-item" href="#">Staff Login</a>
                        <a class="dropdown-item" href="admin/index.php">Admin Login</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="assets/images/1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="assets/images/2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="assets/images/3.jpg" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <section id="features" class="mt-5">
    <div class="container">
        <h2 class="text-center">Features <br><br></h2>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-item text-center">
                    <img src="path_to_your_image/image1.jpg" class="img-fluid" alt="Feature 1">
                    <h3>24/7 Security</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis justo et dolor tempus vehicula.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item text-center">
                    <img src="path_to_your_image/image2.jpg" class="img-fluid" alt="Feature 2">
                    <h3>High-Speed Internet</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis justo et dolor tempus vehicula.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item text-center">
                    <img src="path_to_your_image/image3.jpg" class="img-fluid" alt="Feature 3">
                    <h3>Friendly Environment</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis justo et dolor tempus vehicula.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="mt-5">
    <div class="container">
        <h2 class="text-center">About Us <br><br></h2>
        <div class="row">
            <div class="col-md-6">
                <img src="path_to_your_image/about_image.jpg" class="img-fluid" alt="About Us Image">
            </div>
            <div class="col-md-6">
                <h3>Our Story</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis justo et dolor tempus vehicula. Integer auctor, lorem in vehicula commodo, libero justo tincidunt justo, a consequat enim urna eget nulla. Donec ullamcorper, nulla eget suscipit tempus, urna ex suscipit purus, eu dapibus nisi elit et odio.</p>
                <h3>Our Mission</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis justo et dolor tempus vehicula. Integer auctor, lorem in vehicula commodo, libero justo tincidunt justo, a consequat enim urna eget nulla. Donec ullamcorper, nulla eget suscipit tempus, urna ex suscipit purus, eu dapibus nisi elit et odio.</p>
                <h3>Our Values</h3>
                <ul>
                    <li>Lorem ipsum dolor sit amet</li>
                    <li>Consectetur adipiscing elit</li>
                    <li>Sed quis justo et dolor tempus vehicula</li>
                    <li>Integer auctor, lorem in vehicula commodo</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<footer class="footer mt-auto py-3 bg-dark text-white">
    <div class="container text-center">
        <span>&copy; 2024 StayEase. All rights reserved.</span>
        <span class="ml-2">Designed by Team-B</span>
    </div>
</footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>