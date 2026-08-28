<?php
$config = require __DIR__ . '/../helpers/config.php';
$host = $config['db']['host'];
$user = $config['db']['user'];
$password = $config['db']['password'];
$dbname = $config['db']['dbname'];
$connect = mysqli_connect($host, $user, $password, $dbname);

// Check the database connection
if(!$connect) {
    die("<div class='query' id='error'>Помилка підключення до Бази Даних</div>");
}

// Add a new record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Check if the login already exists in the database
    // stmt - short for "statement", a variable representing a prepared SQL statement
    // It is used for secure interaction with the database and helps prevent SQL Injection attacks
    $stmt = $connect->prepare("SELECT * FROM accounts WHERE login = ?");

    // "s" - string; $login is inserted instead of "?" in prepare() as a string
    $stmt->bind_param("s", $login);

    // Execute the query
    $stmt->execute();

    // Get the query result as an object
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<div class='query' id='error'>Упс! Користувач з таким логіном вже існує</div>";
    } elseif (strlen($password) < 6) {
        echo "<div class='query' id='error'>Слабкий пароль</div>";
    } else {
        // Hash the password using the bcrypt algorithm with the PASSWORD_DEFAULT parameter
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $passwordLength = strlen($password);

        $stmt = $connect->prepare("INSERT INTO accounts (login, password, password_length, time_update) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $login, $hashedPassword, $passwordLength);
        $stmt->execute();

        // Close $stmt
        $stmt->close();

        echo "<div class='query' id='success'>Користувача успішно додано!</div>";
    }
}

// Delete a record
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];

    $stmt = $connect->prepare("DELETE FROM accounts WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Edit a record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_edit'])) {
    $user_id = $_POST['user_id']; // Get user_id from the form
    $login = $_POST['login'];
    $old_password = $_POST['old_password'];
    $password = $_POST['password'];

    // Get the current password hash and login from the database for this user
    $stmt = $connect->prepare("SELECT login, password FROM accounts WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the user is found, verify the old password
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Get the result from the database

        // Verify the old password
        if (!password_verify($old_password, $row['password'])) {
            echo "<div class='query' id='error'>Невірний пароль</div>";
        } elseif (strlen($password) < 6) {
            echo "<div class='query' id='error'>Слабкий пароль</div>";
        } else {
            // Check if the login is already used by another user
            $stmt = $connect->prepare("SELECT * FROM accounts WHERE login = ? AND user_id != ?");
            $stmt->bind_param("si", $login, $user_id);
            $stmt->execute();
            $login_check = $stmt->get_result();

            if ($login_check->num_rows > 0) {
                echo "<div class='query' id='error'>Такий логін вже використовується іншим користувачем</div>";
            } else {
                // Update the user's data
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $passwordLength = strlen($password);

                $stmt = $connect->prepare("UPDATE accounts SET login = ?, password = ?, password_length = ?, time_update = NOW() WHERE user_id = ?");
                $stmt->bind_param("ssii", $login, $hashedPassword, $passwordLength, $user_id);
                $stmt->execute();
                $stmt->close();

                echo "<div class='query' id='success'>Запис успішно оновлено!</div>";
            }
        }
    } else {
        echo "<div class='query' id='error'>Користувача не знайдено</div>";
    }
}

// Get data from the database
$result = $connect->query("SELECT * FROM accounts");
?>
