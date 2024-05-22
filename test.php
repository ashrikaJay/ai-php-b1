<?php
/* 
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aiphp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmedPassword'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$contactNumber = $_POST['phone'];
$birthday = $_POST['birthday'];
$gender = $_POST['gender'];
$salary = $_POST['salary'];

// Check if the email already exists in the database
$checkSql = "SELECT email FROM Employees WHERE email = ?";
$stmt = $conn->prepare($checkSql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$rowCount = $result->num_rows;
$stmt->close();

if ($rowCount > 0) {
    // Email already exists, display error message
    $errorMessage = "User already exists";
} else {
    // Email does not exist, proceed with registration
    try {
        $sql = "INSERT INTO Employees (email, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->close();

        // Registration successful, redirect or display appropriate message
        header("Location: registration_success.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === '23000' && $e->getMessage() === "Duplicate entry '{$email}' for key 'PRIMARY'") {
            // Duplicate entry error, display error message
            $errorMessage = "User already exists";
        } else {
            // Other SQL error, re-throw the exception
            throw $e;
        }
    }
}

$conn->close();
//if doesnt work add this 
// Define and initialize the $getMessage variable
$getMessage = function () use ($errorMessage) {
    return $errorMessage ?? null;
};
// Insert data into the database
$sql = "INSERT INTO Employee (Email, Password, FirstName, LastName, Phone, DateOfBirth, Gender, Salary)
        VALUES ('$email', '$confirmPassword', '$firstName', '$lastName', '$contactNumber', '$birthday', '$gender', '$salary')";
        
            $sql = "INSERT INTO Employee (Email, Password, FirstName, LastName, Phone, DateOfBirth, Gender, Salary)
    VALUES ('$email', '$confirmPassword', '$firstName', '$lastName', '$contactNumber', '$birthday', '$gender', '$salary')";

?>