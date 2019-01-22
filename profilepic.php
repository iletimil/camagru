<!DOCTYPE html>
<html lang="en-US">
<head>
  <title>Camera</title>
  <link rel="stylesheet" href="web.css">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>

    <form method='POST' action='".setComments($connect)."'>
        <input type='hidden' name='uid' value='Anonymous'>
        <input type='hidden' name='date' value='""'>
        <textarea name='message'></textarea><br>
        <button type='submit' name='commentSubmit'>Comment</button>
        </form>;
        getComments($connect);
        </body>