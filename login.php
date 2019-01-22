<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="login.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
    <center><h1>Camagru</h1></center>
    <div>
        <center><h2>Login</h2></center>
        <form class="form" action="login.php" method="post">
            <label>Username:</label><br>
            <input type="text" name="username" class="inputvalues" placeholder="Enter a username"/><br>
            <label>Password:</label><br>
            <input type="password" name="password" class="inputvalues" placeholder="Enter a password"/><br>
            <button type="submit" id="login_btn" name="login">Login</button>
            <a href="forgotpw.php">Forgot your password?</a>
            <a href="signup.php">Sign-up</a>
        </form>
        <?php
        $servername = "localhost";
        $dusername = "root";
        $password = "password";
        $dbname = "camagru";
        $DB_DSN='mysql:host=localhost;dbname=camagru';
        if (isset($_POST['login']))
        {
            if (empty($_POST['username']) || empty($_POST['password']))
            {
                echo "Empty field <br>";
            }
            else
            {
                $username = $_POST['username'];
                $password_1 = $_POST['password'];
                try
                {
                    $conn = new PDO($DB_DSN, $dusername, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $qry = "SELECT user_id, username, password, verified FROM users";
                    $res = $conn->query($qry);
                    while ($new = $res->fetch())
                    {
                        if ($new['username'] == $username)
                        {
                            $un = $new['username'];
                            $pw = $new['password'];
                            $ver = $new['verified'];
                            $id = $new['user_id'];
                        }
                    }
                    if ($ver == 'yes')
                    {
                        if (strcmp($username, $un) == 0)
                        {
                            if (password_verify($password_1, $pw) == TRUE)
                            {
                                $_SESSION['username'] = $username;
                                $_SESSION['logged_in'] = "yes";
                                $_SESSION['id'] = $id;
                                header('Location: http://localhost:8080/camagru/home.php');
                            }
                            else
                            {
                                echo "Incorrect password entered";
                            }
                        }
                        else
                        {
                            echo "User ".$username." not found";
                        }
                    }
                    else
                    {
                        header('refresh:2 ;url=index.php');
                        echo "User " . $username . " not verified.";
                    }
                }
                catch (PDOException $e)
                {
                    echo "Connect Failure: " . $e->getMessage();
                }
            }
        }
        $conn = null;
    ?>
    </div>
</body>
</html>