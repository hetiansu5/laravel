## Laravel框架文档
https://learnku.com/docs/laravel/5.7

## Docker本地测试环境启动
```
cp .env.example .env
cd ${项目目录}
composer install --optimize-autoloader
cd docker
docker-compose up --force-recreate --remove-orphans -d
```

## 多应用方案
* public目录下增加新的应用目录和入口文件，入口文件的APP_NAME全局变量需要定义
* app/Providers/RouteServiceProvider.php的map函数增加新应用的路由选择方案

## 项目目录
```
|- app           应用程序的核心代码
    |- Console      自定义的 Artisan 命令
    |- Contants     常量层
    |- Exceptions   应用的异常处理器
    |- Http         包含了控制器、中间件和表单请求
        |- ApiControllers   Api控制器
        |- Controllers      Web控制器
        |- Middleware       中间件
    |- Jobs         队列任务层
    |- Libraries    扩展工具包
    |- Models       数据层
    |- Providers    服务提供层
    |- Services     服务层（第三方API，主要是涉及到网络IO的）
    |- Traits       组件复用类
|- bootstrap     项目启动文件
|- config        包含应用程序所有的配置文件
|- database      数据填充和迁移文件以及模型工厂类
|- docker        本地Docker环境配置
|- public        项目入口
    |- api          API应用
        |- index.php        入口文件
    |- web          Web应用
        |- index.php        入口文件
|- resources     视图和未编译的资源文件（如 LESS、SASS 或 JavaScript）
|- routes        路由
|- storage       日志、缓存等
|- tests         单元测试
|- vendor        依赖包
```

### 单元测试
```
sh phpunit.sh
```
