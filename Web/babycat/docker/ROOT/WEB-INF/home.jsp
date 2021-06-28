<%@ page import="com.web.dao.Person" %>
<%@ page isELIgnored="false" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%
    Person person = (Person)session.getAttribute("user");
%>
<%response.setCharacterEncoding("gbk");%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文件存储系统</title>
</head>
<body>
<div id="wrapper">
    <nav role="navigation" id="access">
        <a class="skip-link icon-reorder" title="" href="#menu">Menu</a>
        <ul id="menu">
            <li class="active"><a class="icon-home" href="/home">Home</a></li><!-- whitespace
                --><li><a class="icon-group" href="/home/upload">Upload</a></li><!-- whitespace
                --><li><a class="icon-leaf" href="/home/download?file=../../static/cat.gif">Download Test</a></li><!-- whitespace
                --><li><a class="icon-picture" href="/logout">Logout</a></li>
        </ul>
    </nav>
</div>
<div id="formContent2">
    <h1>UserInfo</h1><div class="info">${error}</div>
    <div class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
            <thead>
            <tr>
                <th>username</th>
                <th>role</th>
                <th>pic</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tbl-content">
        <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
            <tr>
                <td><%=person.getUsername()%></td>
                <td><%=person.getRole()%></td>
                <td><img src="<%=person.getPic()%>"></td>
            </tr>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
<link rel="stylesheet" href="/static/1.css">