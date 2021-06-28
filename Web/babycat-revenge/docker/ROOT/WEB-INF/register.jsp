<%@ page isELIgnored="false" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>Register</title>
</head>
<body>
${error}
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
    // var obj={};
    // obj["username"]='test';
    // obj["password"]='test';
    // obj["role"]='guest';
    function doRegister(obj){
        if(obj.username==null || obj.password==null){
            alert("用户名或密码不能为空");
        }else{
            var d = new Object();
            d.username=obj.username;
            d.password=obj.password;
            d.role="guest";

            $.ajax({
                url:"/register",
                type:"post",
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                data: "data="+JSON.stringify(d),
                dataType: "json",
                success:function(data){
                    alert(data)
                }
            });
        }
    }
</script>
</body>
</html>
