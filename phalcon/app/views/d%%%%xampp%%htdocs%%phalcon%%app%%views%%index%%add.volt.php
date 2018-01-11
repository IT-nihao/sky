<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<center>
    <h1>完善个人信息</h1>
    <form action="/Index/add" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>电话：</td>
            <td><input type="text" name="tel"></td>
        </tr>
        <tr>
            <td>性别：</td>
            <td><input type="radio" name="sex" value="1">男<input type="radio" name="sex" value="2">女</td>
        </tr>
        <tr>
            <td>出生日期：</td>
            <td><input type="date" name="birthday"></td>
        </tr>
        <tr>
            <td>家庭住址：</td>
            <td><input type="text" name="address"></td>
        </tr>
        <tr>
            <td>上传头像</td>
            <td><input type="file" name="file"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="提交"></td>
        </tr>
    </table>
    </form>
</center>
</body>
</html>