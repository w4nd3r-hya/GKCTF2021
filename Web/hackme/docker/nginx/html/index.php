<?php include("init.php");file_put_contents("init.php","<?php");?>
<head>
<link rel="stylesheet" type="text/css" href="./static/style.css">
</head>
<img src="./static/bg.jpeg" width="100%" height="100%" style="position:absolute;top:0;left:0;right:100;bottom:500;z-index:-1" />

<div class="login">
  <div class="login-triangle"></div>
  
  <h2 class="login-header">Log in</h2>
  
  <form id="login-form" class="login-container"><p><p id="res">请登录</p>
</p><!--doyounosql?-->
    <p><input type="text" placeholder="username" name="username"></p>
    <p><input type="password" placeholder="password" name="password"></p>
    <p><input type="button" value="Log in" id="login-button"></p>
  </form>
</div>
<script src="./static/jquery-2.1.1.min.js"></script>
<script>
    $("#login-button").click(function() {
        var formObject = {};
        var formArray =$("#login-form").serializeArray();
        $.each(formArray,function(i,item){
            formObject[item.name] = item.value;
        });
        console.log(formObject)
        $.ajax({
            url:"/login.php",
            type:"post",
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(formObject),
            dataType: "json",
            success:function(data){
                $('#res').text(data.msg);
                if (data.msg=='登录成功') {
                    window.location='/admin.php'
                }
            },
        });
    });
</script>