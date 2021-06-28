<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%response.setCharacterEncoding("gbk");%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->
        <h2 class="active" id="1"> Sign In </h2>
        <a class="inactive underlineHover" id="2" href="/register">SIGN UP </a>
        <div class="fadeIn first"></div>
        <!-- Login Form -->
        <form id="userInfo">
            <input type="text"  id="username" name="username" class="fadeIn second"  placeholder="username">
            <input type="text" id="password" class="fadeIn third" name="password" placeholder="password">
            <input type="submit"  class="fadeIn fourth" value="Log In" id="login-button" >
        </form>
    </div>
</div>
</body>
<link rel="stylesheet" href="./static/2.css"/>
</html>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    $("#1").click(function(event){
        $('#1').removeClass("inactive underlineHover");
        $('#1').addClass("active");
        $('#2').removeClass("active");
        $('#2').addClass("inactive underlineHover");
        $('#login-button').attr("value","Log In");
    });

    $("#login-button").click(function() {
        event.preventDefault();

        var formObject = {};
        var formArray =$("#userInfo").serializeArray();
        $.each(formArray,function(i,item){
            formObject[item.name] = item.value;
        });

        if($("#login-button").val()=="Log In"){
            $.ajax({
                url:"/login",
                type:"post",
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: "data="+JSON.stringify(formObject),
                dataType: "text",
                success:function(result){
                    var res = JSON.parse(result);
                    alert(res.msg)
                    if (res.msg=="login success!"){
                        //alert(res.msg)
                        window.location.href="./home";
                    }
                }
            });
        }
    });

</script>