<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Change Password</title>
        <link rel="stylesheet" href="login.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
    <center><h1>Camagru</h1></center>
    <div>
        <center><h2>Forgot password</h2></center>
        <form class="form" method="post">
            <label>Username:</label><br>
            <input type="text" name="username" class="inputvalues" placeholder="Enter username"/><br>
            <label>Unique code:</label><br>
            <input type="text" name="ucode" class="inputvalues" placeholder="Enter code"/><br>
            <label>New password:</label><br>
            <input type="password" name="password" class="inputvalues" placeholder="Enter new password"/><br>
            <label>Confirm password:</label><br>
            <input type="password" name="cpassword" class="inputvalues" placeholder="Confirm new password"/><br>
            <button type="submit" id="login_btn" name="change">Change password</button>
        </form>
        <?php
        session_start();
        $servername = "localhost";
        $dusername = "root";
        $password = "password";
        $dbname = "camagru";
        $DB_DSN='mysql:host=localhost;dbname=camagru';
        if (isset($_POST['change']))
        {
            if (empty($_POST['password']) || empty($_POST['cpassword']) || empty($_POST['ucode']) || empty($_POST['username']))
            {
                echo "Empty field <br>";
            }
            else
            {
                $pw = $_POST['cpassword'];
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                try
                {
                    $conn = new PDO($DB_DSN, $dusername, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    if (password_verify($pw, $hash) == TRUE)
                    {
                        if ($_POST['ucode'] == $_SESSION['code'] && $_POST['username'] == $_SESSION['username'])
                        {
                            $username = $_POST['username'];
                            $check = "SELECT username, user_id, email FROM users";
                            $res = $conn->query($check);
                            while ($new = $res->fetch())
                            {
                                if ($new['username'] == $username)
                                {
                                    $id = $new['user_id'];
                                }
                            }
                            $qry = "UPDATE users SET password='$hash' WHERE user_id='$id'";
                            $conn->query($qry);
                            header('refresh:2 ; url=login.php');
                            echo "Password changed successfully<br>";
                        }
                        else
                        {
                            echo "Incorrect code or username<br>";
                        }
                    }
                    else
                    {
                        echo "Passwords do not match<br>";
                    }
                }
                catch(PDOException $e)
                {
                    echo "[INFO] " . $e->getMessage();
                }
            }
        }
    ?>
    </div>
</body>
</html>