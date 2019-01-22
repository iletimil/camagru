<!DOCTYPE html>
<html>
    <head>
        <title>Forgot password</title>
        <link rel="stylesheet" href="login.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
    <center><h1>Camagru</h1></center>
    <div>
        <center><h2>Forgot password</h2></center>
        <form class="form" action="forgotpw.php" method="post">
            <label>Email:</label><br>
            <input type="text" name="email" class="inputvalues" placeholder="Confirm email address"/><br>
            <button id="login_btn" type="submit" name="send">Send email</button>
        </form>
        <?php
        session_start();
        $servername = "localhost";
        $dusername = "root";
        $password = "password";
        $dbname = "camagru";
        $DB_DSN='mysql:host=localhost;dbname=camagru';
        if (isset($_POST['send']))
        {
            if (empty($_POST['email']))
            {
                echo "Please enter email address";
            }
            else
            {
                try
                {
                    $conn = new PDO($DB_DSN, $dusername, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $qry = "SELECT username, email FROM users";
                    $res = $conn->query($qry);
                    while ($new = $res->fetch())
                    {
                        if ($new['email'] == $_POST['email'])
                        {
                            $email = $new['email'];
                            $username = $new['username'];
                        }
                    }
                    if ($email == null)
                    {
                        echo "Please use the email address used when you registered";
                    }
                    else
                    {
                        $num = rand(100000, 999999);
                        $uniquelink = "http://localhost:8080/camagru/changepw.php";
                        $subject = "Camagru password change";
                        $body = "Please click the link below and enter the code: " . $num . "\n" . $uniquelink;
                        $headers = "From: noreply@camagru.com";
                        $_SESSION['code'] = $num;
                        $_SESSION['username'] = $username;
                        mail ($email, $subject, $body, $headers);
                        echo "Password change email sent to " . $email . "<br>";
                    }
                }
                catch(PDOException $e)
                {
                    echo "Connection failure " . $e->getMessage();
                }
            }
        }
        $conn = null;
    ?>
    </div>
</body>
</html>