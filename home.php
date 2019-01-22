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
        <a class="camagru" href="home.php">Camagru</a>
        <div class="header-right">
            <a class="info" href="index.php" name='logout'>Logout</a>
            <a class="info" href="profile.php" name='signup'>Profile</a>
            <a class="info" href="webcam/web.php" name='upload' >Upload</a>
        </div>
    </div>

    <?php
        session_start();
        $servername = "localhost";
        $dusername = "root";
        $password = "password";
        $dbname = "camagru";
        if ($_POST['logout'])
        {
            $_SESSION['logged_in'] = 'no';
            session_destroy();
        }
        if ($_SESSION['logged_in'] == 'yes')
        {
            try
            {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dusername, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $str = "SELECT * FROM images";
                $res = $conn->query($str);
                echo '<div class="container">';
                while ($new = $res->fetch())
                {
                    $image = $new['image'];
                    $link = 'picture.php?img='.$new["id"].'&user='.$new['name'];
                    $img = "<a href=$link><img src=\"".$image."\"></a>";
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
            $conn = null;
        }
        ?>
</body>
</html>