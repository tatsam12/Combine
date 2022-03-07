<?php

/*require_once() statement can be used to include
a php file in another one, when you may need to
include the called file more than once*/
require_once "config.php";


#initialization of the variable with empty string.
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

#$_SERVER['REQUEST_METHOD'] == 'POST'
# determines whether the request was a POST or GET request.
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    }
    //IF not empty proceed forward.
    else {
        # mysqli_prepare Prepares the SQL query, and returns a statement
        #handle to be used for further operations on the statement.
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                    echo $username_err;
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password cannot be less than 5 characters";
    } else {
        $password = trim($_POST['password']);
    }

// Check for confirm password field
    if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
        $password_err = "Passwords should match";
    }


// If there were no errors, go ahead and insert into the database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set these parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
            } else {
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}

?>


<!doctype html>
<html lang="en">
<head>
</head>
<body>
<h1>Php Login System</h1>
<a href="register.php">Register</a>
<a href="login.php">Login</a>
<a href = "logout.php">logout</a>

<div class="container mt-4">
    <hr>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Email">

        <label for="password">Password:</label>
        <input type="password"  name="password" id="password" placeholder="Password">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password"  name="confirm_password" id="confirm_password"
               placeholder="Confirm Password">

        <button type="submit" >Sign in</button>
    </form>
</div>
</body>
</html>