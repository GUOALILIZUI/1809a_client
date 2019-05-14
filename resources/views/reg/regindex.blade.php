<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
</head>
<body>
<form action="/regInfo" method="post">
    <p></p>
    <p>username
        <input type="text" name="user_name">
    </p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        email
        <input type="text" name="email">
    </p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        密码
        <input type="password" name="pass1">
    </p>

    <p>&nbsp;
        确认密码
        <input type="password" name="pass2">
    </p>

    <p>
        <input type="submit" value="REGISTER">
    </p>
</form>
</body>
</html>