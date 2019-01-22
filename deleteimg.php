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
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="column">
            <form class="form" method="post">
                <button type="Submit" class="btn btn-success" name="delete">Delete</button>
            </form>
            <?php
                session_start();
                $servername = "localhost";
                $dusername = "root";
                $password = "password";
                $dbname = "camagru";
                $DB_DSN='mysql:host=localhost;dbname=camagru';
                if ($_POST['logout'])
                {
                    $_SESSION['logged_in'] = 'no';
                    session_destroy();
                    header('Location: index.php');
                }
                $id = $_GET['img'];
                if(isset($_POST['delete']))
                {
                    try
                    {
                        $conn = new PDO($DB_DSN, $dusername, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $del = "DELETE FROM images WHERE id=$id";
                        $conn->exec($del);
                        header('Refresh:1 ; url=profile.php');
                        echo "IMAGE DELETED";
                    }
                    catch(PDOException $e)
                    {
                        echo "[INFO] " . $e->getMessage() . "<br>";
                    }
                }
                try
                {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dusername, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $str = "SELECT * FROM images";
                    $res = $conn->query($str);
                    while ($new = $res->fetch())
                    {
                        if ($new['id'] == $id)
                        {
                            $fig = "<figure>";
                            $img = "<a href=$link><img src=\"".$new['image']."\"></a>";
                            $capt = "<figcaption>"."</figcaption>";
                            $cl = "</figure>";
                            echo $fig.$img.$capt.$cl;
                        }
                    }
                }
                catch(PDOException $e)
                {
                    echo "[INFO] " . $e->getMessage();
                }
            ?>
            </div>
        </div>
    </div>
</body>
</html>