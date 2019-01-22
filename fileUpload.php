<?php
    session_start();
    // include("./config/database.php");
    $currentDir = getcwd();
    $uploads = "upload/";
    $img = $_POST['image'];
    $servername = "localhost";
    $dusername = "root";
    $password = "password";
    $dbname = "camagru";
    $name = "";
    $query = mysqli_query($servername, $dursename, $password, $dbname);
    $fileTmpName = $_FILES['file']['tmp_name'];

    if(isset($_POST['but_upload']))
    {
        $name = $_FILES['file']['name'];
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
       
        // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
       
        // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");
       
        // Check extension
        if( in_array($imageFileType,$extensions_arr) )
        {
            // Insert record
            $image_base64 = base64_encode(file_get_contents($fileTmpName));
            $image = 'data:image/' .$imageFileType. ';base64,' .$image_base64;
            try
            {
                $name = $_SESSION['username'];
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dusername, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $str = "INSERT INTO images (name, image, likes) VALUES ('$name', '$image', 0)";
                $conn->exec($str);
            }
            catch(PDOException $e)
            {
                echo "[INFO] " . $e->getMessage();
            }
            // Upload file
            move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
            header("Location: home.php");
            exit();
        }
    }
?>