## hackme

### 考点

nosql盲注、nginx HTTP走私->打反向代理weblogic

### 题目描述

无

### 使用

docker-compose up -d

访问http://localhost:7000即可，内网网段需为172.16.0.0/16(见docker-compose.yml)

### flag：
位于docker/weblogic/files/flag.txt，注：/flag需设置700权限，readflag以读取

