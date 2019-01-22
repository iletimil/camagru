<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Camagru</title>
    <link rel="stylesheet" href="picture.css">
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


            <?php
                session_start();
                include 'webcam/comment.inc.php';
                $servername = "localhost";
                $dusername = "root";
                $password = "password";
                $dbname = "camagru";
                $DB_DSN='mysql:host=localhost;dbname=camagru';
                $id = $_GET['img'];
                $user = $_GET['user'];
                try
                {
                    $conn = new PDO($DB_DSN, $dusername, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $str = "SELECT * FROM images";
                    $res = $conn->query($str);
                    echo '<div class="container">';
                    while ($new = $res->fetch())
                    {
                        if ($id == $new['id'])
                        {
                            $img = "<img src=\"".$new['image']."\">";
                            echo '<div class="img-con">';
                            echo $img;
                            echo '<form method="post">
                            <button type="submit" class="btn" name="like">Like</button>
                            </form>';
                            echo "<p>".$new['likes']."</p>";
                            echo '</div>';
                        }
                    }

                    echo '<div class="com-con">';
                    echo "<form class='comment' method='POST' action='".setComments($conn, $user, $id)."'>'
                    <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                    <textarea name='message'></textarea><br>
                    <button class='btn' type='submit' name='commentSubmit'>Comment</button>
                    </form>";

                    if (isset($_POST['commentSubmit']))
                    {
                        try
                        {
                            $servername = "localhost";
                            $dusername = "root";
                            $password = "password";
                            $dbname = "camagru";
                            $DB_DSN='mysql:host=localhost;dbname=camagru';
                            $conn = new PDO($DB_DSN, $dusername, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $str = "SELECT * FROM users";
                            $res = $conn->query($str);
                            while ($new = $res->fetch())
                            {
                                if ($user == $new['username'])
                                {
                                    $email = $new['email'];
                                    $notify = $new['notify'];
                                }
                            }
                            if ($notify == 'yes')
                            {
                                $subject = "Someone commented on your image!";
                                $body = $_SESSION['username'] . " commented on one of your images, you're basically famous now. Please click the following link to log in and see what they said.
http://localhost:8080/camagru/login.php
You can go to your profile page, click on settings and tick the 'no' box to stop recieving emails about irrelevent people commenting on your shitty pictures.";
                                $headers = "From: noreply@camagru.com";
                                mail ($email, $subject, $body, $headers);
                                }
                        }
                        catch(PDOException $e)
                        {
                            echo "[INFO] " . $e->getMessage();
                        }
                    }
                    $str = "SELECT * FROM comments";
                    $res = $conn->query($str);
                    echo '<div class="com">';
                    while ($new = $res->fetch())
                    {
                        if ($id == $new['image_id'] && $user == $new['username'])
                        {
                            echo $new['message'] . "<br>";
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                }
                catch(PDOException $e)
                {
                    echo "[INFO] " . $e->getMessage();
                }
                if (isset($_POST['like']))
                {
                    try
                    {
                        $conn = new PDO($DB_DSN, $dusername, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $str = "SELECT * FROM images";
                        $res = $conn->query($str);
                        while ($new = $res->fetch())
                        {
                            if ($id == $new['id'])
                            {
                                $likes = $new['likes'];
                            }
                        }
                        $likes++;
                        $qry = "UPDATE images SET likes=$likes WHERE id=$id";
                        $conn->exec($qry);
                    }
                    catch (PDOException $e)
                    {
                        echo "[INFO] " . $e->getMessage();
                    }
                }
            ?>
</body>
</html>