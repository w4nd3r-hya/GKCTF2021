#### 环境搭建
```
./build.sh
./run.sh
```
`run.sh`中内容
`docker run -d -p "0.0.0.0:9002:22" -p "0.0.0.0:9003:9999" demo_catroom`
22端口是运行服务端，9999是服务端监听端口。
#### 运行
`ssh ctf@127.0.0.1 -p 9002`
密码 ：123456





