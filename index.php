<?php
try {
    // PDO Connection
    $pdoConnection = new PDO("sqlsrv:server = tcp:ghaliaserver.database.windows.net,1433; Database = ghaliaDB", "ghalia", "sarraBHS@123");
    $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $email = $_POST["email"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Hash the password (for security)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the SQL statement to insert data
        $sql = "INSERT INTO Users (Email, FirstName, LastName, Username, Password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdoConnection->prepare($sql);
        $stmt->execute([$email, $firstName, $lastName, $username, $hashedPassword]);

        // Redirect to a success page or do further processing
        header("Location: success_page.php");
        exit();
    }
} catch (PDOException $e) {
    // Log the detailed error for debugging purposes
    error_log($e->getMessage());

    // Display a user-friendly message
    print("Error connecting to the database. Please try again later.");
    die();
}
?>