<?php
    session_start();
    $img = $_POST['image'];
    $servername = "localhost";
    $dusername = "root";
    $password = "password";
    $dbname = "camagru";
    $name = "";
    try
    {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dusername, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $str = "INSERT INTO images (image, name) VALUES ('$img', '$name')";
        $conn->exec($str);
        header('Location: web.php');
    }
    catch(PDOException $e)
    {
        echo "[INFO] " . $e->getMessage();
    }
?>