<?php
//notes index page!
session_start();
if(!isset($_SESSION['userloggedin'])){
  header('Location: ../login.php');
  exit();

}
/*
if (!isset($_SESSION['userloggedin']) || $_SESSION['adminloggedin'] !== true) {
    header('Location: login.php');
    exit();
}*/

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tasks</title>

    <link rel="icon" type="image/png" href="../img/apple-touch-icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <style>
    .logo-to-brand {
        border-radius: 50%;
    }


    .btn.btn-primary:hover,
    .btn.btn-success:hover {
        border-color: #0c4b6b;
        color: rgb(5, 5, 5);

    }

    .btn.btn-primary {
        background-color: #0c617b;
        border-color: #8fbbe9;
        color: white;
    }

    .btn.btn-success {
        border-color: #8fbbe9;

    }

    .container {
        display: flex;
        flex-wrap: wrap;
    }

    .hero-text {
        font-size: 3rem;
        font-weight: 300;
        text-align: center;
        margin-top: 5vh;

    }

    .search-container {
        position: relative;
    }

    .search-input {
        padding-left: 10px;
        width: 350px;
    }

    .navbar-brand {
        font-family: "Poetsen One", sans-serif;
    }

    .navbar-nav .nav-link.active {
        text-decoration: underline;
        transform: rotateY('180deg');
    }

    .nav-underline .nav-link.active,
    .nav-underline .nav-link {
        color: #767373;
    }

    .nav-underline .nav-link.active {
        color: #0c617b;
    }

    #logout {
        color: #851609;
    }
    </style>
</head>

<body style="background-color: #568ec9;">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- Navigation elements-->
    <?php include_once '../nav-logged.php'; ?>


    <!-- Note input form -->
    <div class="container-md text-center mt-5" style="max-width: 1000px;">
        <img src="../img/puzzle.webp" alt="puzzle representing a task" height="300px" width="700px">
        <br>
        <div class="custom-shadow">
            <div class="card-type-2">
                <div>
                    <h1 class="hero-text" style="font-family: Poetsen One ,sans-serif; color:#1f3b59;">We got to
                        achieve...

                    </h1>


                </div>

                <!-- Task adder -->
                <div class="container-md" style="padding: 20px; background-color: #568ec9;">
                    <form action="dbtasks.php" method="POST">

                        <div class="row">

                            <div class="row col-md-3 p-4">
                                <input type="text" onclick="hideAlertBox()" class="form-control" id="deadline"
                                    name="deadline" placeholder="Deadline" required /><br>
                            </div>
                            <div class="row col-md-5 p-4">
                                <input type="text" class="form-control" id="taskName" name="taskname"
                                    placeholder="Task Name" required>
                            </div>
                            <div class="row col-md-2 p-4" style="margin-left: 60px;">
                                <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"
                                        style="font-size: 18px;"></i></button>
                            </div>
                            <div class="row col-md-2 p-4">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#searchModal">
                                    <i class="bi bi-search" style="font-size: 18px;"></i>
                                </button>
                            </div>

                            <div class="row col-md-12 p-4">
                                <input type="text" class="form-control" id="caption" name="caption"
                                    placeholder="Caption" required>
                            </div>




                            <!--<?php 
                            // if (isset($_GET['success'])) { 
                            //     echo('<div id="alertbox" class="alert alert-success mt-1" role="alert" style="max-width: 500px;  position: relative; left: 50%; transform: translateX(-50%); border-radius: 15px;">
                            //       Task added!
                            //     </div>');
                            //   }
                            ?> -->
                            <?php if (isset($_GET['insertedsuccess'])): ?>
                            <div id="alertbox" class="alert alert-success mt-1" role="alert"
                                style="max-width: 500px;  position: relative; left: 50%; transform: translateX(-50%); border-radius: 15px;">
                                Task added!
                            </div>
                            <?php endif; ?>
                            <?php if (isset($_GET['deleted'])): ?>
                            <div id="alertbox" class="alert alert-danger mt-1" role="alert"
                                style="max-width: 500px;  position: relative; left: 50%; transform: translateX(-50%); border-radius: 15px;">
                                Task deleted!
                            </div>
                            <?php endif; ?>

                        </div>

                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog"
                        aria-labelledby="searchModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">

                                <div class="modal-body">
                                    <form action="" method="GET">
                                        <div class="form-group">
                                            <input type="text" name="search" class="form-control" id="searchInput"
                                                placeholder="Spotlight Search..."><br>

                                        </div>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Search</button>

                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- Modal ended-->

                </div>
            </div>
        </div><br>
        <!-- Table for task info -->
        <table class="table table-info table-hover">
            <thead>
                <tr>
                    <th>Deadline</th>
                    <th>TaskName</th>
                    <th>Caption</th>
                    <th>Date Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
         
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "aiphp";
                $email=$_SESSION['userloggedin'];

                $conn = new mysqli($servername, $username, $password, $dbname);

                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT Deadline,TaskName,Caption,CreatedDate FROM Task WHERE email = '$email' ORDER BY Deadline";

                if(isset($_GET['search'])){
                    $search = $_GET['search'];
                    if($search == ""){
                    $sql = "SELECT Deadline,TaskName,Caption,CreatedDate FROM Task WHERE email = '$email' ORDER BY Deadline";

                    }
                    $sql = "SELECT Deadline,TaskName,Caption,CreatedDate FROM Task WHERE email = '$email' AND TaskName LIKE '%$search%' ORDER BY Deadline";
                }else{
                    $sql = "SELECT Deadline,TaskName,Caption,CreatedDate FROM Task WHERE email = '$email' ORDER BY Deadline";
                }


                $result = $conn->query($sql);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $lname = $row["TaskName"];
                        $cdate = $row["Deadline"];//CreatedDate
                        echo "<tr>";
                        echo "<td class='p-3'>" . $row["Deadline"] . "</td>";
                        echo "<td class='p-3'><a href='../items/index.php?taskname=" . $lname . "&cdate=" . $cdate . "'style='text-decoration:none;color:#2c9c49'>" . $lname . "</a></td>";
                        echo "<td class='p-3'>" . $row["Caption"] . "</td>";
                        echo "<td class='p-3'>" . $row["CreatedDate"] . "</td>";
                        echo "<td class='p-3'> <a class='btn btn-outline-danger' href=" . "dbtasks.php?deltask=" . $lname . "&deldeadline=" . $row["Deadline"] . ">X</a> </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
                ?>
            </tbody>
        </table>

    </div>
    <br><br>

    </div>



    <br><br><br><br>
    <!-- Footer -->
    <footer class="bg-dark text-white p-4">
        <div class="container">
            <div class="row justify-content-center" style="margin: auto;">
                <div class="col-md-12 text-center">
                    <div class="mb-4">
                        <a href="#" class="text-white me-4">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="text-white me-4">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="#" class="text-white me-4">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="text-white me-4">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                    <p class="mb-0">&copy; 2024 OwlWise Inc. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!--JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>


    <script>
    //scrolling up animation
    window.addEventListener('scroll', function() {
        var rows = document.querySelectorAll('.row.g-0');
        var servicesSection = document.getElementById('services-section');
        rows.forEach(function(row) {
            var rowPosition = row.getBoundingClientRect();
            if (rowPosition.top < window.innerHeight) {
                row.classList.add('visible');
            }
        });
        if (servicesSection) {
            var servicesSectionPosition = servicesSection.getBoundingClientRect();
            if (servicesSectionPosition.top < window.innerHeight) {
                servicesSection.classList.add('visible');
            }
        }
    });

    //alertbox disappearance
    function hideAlertBox() {
        //var or const
        var alertBox = document.getElementById("alertbox");
        alertBox.style.display = "none";
    }
    </script>


</body>

</html>