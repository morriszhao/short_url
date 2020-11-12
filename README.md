# short_url

使用mysql自增id   转换成62进制  生成short_url

table ddl
```sql
CREATE TABLE `short_url` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(8) NOT NULL DEFAULT '' COMMENT '实际url 8位索引',
  `url` varchar(255) NOT NULL DEFAULT '',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_code` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=100009 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;
```



###使用
