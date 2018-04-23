/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : gonghui.freeking.com

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-02-07 19:10:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_apply
-- ----------------------------
DROP TABLE IF EXISTS `tb_apply`;
CREATE TABLE `tb_apply` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` int(10) DEFAULT NULL,
  `differ` int(10) DEFAULT NULL,
  `apptime` int(10) DEFAULT NULL COMMENT '申请时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_buy_cards
-- ----------------------------
DROP TABLE IF EXISTS `tb_buy_cards`;
CREATE TABLE `tb_buy_cards` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL COMMENT '会员id',
  `counts` int(11) DEFAULT NULL COMMENT '购买数量',
  `pay_amount` decimal(10,2) DEFAULT NULL COMMENT '支付金额',
  `pay_time` int(10) DEFAULT NULL COMMENT '支付时间',
  `cps_id` int(10) DEFAULT NULL COMMENT '上级渠道id',
  `post_amount` int(10) DEFAULT NULL COMMENT '支付后余额',
  `pay_state` tinyint(2) DEFAULT NULL COMMENT '支付状态（0：未支付；1：支付）',
  PRIMARY KEY (`id`),
  KEY `state_index` (`pay_state`) USING BTREE,
  KEY `time_index` (`pay_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_childunionlist
-- ----------------------------
DROP TABLE IF EXISTS `tb_childunionlist`;
CREATE TABLE `tb_childunionlist` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `parent_id` int(11) NOT NULL COMMENT '父渠道ID',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '子渠道标识',
  `name` varchar(100) NOT NULL COMMENT '联盟名',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '包状态,1初始状态，2已生成临时包，3已推送到cdn',
  `tmp_package_version` varchar(10) NOT NULL DEFAULT '' COMMENT '临时包版本',
  `package_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '打包状态,0:初始状态,1:正在打包,3:打包成功,4:打包失败',
  `package_url` varchar(255) NOT NULL DEFAULT '' COMMENT '临时下载路径',
  `cdn_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'cdn下载地址',
  `cdn_package_version` varchar(10) NOT NULL DEFAULT '' COMMENT 'cdn包版本',
  `plattype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '平台类型，1:安卓,2:ios,3:越狱',
  `open_flag` tinyint(4) NOT NULL DEFAULT '2' COMMENT '状态，1打开，2关闭，0删除',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='子渠道表';

-- ----------------------------
-- Table structure for tb_club
-- ----------------------------
DROP TABLE IF EXISTS `tb_club`;
CREATE TABLE `tb_club` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(200) DEFAULT NULL COMMENT '俱乐部名称',
  `game_id` varchar(50) DEFAULT NULL COMMENT '游戏id',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `user_id` int(10) DEFAULT NULL COMMENT '会员id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_games
-- ----------------------------
DROP TABLE IF EXISTS `tb_games`;
CREATE TABLE `tb_games` (
  `game_id` int(10) NOT NULL,
  `game_name` varchar(255) DEFAULT NULL,
  `game_domain` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_game_union_user_reg
-- ----------------------------
DROP TABLE IF EXISTS `tb_game_union_user_reg`;
CREATE TABLE `tb_game_union_user_reg` (
  `id` int(10) NOT NULL,
  `game_id` int(11) unsigned DEFAULT '1' COMMENT '游戏ID',
  `union_id` int(11) DEFAULT '1' COMMENT '渠道id',
  `child_union_id` int(11) DEFAULT '1' COMMENT '子渠道id',
  `ktuid` bigint(20) unsigned DEFAULT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `expand_user_name` varchar(200) DEFAULT NULL,
  `channel` varchar(30) DEFAULT NULL COMMENT '渠道标识',
  `cps_channel` varchar(50) DEFAULT NULL,
  `userphone` varchar(20) DEFAULT NULL COMMENT '手机号',
  `reg_time` varchar(30) DEFAULT '0' COMMENT '注册时间',
  KEY `email` (`cps_channel`),
  KEY `mobile` (`userphone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_goods
-- ----------------------------
DROP TABLE IF EXISTS `tb_goods`;
CREATE TABLE `tb_goods` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '商品名',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '金额',
  `desc` varchar(200) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_notice
-- ----------------------------
DROP TABLE IF EXISTS `tb_notice`;
CREATE TABLE `tb_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id(自增)',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` text COMMENT '文章内容',
  `keyword` varchar(50) DEFAULT NULL COMMENT '关键词',
  `adminid` int(10) DEFAULT '0' COMMENT '管理员id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_order
-- ----------------------------
DROP TABLE IF EXISTS `tb_order`;
CREATE TABLE `tb_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(20) DEFAULT NULL COMMENT '订单id',
  `ktuid` bigint(20) DEFAULT NULL COMMENT '用户id',
  `user_name` varchar(50) DEFAULT NULL COMMENT '用户名',
  `channel_id` int(10) DEFAULT NULL COMMENT '充值渠道id',
  `pay_time` int(10) DEFAULT NULL COMMENT '下单时间',
  `payOrderTime` varchar(30) DEFAULT NULL COMMENT '支付时间',
  `payState` tinyint(2) DEFAULT NULL COMMENT '支付状态',
  `pay_currency` varchar(20) DEFAULT 'RMB' COMMENT '支付货币',
  `amount` decimal(10,2) DEFAULT NULL COMMENT '支付金额',
  `transaction_id` varchar(50) DEFAULT NULL COMMENT '商户订单号',
  `pay_platform` varchar(50) DEFAULT NULL COMMENT '所属平台标识',
  `union_id` int(10) DEFAULT NULL,
  `settle_status` tinyint(2) DEFAULT NULL COMMENT '结算状态 0:未结算；1:已结算；2:申请中',
  `settlement_id` int(10) DEFAULT NULL COMMENT '结算单id',
  `userip` varchar(20) DEFAULT NULL,
  `extendbox` varchar(50) DEFAULT NULL,
  `productID` varchar(30) DEFAULT NULL,
  `serverID` int(10) DEFAULT NULL,
  `channel` varchar(50) DEFAULT NULL COMMENT '渠道标识',
  `appid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_pay_orders
-- ----------------------------
DROP TABLE IF EXISTS `tb_pay_orders`;
CREATE TABLE `tb_pay_orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(20) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `channel_id` int(11) unsigned NOT NULL,
  `pay_time` int(11) NOT NULL DEFAULT '0',
  `paid_time` int(11) DEFAULT '0',
  `pay_ip` bigint(20) DEFAULT '0',
  `pay_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `pay_lcoins` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台币',
  `pay_state` tinyint(1) NOT NULL,
  `transaction_id` varchar(200) DEFAULT NULL,
  `card_no` varchar(100) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `risk` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pay_platform` varchar(50) NOT NULL,
  `is_user` int(11) NOT NULL DEFAULT '0',
  `pay_currency` char(10) NOT NULL DEFAULT 'TWD',
  `union_id` int(16) NOT NULL DEFAULT '1',
  `product_id` int(11) unsigned NOT NULL COMMENT '产品ID',
  `server_id` int(11) unsigned NOT NULL COMMENT '分服ID',
  `ot_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '开放平台处理状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `pay_time` (`pay_time`),
  KEY `paid_time` (`paid_time`),
  KEY `channel_id` (`channel_id`),
  KEY `pay_state` (`pay_state`),
  KEY `phone_no` (`phone_no`),
  KEY `union` (`union_id`,`product_id`,`paid_time`,`channel_id`,`pay_amount`)
) ENGINE=InnoDB AUTO_INCREMENT=1285 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_pay_rebate_ratio
-- ----------------------------
DROP TABLE IF EXISTS `tb_pay_rebate_ratio`;
CREATE TABLE `tb_pay_rebate_ratio` (
  `id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL COMMENT '渠道id',
  `channel_code` varchar(20) DEFAULT NULL COMMENT '渠道标识',
  `appid` int(10) NOT NULL COMMENT '游戏id',
  `plattype` int(6) NOT NULL DEFAULT '0' COMMENT '平台标识（1：安卓 2：ios 3：越狱）',
  `channel_discount` float(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '返利比率 （游戏）',
  `update_time` date NOT NULL COMMENT '修改时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1开启',
  `open_flag` tinyint(2) DEFAULT NULL COMMENT '状态（1：开启2：关闭 0：删除）',
  `agent_discount` float(5,2) DEFAULT NULL COMMENT '代理商提成比例',
  UNIQUE KEY `game-union` (`channel_id`,`plattype`) USING BTREE,
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for tb_recharge_cards
-- ----------------------------
DROP TABLE IF EXISTS `tb_recharge_cards`;
CREATE TABLE `tb_recharge_cards` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL COMMENT '会员id',
  `counts` int(10) DEFAULT NULL COMMENT '充值数量',
  `recharge_id` int(10) DEFAULT NULL COMMENT '充值人id',
  `recharge_name` varchar(255) DEFAULT NULL COMMENT '玩家名称',
  `recharge_time` int(10) DEFAULT NULL COMMENT '充值时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_recharge_order
-- ----------------------------
DROP TABLE IF EXISTS `tb_recharge_order`;
CREATE TABLE `tb_recharge_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL COMMENT '用户id',
  `order_sn` varchar(50) NOT NULL COMMENT '订单编号',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `goods_name` int(10) NOT NULL COMMENT '商品名',
  `discount` decimal(2,2) DEFAULT '0.00' COMMENT '折扣',
  `paytype` tinyint(2) DEFAULT NULL COMMENT '支付类型（0；1：微信支付；2：支付宝）',
  `c_time` int(10) NOT NULL COMMENT '创建时间',
  `paytime` int(10) DEFAULT NULL COMMENT '支付时间',
  `paystate` tinyint(2) DEFAULT '0' COMMENT '支付状态（0：未支付；1：已支付）',
  `o_state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '订单状态（0：关闭或取消；1：正常）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=367 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_recharge_type
-- ----------------------------
DROP TABLE IF EXISTS `tb_recharge_type`;
CREATE TABLE `tb_recharge_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '充值记录id',
  `amount` decimal(10,2) NOT NULL,
  `room_cards` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_sale_order
-- ----------------------------
DROP TABLE IF EXISTS `tb_sale_order`;
CREATE TABLE `tb_sale_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL COMMENT '用户id',
  `order_sn` varchar(50) NOT NULL COMMENT '订单编号',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `goods_name` varchar(255) NOT NULL COMMENT '商品名',
  `discount` decimal(2,2) DEFAULT '0.00' COMMENT '折扣',
  `paytype` tinyint(2) DEFAULT NULL COMMENT '支付类型（0；1：微信支付；2：支付宝）',
  `c_time` int(10) NOT NULL COMMENT '创建时间',
  `paytime` int(10) DEFAULT NULL COMMENT '支付时间',
  `paystate` tinyint(2) DEFAULT '0' COMMENT '支付状态（0：未支付；1：已支付）',
  `o_state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '订单状态（0：关闭或取消；1：正常）',
  `to_id` int(10) DEFAULT NULL COMMENT '玩家id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=177 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_settlement
-- ----------------------------
DROP TABLE IF EXISTS `tb_settlement`;
CREATE TABLE `tb_settlement` (
  `settlement_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '结算id',
  `settlement_no` varchar(30) NOT NULL COMMENT '结算单号',
  `start_time` varchar(20) NOT NULL COMMENT '结算开始时间',
  `end_time` varchar(20) NOT NULL COMMENT '结束时间',
  `s_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0：未结算；1：申请中；2：已拒绝；3：已结算',
  `settlement_amount` decimal(10,2) unsigned NOT NULL COMMENT '结算余额',
  `balance` decimal(10,2) unsigned NOT NULL COMMENT '剩余余额',
  `refuse_msg` text COMMENT '拒绝信息',
  `application_time` int(10) NOT NULL COMMENT '提交时间',
  `processing_time` int(10) NOT NULL COMMENT '处理时间',
  `union_id` varchar(20) NOT NULL COMMENT '渠道id',
  `agent_id` int(10) NOT NULL COMMENT '代理商id',
  PRIMARY KEY (`settlement_id`),
  KEY `status_index` (`s_status`) USING BTREE,
  KEY `union_index` (`union_id`) USING BTREE,
  KEY `agent_index` (`agent_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=417 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_sms
-- ----------------------------
DROP TABLE IF EXISTS `tb_sms`;
CREATE TABLE `tb_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rrid` varchar(50) NOT NULL COMMENT '发送ID',
  `phone` text NOT NULL,
  `content` varchar(255) NOT NULL COMMENT '内容',
  `create_time` timestamp NOT NULL DEFAULT '2000-01-01 00:00:00' COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `stime` varchar(30) NOT NULL DEFAULT '' COMMENT '发送时间',
  `partner_plat` varchar(50) NOT NULL DEFAULT 'md' COMMENT '合作方',
  `return_status` int(11) NOT NULL DEFAULT '-1' COMMENT '返回码，本地意义，0：成功 1：失败',
  `return_message` varchar(500) NOT NULL COMMENT '返回信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='发送短信表';

-- ----------------------------
-- Table structure for tb_sys_action_log
-- ----------------------------
DROP TABLE IF EXISTS `tb_sys_action_log`;
CREATE TABLE `tb_sys_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'default',
  `type` varchar(50) NOT NULL COMMENT '操作类型',
  `title` varchar(100) NOT NULL COMMENT '操作概要',
  `action_detail` text NOT NULL COMMENT '操作详情',
  `user_name` varchar(100) NOT NULL,
  `time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `cat_type` (`category`,`type`),
  KEY `time` (`time`)
) ENGINE=InnoDB AUTO_INCREMENT=2701 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='操作日志';

-- ----------------------------
-- Table structure for tb_sys_config
-- ----------------------------
DROP TABLE IF EXISTS `tb_sys_config`;
CREATE TABLE `tb_sys_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `segment` varchar(30) NOT NULL COMMENT '分类',
  `name` varchar(255) NOT NULL,
  `type` enum('json','string','float','int','object') NOT NULL,
  `value` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统配置';

-- ----------------------------
-- Table structure for tb_sys_privilege
-- ----------------------------
DROP TABLE IF EXISTS `tb_sys_privilege`;
CREATE TABLE `tb_sys_privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `the_group` varchar(50) NOT NULL DEFAULT '0' COMMENT '父ID，主要是管理仅限分组。当authtype为group时表示这是个权限组',
  `authtype` enum('group','name','url','mca','mc','m','mcab') NOT NULL COMMENT '权限方式,如果为subprevilege则代表为角色',
  `privilege_name` varchar(120) NOT NULL COMMENT '权限名',
  `url` varchar(255) NOT NULL,
  `name` varchar(120) NOT NULL,
  `m` varchar(120) NOT NULL,
  `c` varchar(120) NOT NULL,
  `a` varchar(120) NOT NULL,
  `branch` varchar(30) NOT NULL COMMENT '分支，控制ueditor的增删改',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='权限表';

-- ----------------------------
-- Table structure for tb_sys_role
-- ----------------------------
DROP TABLE IF EXISTS `tb_sys_role`;
CREATE TABLE `tb_sys_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL COMMENT '角色名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='角色表';

-- ----------------------------
-- Table structure for tb_sys_role_privilege
-- ----------------------------
DROP TABLE IF EXISTS `tb_sys_role_privilege`;
CREATE TABLE `tb_sys_role_privilege` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL COMMENT '和lmb_role表id字段对应',
  `privilege_id` int(10) unsigned NOT NULL COMMENT '和lmb_privilege表id字段对应',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`,`privilege_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1426 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_sys_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_sys_user`;
CREATE TABLE `tb_sys_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(120) NOT NULL COMMENT '用户名',
  `user_pwd` char(32) NOT NULL COMMENT '密码',
  `email` varchar(120) NOT NULL COMMENT '邮箱地址',
  `phone` varchar(120) NOT NULL COMMENT '电话号码',
  `gender` enum('male','female') NOT NULL COMMENT '性别',
  `leader` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '相关负责人',
  `nick_name` varchar(255) NOT NULL COMMENT '昵称',
  `extend` text,
  `user_coins` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_no` varchar(50) NOT NULL DEFAULT '' COMMENT '身份证',
  `user_level` int(5) DEFAULT '0',
  `addtime` int(10) DEFAULT NULL COMMENT '加入时间',
  `wexin` varchar(50) DEFAULT NULL COMMENT '微信号',
  `addr` varchar(255) DEFAULT NULL COMMENT '地址',
  `ser_addr` varchar(50) DEFAULT NULL COMMENT '服务城市',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_sys_user_role
-- ----------------------------
DROP TABLE IF EXISTS `tb_sys_user_role`;
CREATE TABLE `tb_sys_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '对应lmb_user表id字段',
  `role_id` int(10) unsigned NOT NULL COMMENT '对应lmb_role表id字段',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_sys_user_union
-- ----------------------------
DROP TABLE IF EXISTS `tb_sys_user_union`;
CREATE TABLE `tb_sys_user_union` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '对应tb_user表id字段',
  `union_id` int(10) NOT NULL COMMENT '对应tb_unionlist表id字段',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`union_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_unionlist
-- ----------------------------
DROP TABLE IF EXISTS `tb_unionlist`;
CREATE TABLE `tb_unionlist` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(100) NOT NULL COMMENT '联盟名',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '渠道标识',
  `product_id` int(11) DEFAULT '0' COMMENT '游戏id',
  `plattype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '平台类型，1:安卓,2:ios,3:越狱',
  `open_flag` tinyint(4) NOT NULL DEFAULT '2' COMMENT '状态，1打开，2关闭，0删除',
  `sys_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '本平台管理员ID，一般是渠道创建者',
  `tmp_package_version` varchar(10) NOT NULL DEFAULT '' COMMENT '临时包版本',
  `package_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '打包状态,0:初始状态,1:正在打包,3:打包成功,4:打包失败',
  `package_url` varchar(255) NOT NULL DEFAULT '' COMMENT '临时下载路径',
  `cdn_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'cdn下载地址',
  `cdn_package_version` varchar(10) NOT NULL DEFAULT '' COMMENT 'cdn包版本',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '包状态,1初始状态，2已生成临时包，3已推送到cdn',
  PRIMARY KEY (`id`),
  KEY `sys_user` (`sys_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='渠道表';

-- ----------------------------
-- Table structure for tb_user_level
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_level`;
CREATE TABLE `tb_user_level` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(50) NOT NULL COMMENT '等级名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '描述',
  `user_rebate` decimal(4,2) DEFAULT NULL COMMENT '用户返利',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_user_list
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_list`;
CREATE TABLE `tb_user_list` (
  `ktuid` int(11) NOT NULL COMMENT '开天用户id',
  `username` varchar(50) DEFAULT NULL COMMENT '用户账号',
  `nickname` varchar(50) DEFAULT NULL COMMENT '角色名',
  `channel` varchar(50) DEFAULT NULL COMMENT '渠道标识',
  `cps_channel` varchar(50) DEFAULT NULL COMMENT '子渠道',
  `userphone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ktuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_user_rebate
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_rebate`;
CREATE TABLE `tb_user_rebate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL COMMENT '会员id',
  `rebate` decimal(4,2) DEFAULT NULL COMMENT '比例',
  `counts` int(10) DEFAULT NULL COMMENT '数量',
  `re_time` int(10) DEFAULT NULL COMMENT '返利时间',
  `to_id` int(10) DEFAULT NULL COMMENT '返利给用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `tb_withdraw`;
CREATE TABLE `tb_withdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL COMMENT '代理商ID',
  `request_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deal_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '处理状态，1、已经申请  2、已取消申请 3、已拒绝  4、已完成提现',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `game_id` int(11) NOT NULL DEFAULT '0' COMMENT '0',
  `union_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `agent` (`agent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
