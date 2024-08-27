<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olypus Gym Club</title>
</head>
<body>
<?php
require_once "Services/mysql_connect_service.php";

function redirectTo($url) {
    header("Location: " . $url);
    exit(); // Ensures the script stops executing after the redirect
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['sign-in'])){
        redirectTo("Create_Account.php");
    }
    elseif (isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) die("All fields are required");

        $sqlComm = "SELECT Password FROM `authentication` WHERE Username = ?;";
        
        if ($statement = $connect->prepare($sqlComm)){
            $statement->bind_param("s", $username);
            $statement->execute();
            $statement->store_result();

            if($statement->num_rows>0){
                $statement->bind_result($hashed_password);
                $statement->fetch();

                if(password_verify($password, $hashed_password)){
                    echo "Access Granted! Welcome!";
                }else{
                    echo "Invalid Username and Password. Please try again.";
                    }
            }
            else{
                echo "Error: Parsing the SQL command";  
            }
            $statement->close();
        }
        else{
            echo "Invalid Username and Password. Please try again.";
        }
        }

        $connect->close();  
    }
?>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter Username or Email">
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"` pattern=".{8,}" placeholder="Eight or more characters">
        
        <button type="submit" name="login">Log in</button>
        <button type="submit" name="sign-in">Sign in</button>
    </form>
</body>
</html>

