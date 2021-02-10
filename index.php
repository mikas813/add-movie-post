<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.muicss.com/mui-0.10.3/css/mui.min.css">
    <title>Document</title>
</head>
<body>

<div class="mui-container">
    <form class="mui-form" action="addpost.php" method="post">
        <legend>Title</legend>
        <br>
        <div class="mui-textfield">
            <input type="text" class="input" id="name" name="name" placeholder="Movie name (original)">
        </div>
        <br>

        <button class="find mui-btn mui-btn--raised">Find</button>

        <div class="wrap"></div>

        <button class="submit mui-btn mui-btn--raised">Add post</button>


        <br>
    </form>
</div>

<script type="text/javascript" src="https://unpkg.com/movie-trailer"></script>
<script src="index.js"></script>
</body>
</html>