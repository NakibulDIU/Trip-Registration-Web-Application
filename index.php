<?php
$insert = false;

if (isset($_POST['name'])) {
    // Database connection
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "diu_trip";

    $con = new mysqli($server, $username, $password, $database);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Collect post variables safely
    $name   = $_POST['name'];
    $age    = $_POST['age'];
    $gender = $_POST['gender'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $dep    = $_POST['dep'];
    $desc   = $_POST['desc'];

    // Use prepared statement for security
    $sql = $con->prepare("INSERT INTO trip (name, age, gender, email, phone, dep, other, dt) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp())");
    $sql->bind_param("sisssss", $name, $age, $gender, $email, $phone, $dep, $desc);

    if ($sql->execute()) {
        $insert = true;
    } else {
        echo "Error: " . $sql->error;
    }

    $sql->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Travel Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <img class="bg" src="/img/campus1.jpg" alt="DIU">
    <div class="container">
        <h2>Welcome to DIU to Kashmir trip form</h2>
        <p>Enter your details and submit this form to confirm your participation in the trip</p>

        <form action="index.php" method="post">
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="number" name="age" placeholder="Enter your age">
            <input type="text" name="gender" placeholder="Enter your gender">
            <input type="email" name="email" placeholder="Enter your email">
            <input type="text" name="phone" placeholder="Enter your phone number" required>
            <input type="text" name="dep" placeholder="Your Department and batch no" required>
            <textarea name="desc" cols="30" rows="5" placeholder="Enter your information here"></textarea>
            <button class="btn">Submit</button>
        </form>

        <?php if ($insert): ?>
            <p class="submitmsg">✅ Thanks for submitting your form. Your participation is confirmed!</p>
        <?php endif; ?>
    </div>
</body>
</html>
