<?php
    session_start();
    date_default_timezone_set('Africa/CapeTown');
    include 'comment.inc.php';
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
  <title>Camera</title>
  <link rel="stylesheet" href="web.css">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
    <div class="header">
        <a class="camagru" href="../home.php">Camagru</a>
        <div class="header-right">
          <a class="info" href="../index.php" name='logout'>Logout</a>
          <a class="info" href="../profile.php" name='profile'>Profile</a>
        </div>
    </div>

  <div class="camera">
  <form method="POST">
    <video id="video" width="640" height="480" autoplay="true"></video>
    <canvas id="canvas" width="640" height="480"></canvas>
    <input type="hidden" name="image" id="img">
    <canvas id="canvas2" width="640" height="480"></canvas>
    <a><img src="../images/camera_icon.png" alt="capture" id="snap"></a>
    <button type="Submit" class="btn" name="delete">Delete</button>
    <button type="Submit" class="btn" name="save">Upload</button>
  </form>
    <?php
        if (isset($_POST['delete']))
        {
          header('Location: web.php');
        }
        if (isset($_POST['save']))
        {
          if ($_SESSION['logged_in'] == 'no')
          {
            header('Location: ../login.php');
          }
          else
          {
            $img = $_POST['image'];
            $servername = "localhost";
            $dusername = "root";
            $password = "password";
            $dbname = "camagru";
            $name = $_SESSION['username'];
            try
            {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dusername, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $str = "INSERT INTO images (image, name, likes) VALUES ('$img', '$name', 0)";
                $conn->exec($str);
                header('Refresh:2 ; url="../home.php"');
            }
            catch(PDOException $e)
            {
                echo "[INFO] " . $e->getMessage();
            }
          }
        }
    ?>
  </div>

  <div id="upload">
    <form action="../fileUpload.php" method="POST" enctype="multipart/form-data">
        <label class="label">Upload a file:</label>
        <input type="file" name="file" class="btn2">
        <input type="submit" name="but_upload" class="btn2" value="Upload">
    </form>

  </div>

   <div class="filter">
    <button onclick="add_filters(0);"><img class="stickers" name="kakashi" src="../stickers/kakashi.png" alt="kakashi.png"></button>
    <button onclick="add_filters(1);"><img class="stickers" name="titan" src="../stickers/titan.png" alt="titan.png"></button>
    <button onclick="add_filters(2);"><img class="stickers" name="vegeta" src="../stickers/vegeta.png" alt="vegeta.png"></button>
    <button onclick="add_filters(3);"><img class="stickers" name="wall" src="../stickers/wall.png" alt="wall.png"></button>
    <button onclick="add_filters(4);"><img class="stickers" name="kagura" src="../stickers/kagura.png" alt="kagura.png"></button>
  </div>
  <script>
    var video = document.getElementById('video');
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var canvas2 = document.getElementById('canvas2');
    var context2 = canvas2.getContext('2d');
    var stickers = document.querySelectorAll( '.stickers' );

    //go thru every sticker and assign event listener
    console.log(stickers[1]);
    stickers.forEach( function( item ){
        item.onclick = function(){
            console.log( item );
        }
    })

    // Get access to the camera!
    if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
    {
      navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream)
      {
          video.srcObject = stream;
      });
    }

    var filters = new Array;
    filters[0] = "../stickers/kakashi.png";
    filters[1] = "../stickers/titan.png";
    filters[2] = "../stickers/vegeta.png";
    filters[3] = "../stickers/wall.png";
    filters[4] = "../stickers/kagura.png";

    function  add_filters(e)
    {
        var image = new Image();
        image.src = filters[e];
        context.drawImage(image,0,0,640,480);
    }

    // Trigger photo take
    document.getElementById("snap").addEventListener("click", function() {
      context2.drawImage(video, 0, 0, 640, 480);
        context2.drawImage(canvas, 0, 0, 640, 480);
        document.getElementById("img").value = canvas2.toDataURL();
    });
  </script>
</body>
</html>