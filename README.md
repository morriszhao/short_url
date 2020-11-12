# short_url

将 长url 保存到数据库、 根据自增id 生成 短标签



table ddl
```sql
CREATE TABLE `short_url` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(8) NOT NULL DEFAULT '' COMMENT '实际url 8位索引 可md5(原始url) 然后取8位',
  `url` varchar(255) NOT NULL DEFAULT '',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_code` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=100009 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

根据ddl 建表
```



###使用

``composer require zhaolm/shorturl
``
```php
$url = new \ShortUrl\ShortUrl();

//生成
echo $url->shortUrlGenerate(123456789); 
//解析
echo $url->shortUrlParse('8m0Kx3s');
```

