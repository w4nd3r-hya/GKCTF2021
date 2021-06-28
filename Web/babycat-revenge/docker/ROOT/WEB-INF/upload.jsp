<%@ page import="com.web.dao.Person" %>
<%@ page import="java.util.List" %>
<%@ page isELIgnored="false" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%
    Person person = (Person)session.getAttribute("user");
%>
<%response.setCharacterEncoding("utf-8");%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>
<body>
<div id="wrapper">

    <nav role="navigation" id="access">
        <a class="skip-link icon-reorder" title="Accéder au menu" href="#menu">Menu</a>
        <ul id="menu">
            <li class="active"><a class="icon-home" href="/home">Home</a></li><!-- whitespace
                --><li><a class="icon-group" href="/home/upload">Upload</a></li><!-- whitespace
                --><li><a class="icon-leaf" href="/home/download?file=./../static/cat.gif">Download Test</a></li><!-- whitespace
                --><li><a class="icon-picture" href="/logout">Logout</a></li>
        </ul>
    </nav>
</div>

    <div id="formContent2">
        <h1>文件上传</h1><div class="info">${error}</div>
        <form action="/home/upload" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="file">
            <input type="submit" value="上传" >
        </form>
        <%
            List<String> fileNames = (List<String>) request.getAttribute("files");
        %>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                <tr>
                    <th>文件名</th>
                    <th>操作</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <%
                    if (fileNames!=null){
                        for (String file : fileNames){
                %>
                <tr>
                    <td>
                        <%=file%>
                    </td>
                    <td><input type="button" value="下载" onclick="window.location.href='/home/download?file=<%=file%>'"></td>
                </tr>
                <%}}%>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<link rel="stylesheet" href="/static/1.css">