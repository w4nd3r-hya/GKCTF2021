const fs = require('fs');
const path = require('path');
const jwt = require('jsonwebtoken');
// 创建 token 类

const generateToken = (data)=> {
    let cert = fs.readFileSync(path.join(__dirname, './pem/key.key'));//私钥 可以自己生成
    let created = Math.floor(Date.now() / 1000);
    let token = jwt.sign({
        data, // 自定义字段
        exp: created + 60 * 30, // 过期时间 30 分钟
        iat: created, // 创建时间
    }, cert);
    return token;
}

// 校验token
const verifyToken = (data) => {
    let token = data;
    let cert = fs.readFileSync(path.join(__dirname, './pem/key.key'));//公钥 可以自己生成
    let res;
    try {
        let result = jwt.verify(token, cert) 
        // let result = jwt.verify(token, cert) || {};
        _id = result.data;
        _date = result.exp;
        _creatDate = result.iat;
        let {exp = 0} = result, current = Math.floor(Date.now() / 1000);
        if (current <= exp) {
            res = result.data || {};
        }
    } catch (e) {
        res = 'err';
    }
    return res;
}

module.exports = {
    generateToken,
    verifyToken,
}
