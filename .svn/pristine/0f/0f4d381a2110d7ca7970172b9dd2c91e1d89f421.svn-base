
INSERT INTO `tb_sys_privilege` VALUES
  (1,'index','m','首页','','','index','','',''),
  (10,'privilege','m','用户、权限管理','','','user','','','del'),
  (12,'system','m','系统设置','','','admin','','','add,update'),
  (116,'sysuser','m','后台用户管理','','','sysuser','','',''),
  (121,'cps','m','CPS管理','','','cps_manage','','',''),
  (122,'cps','mc','CA查看订单','','','cps_agent','ca_orders','index','read'),
  (123,'cps','mcab','CA查看用户','','','cps_agent','ca_users','index','read'),
  (124,'cps','mcab','CA查看渠道','','','cps_agent','ca_unions','index','read'),
  (125,'cps','m','CPS代理商','','','cps_agent','','',''),
  (126,'cps','mc','CA管理提现','','','cps_agent','ca_withdraw','','read,add'),
  (127,'cps','mcab','CA查看结算单','','','cps_agent','ca_settlement','index','read');

INSERT INTO tb_sys_role VALUES
  (1,'超级管理员'),
  (2,'开发人员'),
  (3,'网站编辑'),
  (4,'CPS管理'),
  (5,'CPS代理');

insert INTO tb_sys_role_privilege(role_id, privilege_id) VALUES
  (1,1),
  (1,10),
  (1,12),
  (1,116),
  (1,121),
  (1,122),
  (1,123),
  (1,124),
  (1,125),
  (1,126),
  (1,127),
  (4,1),
  (4,121),
  (4,122),
  (4,123),
  (4,124),
  (4,125),
  (4,126),
  (4,127);

-- 添加管理用户
insert INTO tb_sys_user (`user_name`, user_pwd, nick_name,leader) VALUES('1','c4ca4238a0b923820dcc509a6f75849b','1',1);
insert INTO tb_sys_user_role(user_id, role_id) VALUES(1,1);


select *
from
  tb_sys_user_role as ur
  left join tb_sys_user as u on u.id=ur.user_id
  left join tb_sys_role as r on r.id=ur.role_id
  left join tb_sys_role_privilege as rp on rp.role_id = r.id
  left join tb_sys_privilege as p on p.id=rp.privilege_id
where u.id=1;