# Host: 192.168.70.7  (Version: 5.1.73)
# Date: 2018-08-09 13:54:27
# Generator: MySQL-Front 5.3  (Build 4.214)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "dev_attribute"
#

DROP TABLE IF EXISTS `dev_attribute`;
CREATE TABLE `dev_attribute` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `aname` varchar(128) DEFAULT '0' COMMENT '属性名',
  `statue` int(1) DEFAULT '1' COMMENT '1代表共有0代表私有',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='属性表';

#
# Data for table "dev_attribute"
#

INSERT INTO `dev_attribute` VALUES (1,'品牌',1),(2,'应用场景',1),(3,'卡类型',1),(4,'设备类型',1);

#
# Structure for table "dev_attribute_connect"
#

DROP TABLE IF EXISTS `dev_attribute_connect`;
CREATE TABLE `dev_attribute_connect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` varchar(11) NOT NULL DEFAULT '0' COMMENT '机种id',
  `vaid` varchar(11) NOT NULL DEFAULT '0' COMMENT '属性值id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=491 DEFAULT CHARSET=utf8 COMMENT='机种属性值关系表';

#
# Data for table "dev_attribute_connect"
#


#
# Structure for table "dev_attribute_val"
#

DROP TABLE IF EXISTS `dev_attribute_val`;
CREATE TABLE `dev_attribute_val` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vname` varchar(64) DEFAULT '0' COMMENT '属性值名称',
  `aid` varchar(6) DEFAULT '0' COMMENT '属性id',
  `statue` int(1) DEFAULT '1' COMMENT '1代表共有0代表私有',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COMMENT='属性值';

#
# Data for table "dev_attribute_val"
#

INSERT INTO `dev_attribute_val` VALUES (48,'室内','2',1),(49,'单卡2.4G','3',1),(50,'AP','4',1),(56,'室外','2',1),(57,'双卡2.4G','3',1),(58,'CPE','4',1),(77,'AC_1022_FF:44_DA','1',1),(78,'CEP_AP1022qwdwew','1',1),(84,'AC','4',1);

#
# Structure for table "dev_files"
#

DROP TABLE IF EXISTS `dev_files`;
CREATE TABLE `dev_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) DEFAULT NULL COMMENT '文件路径',
  `file_remarks` varchar(512) DEFAULT NULL COMMENT '文件的备注',
  `vid` int(11) DEFAULT '0' COMMENT '版本号的id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='版本号的文件';

#
# Data for table "dev_files"
#


#
# Structure for table "dev_remarks"
#

DROP TABLE IF EXISTS `dev_remarks`;
CREATE TABLE `dev_remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dev_re_name` varchar(512) DEFAULT '0' COMMENT '机种备注名',
  `did` varchar(8) DEFAULT '0' COMMENT '机种id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8 COMMENT='机种备注表';

#
# Data for table "dev_remarks"
#


#
# Structure for table "device"
#

DROP TABLE IF EXISTS `device`;
CREATE TABLE `device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT '0' COMMENT '机种名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 COMMENT='机种表';

#
# Data for table "device"
#


#
# Structure for table "item"
#

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(64) DEFAULT '0' COMMENT '项目名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目表';

#
# Data for table "item"
#


#
# Structure for table "item_attribute"
#

DROP TABLE IF EXISTS `item_attribute`;
CREATE TABLE `item_attribute` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `aname` varchar(64) DEFAULT '0' COMMENT '项目的属性名',
  `statue` int(1) DEFAULT '1' COMMENT '属性的状态',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='项目属性表';

#
# Data for table "item_attribute"
#

INSERT INTO `item_attribute` VALUES (1,'项目管理者',1),(2,'项目所属客户',1),(3,'项目所需机种',1);

#
# Structure for table "item_attribute_connect"
#

DROP TABLE IF EXISTS `item_attribute_connect`;
CREATE TABLE `item_attribute_connect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iid` int(11) DEFAULT '0' COMMENT '项目的id',
  `vaid` int(11) DEFAULT '0' COMMENT '属性值的id',
  `aid` int(11) DEFAULT '0' COMMENT '属性id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目属性关系表';

#
# Data for table "item_attribute_connect"
#


#
# Structure for table "item_attribute_val"
#

DROP TABLE IF EXISTS `item_attribute_val`;
CREATE TABLE `item_attribute_val` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vname` varchar(64) DEFAULT '0' COMMENT '项目属性值名',
  `aid` int(11) DEFAULT '0' COMMENT '属性id',
  `statue` int(1) DEFAULT '1' COMMENT '属性值的状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目属性值表';

#
# Data for table "item_attribute_val"
#


#
# Structure for table "item_device"
#

DROP TABLE IF EXISTS `item_device`;
CREATE TABLE `item_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iid` int(11) DEFAULT '0' COMMENT '项目id',
  `did` int(11) DEFAULT '0' COMMENT '机种id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目机种表';

#
# Data for table "item_device"
#


#
# Structure for table "item_file"
#

DROP TABLE IF EXISTS `item_file`;
CREATE TABLE `item_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) DEFAULT NULL COMMENT '项目文件路径',
  `file_remarks` varchar(512) DEFAULT '0' COMMENT '文件备注',
  `iid` int(11) DEFAULT '0' COMMENT '项目id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目文件表';

#
# Data for table "item_file"
#


#
# Structure for table "item_remarks"
#

DROP TABLE IF EXISTS `item_remarks`;
CREATE TABLE `item_remarks` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `iname` varchar(255) DEFAULT '0' COMMENT '备注名',
  `iid` int(11) NOT NULL DEFAULT '0' COMMENT '项目id',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目备注表';

#
# Data for table "item_remarks"
#


#
# Structure for table "item_siyou_connect"
#

DROP TABLE IF EXISTS `item_siyou_connect`;
CREATE TABLE `item_siyou_connect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iid` int(11) DEFAULT '0' COMMENT '项目id',
  `vaid` int(11) DEFAULT '0' COMMENT '私有属性值的id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=REDUNDANT COMMENT='项目的私有属性值关系表';

#
# Data for table "item_siyou_connect"
#


#
# Structure for table "log_information"
#

DROP TABLE IF EXISTS `log_information`;
CREATE TABLE `log_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL DEFAULT '0' COMMENT '用户名',
  `log_level` varchar(12) NOT NULL DEFAULT '0' COMMENT '日志级别',
  `log_type` varchar(32) DEFAULT '0' COMMENT '日志类型',
  `login_ip` varchar(16) DEFAULT '0' COMMENT '登陆者IP',
  `log_time` varchar(32) DEFAULT '0' COMMENT '操作时间',
  `action_info` varchar(64) DEFAULT '0' COMMENT '行为信息',
  `info` varchar(256) DEFAULT '0' COMMENT 'æ—¥å¿—ä¿¡æ¯',
  `item_info` varchar(16) DEFAULT '0' COMMENT 'æ—¥å¿—ä¿¡æ¯æ¨¡å—',
  `log_power` int(2) DEFAULT '0' COMMENT '权限',
  `belong` int(11) DEFAULT '0' COMMENT '属于谁',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4160 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='日志表';

#
# Data for table "log_information"
#

INSERT INTO `log_information` VALUES (4206,'admin','operation','user','192.168.70.214','1533793980','delete','123123 cv','user',15,0);

#
# Structure for table "remarks"
#

DROP TABLE IF EXISTS `remarks`;
CREATE TABLE `remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(9) DEFAULT '0' COMMENT '用户id',
  `remarks` varchar(255) DEFAULT '0' COMMENT '备注信息内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户备注表';

#
# Data for table "remarks"
#


#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(16) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(32) DEFAULT '0' COMMENT '密码',
  `email` varchar(32) DEFAULT '0' COMMENT '邮箱',
  `phone` varchar(12) DEFAULT '0' COMMENT '手机号码',
  `power` varchar(2) DEFAULT '0' COMMENT '权限',
  `own_dev_look` varchar(2) DEFAULT '0' COMMENT '拥有机种查看权限',
  `own_dev_aud` varchar(2) DEFAULT '0' COMMENT '机种的增删修',
  `own_item_look` varchar(2) DEFAULT '0' COMMENT '项目类的查看权限',
  `own_item_aud` varchar(2) DEFAULT '0' COMMENT '项目类增删修',
  `own_file_look` varchar(2) DEFAULT '0' COMMENT '文件类的查看',
  `own_file_upload` varchar(2) DEFAULT '0' COMMENT '文件类的上传',
  `own_file_download` varchar(2) DEFAULT '0' COMMENT '文件类的下载',
  `own_user_look` varchar(2) DEFAULT '0' COMMENT '用户类的查看',
  `own_user_aud` varchar(2) DEFAULT '0' COMMENT '用户类的增删修',
  `own_log_look` varchar(2) DEFAULT '0' COMMENT '日志类的查看',
  `own_log_download` varchar(2) DEFAULT '0' COMMENT '日志导出权限',
  `own_log_update` varchar(2) DEFAULT '0' COMMENT '日志修改设定',
  `own_upgrade` varchar(2) DEFAULT '0' COMMENT '升级权限',
  `log_type` varchar(2) DEFAULT 'on' COMMENT '日志操作',
  `log_tips` varchar(2) DEFAULT 'on' COMMENT '日志提示',
  `log_warn` varchar(2) DEFAULT 'on' COMMENT '日志警告',
  `log_dev` varchar(2) DEFAULT 'on' COMMENT '机种类日志',
  `log_file` varchar(2) DEFAULT 'on' COMMENT '文件类日志',
  `log_item` varchar(2) DEFAULT 'on' COMMENT '项目类日志',
  `log_system` varchar(2) DEFAULT 'on' COMMENT '系统类日志',
  `log_user` varchar(2) DEFAULT 'on' COMMENT '用户类日志',
  `log_upgrade` varchar(2) DEFAULT 'on' COMMENT '升级类日志',
  `language` varchar(8) DEFAULT 'zh-CN' COMMENT '语言',
  `belong` varchar(9) DEFAULT '0' COMMENT '属于谁',
  PRIMARY KEY (`id`,`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户信息表';

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','1137500763@qq.com','13564885264','15','1','1','1','1','1','1','1','1','1','1','1','1','1','on','on','on','on','on','on','on','on','on','zh-CN','0');

#
# Structure for table "user_dev"
#

DROP TABLE IF EXISTS `user_dev`;
CREATE TABLE `user_dev` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(9) DEFAULT '0' COMMENT '用户id',
  `did` varchar(9) DEFAULT '0' COMMENT '机种id',
  `common_used` varchar(2) DEFAULT '0' COMMENT '常用机种',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=410 DEFAULT CHARSET=utf8 COMMENT='用户拥有的机种';

#
# Data for table "user_dev"
#


#
# Structure for table "user_item"
#

DROP TABLE IF EXISTS `user_item`;
CREATE TABLE `user_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT '用户id',
  `iid` int(11) DEFAULT '0' COMMENT '项目id',
  `common_used` int(1) DEFAULT '0' COMMENT '常用项目',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户项目表';

#
# Data for table "user_item"
#


#
# Structure for table "version"
#

DROP TABLE IF EXISTS `version`;
CREATE TABLE `version` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(10) DEFAULT '0' COMMENT '当前版本',
  `statue` varchar(2) DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='系统版本';

#
# Data for table "version"
#

INSERT INTO `version` VALUES (1,'V1.0.0.1','0'),(2,'V1.0.0.2','0'),(3,'V1.0.0.3','0'),(4,'V1.0.0.4','0'),(5,'V1.0.0.5','0'),(6,'V1.0.0.6','0'),(7,'V1.0.0.7','0'),(8,'V1.0.0.8','0'),(9,'V1.0.0.9','0'),(10,'V1.0.1.0','0'),(11,'V1.0.1.1','0'),(12,'V1.0.1.2','1');

#
# Structure for table "version_name"
#

DROP TABLE IF EXISTS `version_name`;
CREATE TABLE `version_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) DEFAULT NULL COMMENT '机种id',
  `pid` int(11) DEFAULT NULL COMMENT '品牌值的id',
  `version_name` varchar(128) NOT NULL DEFAULT '' COMMENT '版本号',
  PRIMARY KEY (`id`,`version_name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='版本号';

#
# Data for table "version_name"
#

