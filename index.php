<!DOCTYPE html>
<html lang="en-US">

<head>

    <title>Camagru</title>
    <link rel="stylesheet" href="index.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>

<body>

    <div class="header">
        <a class="camagru" href="index.php">Camagru</a>
        <div class="header-right">
            <a class="info" href="login.php" name='login' id ="text." >Login</a>
            <a class="info" href="signup.php" name='signup'>Sign-up</a>
        </div>
    </div>

    <?php
        session_start();
        $_SESSION['logged_in'] = "no";
        $servername = "localhost";
        $dusername = "root";
        $password = "password";
        $dbname = "camagru";
        try
        {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dusername, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $str = "SELECT * FROM images";
            $res = $conn->query($str);
            echo '<div class="container">';
            while ($new = $res->fetch())
            {
                $img = "<img src=\"".$new['image']."\">";
                echo '<div class="img-con">';
                echo $img;
                echo '</div>';
            }
            echo '</div>';
            echo '<div class="clearfix"></div>';
        }
        catch(PDOException $e)
        {
            echo "[INFO] " . $e->getMessage();
        }
    ?>
</body>
</html>