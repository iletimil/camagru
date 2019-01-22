<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Settings</title>
        <link rel="stylesheet" href="login.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
    <center><h1><a href="home.php">Camagru</h1></a></center>
    <div>
        <center><h2>Settings</h2></center>
        <form class="form" method="post">
            <label>New Username:</label><br>
            <input type="text" name="username" class="inputvalues" placeholder="Enter new username"/><br>
            <label>New Email:</label><br>
            <input type="text" name="email" class="inputvalues" placeholder="Enter new username"/><br>
            <label>New Password:</label><br>
            <input type="password" name="password" class="inputvalues" placeholder="Enter new password"/><br>
            <label>Confirm New Password:</label><br>
            <input type="password" name="cpassword" class="inputvalues" placeholder="Confirm new password"/><br>
            <label>Please choose notification preference:</label><br>
            <label>Yes:</label><input type="checkbox" name="yesnotify" value="yes"/><br>
            <label>No :</label><input type="checkbox" name="nonotify" value="no"/><br>
            <button type="submit" id="login_btn" name="update">Update</button>
            <button type="submit" id="login_btn" name="delete">Delete account</button>
        </form>
        <?php
        session_start();
        if (isset($_POST['yesnotify']) || isset($_POST['nonotify']))
        {
            $servername = "localhost";
            $dusername = "root";
            $password = "password";
            $dbname = "camagru";
            $DB_DSN='mysql:host=localhost;dbname=camagru';
            try
            {
                $conn = new PDO($DB_DSN, $dusername, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $str = "SELECT * FROM users";
                $res = $conn->query($str);
                while ($new = $res->fetch())
                {
                    if ($new['username'] == $_SESSION['username'])
                    {
                        $id = $new['user_id'];
                    }
                }
            }
            catch(PDOException $e)
            {
                echo "[INFO] " . $e->getMessage();
            }
            if ($_POST['yesnotify'] == yes)
            {
                try
                {
                    $conn = new PDO($DB_DSN, $dusername, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $str = "UPDATE users SET notify='yes' WHERE user_id=$id";
                    $res = $conn->exec($str);
                }
                catch(PDOException $e)
                {
                    echo "[INFO] " . $e->getMessage();
                }
            }
            if ($_POST['nonotify'] == no)
            {
                try
                {
                    $conn = new PDO($DB_DSN, $dusername, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $str = "UPDATE users SET notify='no' WHERE user_id=$id";
                    $res = $conn->exec($str);
                }
                catch(PDOException $e)
                {
                    echo "[INFO] " . $e->getMessage();
                }
            }
        }
        if (isset($_POST['delete']))
        {
            $servername = "localhost";
            $dusername = "root";
            $password = "password";
            $dbname = "camagru";
            $DB_DSN='mysql:host=localhost;dbname=camagru';
            try
            {
                $conn = new PDO($DB_DSN, $dusername, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $str = "SELECT * FROM users";
                $res = $conn->query($str);
                while ($new = $res->fetch())
                {
                    if ($_SESSION['username'] == $new['username'])
                    {
                        $id = $new['user_id'];
                    }
                }
                $del = "DELETE FROM users WHERE user_id=$id";
                $conn->exec($del);
                header('Refresh:2 ; url=index.php');
                echo "ACCOUNT DELETED SUCCESSFULLY";
            }
            catch(PDOException $e)
            {
                echo "[INFO] " . $e->getMessage() . "<br>";
            }
        }
        function updateInfo($valueName, $value, $id)
        {
            $servername = "localhost";
            $dusername = "root";
            $password = "password";
            $dbname = "camagru";
            $DB_DSN='mysql:host=localhost;dbname=camagru';
            if ($valueName == 'email' || $valueName == 'username')
            {
                try
                {
                    $conn = new PDO($DB_DSN, $dusername, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $str = "SELECT * FROM users";
                    $res = $conn->query($str);
                    $u = 0;
                    while ($new = $res->fetch())
                    {
                        if ($value == $new['username'])
                        {
                            echo "Username " . $username . " already taken<br>";
                            $u = 1;
                        }
                        if ($value == $new['email'])
                        {
                            echo "Email address " . $email . " already used<br>";
                            $u = 1;
                        }
                    }
                    if ($u == 0)
                    {
                        if ($valueName == 'username')
                        {
                            $add = "UPDATE users SET username='$value' WHERE user_id='$id'";
                            if ($conn->query($add))
                            {
                                echo "Username updated successfully<br>";
                            }
                        }
                        if ($valueName == 'email')
                        {
                            $add = "UPDATE users SET email='$value' WHERE user_id='$id'";
                            if ($conn->query($add))
                            {
                                echo "Email updated successfully<br>";
                            }
                        }
                    }
                }
                catch(PDOException $e)
                {
                    echo "[INFO] " . $e->getMessage() . "<br>";
                }
            }
            if ($valueName == 'password')
            {
                try
                {
                    $conn = new PDO($DB_DSN, $dusername, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $add = "UPDATE users SET password='$value' WHERE user_id='$id'";
                    if ($conn->query($add))
                    {
                        echo "Password updated successfully<br>";
                    }
                }
                catch(PDOException $e)
                {
                    echo "[INFO] " . $e->getMesssage();
                }
            }
        }
        if (isset($_POST['update']))
        {
            $id = $_SESSION['id'];
            if (!empty($_POST['username']))
            {
                $value = $_POST['username'];
                updateInfo('username', $value, $id);
            }
            if (!empty($_POST['email']))
            {
                $value = $_POST['email'];
                updateInfo('email', $value, $id);
            }
            if (!empty($_POST['password']))
            {
                if (empty($_POST['cpassword']))
                {
                    echo "Please confrim password";
                }
                else
                {
                    $pass = $_POST['password'];
                    $pw = $_POST['cpassword'];
                    $hash = password_hash($pass, PASSWORD_DEFAULT);
                    if (ctype_lower($pw) == TRUE)
                    {
                        echo "Password is too weak, add some symbols, numbers, you know? Stuff like that";
                    }
                    else
                    {
                        if (password_verify($pw, $hash) == TRUE)
                        {
                            $value = $hash;
                            updateInfo('password', $value, $id);
                        }
                        else
                        {
                            echo "Passwords do not match";
                        }
                    }
                }
            }
        }
        $conn = null;
    ?>
    </div>
</body>
</html>