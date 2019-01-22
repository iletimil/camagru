<?php
include 'database.php';
/*
Create connection
*/
try 
{
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);;
    echo "[INFO] Connection successful<br>";
}
catch(PDOException $e)
{
    echo "[INFO] " . $e->getMessage() . "<br>";
}
/* create databse */
try
{
    $sql = "CREATE DATABASE $DB_NAME";
    $conn->exec($sql);
    echo "[INFO] Database creation succesful<br>";
}
catch(PDOException $e)
{
    echo "[INFO] Database creation failed " . $e->getMessage() . "<br>";
}
/* Create tables */
try
{
    $conn = new PDO("$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $users = "CREATE TABLE IF NOT EXISTS users(
        user_id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, 
        name TEXT NOT NULL, surname TEXT NOT NULL, username TEXT NOT NULL,
        email TEXT NOT NULL, password TEXT NOT NULL, verified TEXT NOT NULL, notify TEXT NOT NULL)";
    $conn->exec($users);
    /* Image table */
    $images = "CREATE TABLE IF NOT EXISTS images (  
        `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `name` varchar(200) NOT NULL,
        `image` longtext NOT NULL,
        `likes` int(11) NOT NULL)
        ENGINE=InnoDB DEFAULT CHARSET=latin1";
    $conn->exec($images);
    /*Comments table */
    $comments = "CREATE TABLE IF NOT EXISTS comments (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        image_id int(11) NOT NULL,
        username VARCHAR(128) NOT NULL,
        date VARCHAR(128) NOT NULL,
        message TEXT NOT NULL)";
    $conn->exec($comments);
    header('refresh:1; url="../index.php"');
    echo "[INFO] User table created successfully<br>";
    echo "[INFO] Image table created successfully<br>";
    echo "[INFO] Comment table created successfully<br>";
}
catch(PDOException $e)
{
    echo "[INFO] " . $e->getMessage();
}

$conn = null;
?>