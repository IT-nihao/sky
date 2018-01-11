<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php $this->assets->outputJs() ?>
</head>
<body>
<center>
    <h1>完善个人信息</h1>
    <form action="/Index/update" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ arr.id }}">
    <table border='1'>
        <tr>
            <td>昵称：</td>
            <td><input type="text" name="name" value="{{ arr.name }}"></td>
        </tr>
        <tr>
            <td>电话：</td>
            <td><input type="text" name="tel" value="{{ arr.tel }}"></td>
        </tr>
        <tr>
            <td>性别：</td>
            <td>
            {% if arr.sex == 1 %}
            		<input type="radio" name="sex" value="1" checked >男
            		<input type="radio" name="sex" value="2">女
            	{% else %}
            		<input type="radio" name="sex" value="1">男
                    <input type="radio" name="sex" value="2" checked>女
            {% endif %}

            </td>
        </tr>
        <tr>
            <td>出生日期：</td>
            <td><input type="date" name="birthday" value="{{ arr.birthday }}"></td>
        </tr>
        <tr>
            <td>家庭住址：</td>
            <td><input type="text" name="address" value="{{ arr.address }}"></td>
        </tr>
        <tr>
            <td >上传头像</td>
            <td colspan='3'><input type="file" name="file" id="file0"></td>
            <td><img src="/{{ arr.img }}" alt=""  width="50px" height="50px" id="img0"/></td>
            <td><input type="text" name="img" value="{{ arr.img }}"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="提交"></td>
        </tr>
    </table>
    </form>
</center>
</body>
<script>
$(function(){
    $("#file0").change(function(){
         var objUrl = getObjectURL(this.files[0]) ;
         console.log("objUrl = "+objUrl) ;
         if (objUrl) {
          $("#img0").attr("src", objUrl) ;
         }
    }) ;

})

//建立一個可存取到該file的url
function getObjectURL(file) {
     var url = null ;
     if (window.createObjectURL!=undefined) { // basic
      url = window.createObjectURL(file) ;
     } else if (window.URL!=undefined) { // mozilla(firefox)
      url = window.URL.createObjectURL(file) ;
     } else if (window.webkitURL!=undefined) { // webkit or chrome
      url = window.webkitURL.createObjectURL(file) ;
     }
     return url ;
    }
</script>
</body>
</html>
</html>
