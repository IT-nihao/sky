<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>

    table{
       margin:0 auto;
    }


</style>
<body>
        <h1 style="text-align:center">登陆界面</h1>

<form action="/Signup/index" method="post">
    <table>
        <tr>
            <td>账户名称：</td>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <td>密码：</td>
            <td><input type="password" name="pwd"></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="check">七天免登陆</td>
            <td><a href="/Signup/register">注册</a></td>
            <td><input type="submit" value="登陆"></td>
        </tr>

    </table>
</form>
</body>
</html>
<!---->
<!--//echo "<h1>Hello!</h1>";-->
<!--////echo $_SERVER['REQUEST_URI'];die;-->
<!--//echo $this->tag->linkTo("signup", "Sign Up Here!");-->
<!--//echo $this->tag->linkTo("signup", "注册!");