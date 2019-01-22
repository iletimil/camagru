<?php
    session_start();
    $key = $_GET['key'];
    $servername = "localhost";
    $dusername = "root";
    $password = "password";
    $dbname = "camagru";
    $DB_DSN='mysql:host=localhost;dbname=camagru';
    if(password_verify($_SESSION['username'], $key))
    {
        $username = $_SESSION['username'];
        try
        {
            $conn = new PDO($DB_DSN, $dusername, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $qry = "SELECT username, user_id FROM users";
            $res = $conn->query($qry);
            while ($new = $res->fetch())
            {
                if ($new['username'] == $username)
                {
                    $id = $new['user_id'];
                }
            }
            $add = "UPDATE users SET verified='yes' WHERE user_id=$id";
            if ($conn->query($add))
            {
                echo "Account information updated <br>";
            }
            else
            {
                $_SESSION['verified'] = "no";
            }
            $_SESSION['logged_in'] = "yes";
            header('refresh:2; url="login.php"');
            echo "User ". $_SESSION['username'] . " successfully registered <br>";
        }
        catch (PDOException $e)
        {
            echo "Connect Failure: " . $e->getMessage();
        }
    }
    $conn = null;
?>