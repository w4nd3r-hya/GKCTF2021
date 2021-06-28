<?php
error_reporting(0);
session_start();
function waf($str){
    if (preg_match("/eq|regex|ne/i", $str)) {
        return true;
    }
    return false;
}
$manager = new MongoDB\Driver\Manager("mongodb://172.16.0.4:27017");

$input=file_get_contents("php://input");
if (waf($input)) {
    die('{"msg":"hacker"}');
}
$arr=json_decode($input);
$username=$arr->username;
$password=$arr->password;

if ($username && $password) {
    $query = new MongoDB\Driver\Query(array('username' => $username,'password' => $password));
    $result = $manager->executeQuery('ctf.users', $query)->toArray();
    $count = count($result);
    if ($count > 0) {    
        foreach ($result as $user) {
            $user = ((array)$user);
            $uname=$user['username'];
            $pwd=$user['password'];
        }
    }
    if ($uname && $pwd) {
        if ($pwd===$password) {
            $_SESSION['login']='admin';
            print('{"msg":"登录成功"}');
        }elseif ($pwd && $uname) {
            print('{"msg":"登录了，但没完全登录"}');
        }else{
            print('{"msg":"登录失败"}');
        }
    }else{
        print('{"msg":"登录失败"}');
    }
}
?> 
