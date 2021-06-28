const express = require('express');
const format = require('string-format');
const { select,close } = require('./tools');
const app = new express();
var extend = require("js-extend").extend
const ejs = require('ejs');
const {generateToken,verifyToken}  = require('./encrypt');
var cookieParser = require('cookie-parser');
app.use(express.urlencoded({ extended: true }));
app.use(express.static((__dirname+'/public/')));
app.use(cookieParser());

const decode = (str) =>{
    str = str.replace(/\'/g,'\\\'');
    return str;
}

let safeQuery =  async (username,password)=>{

    const waf = (str)=>{
        blacklist = ['\\','\^',')','(','\"','\'']
        blacklist.forEach(element => {
            if (str == element){
                str = "*";
            }
        });
        return str;
    }

    const safeStr = (str)=>{ for(let i = 0;i < str.length;i++){
        if (waf(str[i]) =="*"){
            
            str =  str.slice(0, i) + "*" + str.slice(i + 1, str.length);
        }
        
    }
    return str;
    }

    username = safeStr(username);
    password = safeStr(password);
    let sql = format("select * from test where username = '{}' and password = '{}'",username.substr(0,20),password.substr(0,20));
    result = JSON.parse(JSON.stringify(await select(sql)));
    return result;
}

app.get('/', async(req,res)=>{
    const html = await ejs.renderFile(__dirname + "/public/index.html")
    res.writeHead(200, {"Content-Type": "text/html"});
    res.end(html)
})
    

app.post('/login',function(req,res,next){

    let username = req.body.username;
    let password = req.body.password;
    safeQuery(username,password).then(
        result =>{
            if(result[0]){
                const token = generateToken(username)
                res.json({
                    "msg":"yes","token":token
                });
            }
            else{
                res.json(
                    {"msg":"username or password wrong"}
                    );
            }
        }
    ).then(close()).catch(err=>{res.json({"msg":"something wrong!"});});
  })
 

app.get("/admin",async (req,res,next) => {
    const token = req.cookies.token
    let result = verifyToken(token);
    if (result !='err'){
        username = result
        var sql = `select board from board where username = "${username}"`;
        
        var query = JSON.parse(JSON.stringify(await select(sql).then(close())));  
        console.log(query);
        board = JSON.parse(query[0].board);
        const html = await ejs.renderFile(__dirname + "/public/admin.ejs",{board,username})
        res.writeHead(200, {"Content-Type": "text/html"});
        res.end(html)
    } 
    else{
        res.json({'msg':'stop!!!'});
    }
});
  
app.post("/addAdmin",async (req,res,next) => {
    let username = req.body.username;
    let password = req.body.password;
    const token = req.cookies.token
    let result = verifyToken(token);
    if (result !='err'){
        gift = JSON.stringify({ [username]:{name:"Blue-Eyes White Dragon",ATK:"3000",DEF:"2500",URL:"https://ftp.bmp.ovh/imgs/2021/06/f66c705bd748e034.jpg"}});
        var sql = format('INSERT INTO test (username, password) VALUES ("{}","{}") ',username,password);
        select(sql).then(close()).catch( (err)=>{console.log(err)}); 
        var sql = format('INSERT INTO board (username, board) VALUES (\'{}\',\'{}\') ',username,gift);
        select(sql).then(close()).catch( (err)=>{console.log(err)});
        res.end('add admin successful!')
    }
    else{
        res.end('stop!!!');
    }
});


app.post("/adminDIV",async(req,res,next) =>{
    const token = req.cookies.token
    
    var data =  JSON.parse(req.body.data)
    
    let result = verifyToken(token);
    if(result !='err'){
        username = result;
        var sql =`select board from board where username = "${username}"`;
        var query = JSON.parse(JSON.stringify(await select(sql).then(close().catch( (err)=>{console.log(err);} ))));       
        board = JSON.parse(JSON.stringify(query[0].board));
        var newBoard = {}
        for(var key in data){
            var addDIV =`{"${username}":{"${key}":"${(data[key])}"}}`;
            extend(newBoard,JSON.parse(addDIV));
        }
        sql = `update board SET board = '${JSON.stringify(newBoard)}' where username = '${username}'`
        select(sql).then(close()).catch( ()=>{res.json({"msg":'DIV ERROR?'});}); 
        res.json({"msg":'addDiv successful!!!'});
    }
    else{
        res.end('nonono');
    }
});


app.listen(1337, () => {
    console.log(`App listening at port 1337`)
})  