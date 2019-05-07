## Laravel框架文档
https://learnku.com/docs/laravel/5.7

## Docker本地测试环境启动
```
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
|- resources     视图和未编译的资源文件（如 LESS、SASS 或 JavaScript）
|- routes        路由
|- storage       日志、缓存等
|- tests         单元测试
|- vendor        依赖包
```

## PHP规范

### 命名规范
* 参照PSR规范
    * 英文: http://www.php-fig.org/
    * 中文: https://github.com/PizzaLiu/PHP-FIG 
* namespace、类名、类文件、与namespace映射的文件夹采用StudlyCaps大驼峰命名法;
* 方法名、属性名、变量名、视图文件中的php变量名采用camelCase小驼峰命名法; 
* 函数名、非类文件、与namespace没有映射关系的文件夹采用下划线命名法; 
* 全局常量、类常量采用大写下划线命名法;
* 数组键名采用下划线命名法; 
* private方法下划线开头，protected和public方法需要字母开头;
* 与namespace映射的文件夹命名要与namespace一致;
* Controller放在Controllers文件夹下,Model放在Models文件夹下,Service放在Services文件夹下; 
* Models层的文件名和类名都要加Model后缀,以此类推Services、Jobs、Providers等; 
* 全局常量尽量少用,全局函数尽量少定义(尽量用类方法); 
* 单个方法推荐代码不超过50行，超过需要考虑拆分细化为多个子方法[推荐];

### IDE
* 统一使用一套IDE格式化模板;
* 推荐使用PhpStorm IDE，若右侧区域有提示黄色或者红色块，需要注意，可能代码存在隐藏bug[推荐]; TAB键用4个空格代替;
* 类、类方法、函数大括号换行，if等语句大括号同行;
* 每个文件必须以空行结束;
* 单行代码不宜过来，如超过屏幕显示区域则换行;


## Mysql规范

### 基础规范
* 必须使用InnoDB存储引擎
* 字符集统一使用utf8mb4，字符集排序规则统一使用utf8mb4_unicode_ci
* 所有表都需要添加注释
* 单表数据量建议控制在1千万以内
* 不在数据库中存储图、文件等大对象数据
* 禁止在线上数据库做压力测试
* 禁从测试、开发环境直连线上数据库

### 库表字段命名规范
* 库名表名字段名必须有固定的命名长度，12个字符以内
* 表名字段名使用单数的英文单词，多个单词使用 _ 符号连接
* 库名、表名、字段名禁止超过30个字符，需见名知意，不要取一些无关的字符串作为名称
* 库名、表名、字段名禁使用MySQL保留字
* 临时库、表名必须以tmp为前缀，并以日期为后缀
* 备份库、表必须以bak为前缀，并以日期为后缀
* 库名、表名和字段名也统一用单数形式，不要复数形式

### 库、表、字段表开发设计规范
* 禁使用分区表
* 拆分大字段和访问频率低的字段，分离冷热数据
* 用Hash进散表，表名后缀使进制数，下标从0开始
* 按日期时间分表需符合YYYY[MM][DD][HH]格式
* 采用合适的分库分表策略。例如千库万表、十库百表等
* 尽可能不使用TEXT、BLOB类型,尽量使用varchar类型
* 用DECIMAL代替FLOAT和DOUBLE存储精确浮点数
* 越简单越好:将字符转化为数字、使用TINYINT来代替ENUM类型
* 所有字段均定义为NOT NULL。默认值，整型为0、字符串为空字符'' (10) 使用UNSIGNED存储非负整数
* INT类型固定占用4字节存储
* 使用timestamp存储时间
* 使用INT UNSIGNED存储IPV4
* 使用VARBINARY存储大小写敏感的变长字符串
* 禁止在数据库中存储明文密码，把密码加密后存储
* 用好数值类型字段
* 存储ip最好用int存储而非char(15)
* 不允许使用ENUM。ENUM字段加类型是DDL操作
* 避免使用NULL字段，字段需要建索引的必须用NOT NULL NULL字段很难查询优化，NULL字段的索引需要额外空间，NULL字段的复合索引无效
* 少用text/blob，varchar的性能会比text高很多，实在避免不了blob，请拆表
* 数据库中不允许存储大文件，或者照片，可以将大对象放到磁盘上，数据库中存储它的路径
* 尽量使用varchar存储字符串。VARCHAR(M)，M尽可能小，因为VARCHAR按实际的字符数申请内存时，如果大于255个，需要2bytes，小于 等于255个，需要1bytes。M表示字符数而不是字节数，比如VARCHAR(1024)，最大可存储1024个汉字，根据实际业务选择长度M
* 字符串类型值，程序必须控制输入的字符，比如空格、符号等，因为字符串末尾的空格会有trailing spaces问题 整型类型

### 索引规范

1、索引的数量要控制:
* 单张表中索引数量不超过5个
* 单个索引中的字段数不超过5个
* 对字符串使用前缀索引，前缀索引长度不超过8个字符
* 建议优先考虑前缀索引，必要时可添加伪列并建立索引

2、主键准则
* 表必须有主键
* 不使用更新频繁的列作为主键
* 尽量不选择字符串列作为主键
* 不使用UUID MD5 HASH这些作为主键(数值太离散了)
* 默认使非空的唯一键作为主键
* 建议选择自增或发号器

3、重要的SQL必须被索引
* UPDATE、DELETE语句的WHERE条件列
* ORDER BY、GROUP BY、DISTINCT的字段

4、多表JOIN的字段注意以下:
* 区分度最大的字段放在前面
* 核SQL优先考虑覆盖索引
* 避免冗余和重复索引
* 索引要综合评估数据密度和分布以及考虑查询和更新比例

5、索引禁忌
* 不在低基数列上建立索引，例如“性别”
* 不在索引列进行数学运算和函数运算

6、尽量不使用外键
* 外键用来保护参照完整性，可在业务端实现
* 对父表和子表的操作会相互影响，降低可用性

7、索引命名:非唯一索引必须以 idx_字段1_字段2命名，唯一所以必须以uniq_字段1_字段2命名，索引名称必须全部小写

8、新建的唯一索引必须不能和主键重复

9、索引字段的默认值不能为NULL，要改为其他的default或者空。NULL非常影响索引的查询效率

10、反复查看与表相关的SQL，符合最左前缀的特点建立索引。多条字段重复的语句，要修改语句条件字段的顺序，为其建立一条联合索引，减少 索引数量

11、能使用唯一索引就要使用唯一索引，提高查询效率 12、研发要经常使用explain，如果发现索引选择性差，必须让他们学会使用hint

### SQL规范
* sql语句尽可能简单，大的sql想办法拆成小的sql语句
* 事务要简单，整个事务的时间长度不要太长
* 避免使用触发器、函数、存储过程
* 降低业务耦合度，为sacle out、sharding留有余地
* 避免在数据库中进数学运算(MySQL不擅长数学运算和逻辑判断)
* 少用select *，查询哪几个字段就select 这几个字段
* sql中使用到OR的改写为用 IN() (or的效率没有in的效率高)
* in里面数字的个数建议控制在1000以内
* limit分页注意效率,不要使用offset非常大的limit。Limit越大，效率越低。可以改写limit，比如例子改写: select id from tlimit 10000, 10; => select id from t where id > 10000 limit10;
* 使用union all替代union
* 避免使大表的JOIN
* 使用group by 分组、自动排序
* 对数据的更新要打散后批量更新，不要一次更新太多数据
* 减少与数据库的交互次数
* 注意使用性能分析工具。尽量避免在extra列出现:Using filesort、Using temporary Sql explain / showprofile / mysqlsla
* SQL语句要求所有研发，SQL关键字全部是大写，每个词只允许有一个空格
* SQL语句不可以出现隐式转换，比如 select id from 表 where id='1'
* IN条件里面的数据数量要少，我记得应该是500个以内，要学会使用exist代替in，exist在一些场景查询会比in快 (17) 能不用NOT IN就不用NOTIN，坑太多了。。会把空和NULL给查出来
* 在SQL语句中，禁止使用前缀是%的like
* 不使用负向查询，如not in/like
* 关于分页查询:程序里建议合理使用分页来提高效率limit，offset较大要配合子查询使用
* 禁止在数据库中跑大查询
* 使预编译语句，只传参数，比传递SQL语句更高效;一次解析，多次使用;降低SQL注入概率
* 禁止使order by rand()
* 禁单条SQL语句同时更新多个表


### 单元测试
```
sh phpunit.sh
```
