## ezcms

### 题目描述

真·ezcms

### 使用

在docker目录下执行

```docker
docker-compose up -d --build 
```

每次删除容器的时候需要执行：

```dockerfile
docker-compose stop && docker-compose rm
```

### flag

位于docker-compose.yml中