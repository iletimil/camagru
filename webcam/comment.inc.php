<?php
    function setComments($conn, $username, $id)
    {
        if (isset($_POST['commentSubmit']))
        {
            $date = $_POST['date'];
            $message = $_POST['message'];
            $sql = "INSERT INTO comments(image_id, username, date, message) VALUES ('$id', '$username','$date', '$message')";
            $conn->exec($sql);
        }
    }

    function getComments($connect)
    {
        $sql = "SELECT * FROM comments WHERE id=image_id";
        $result = mysqli_query($connect,$sql);
        if (mysqli_fetch_assoc($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                echo $row['uid']. "<br>";
                echo $row['message']. "<br>";
            }
        }
    }
?>