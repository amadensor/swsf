
drop table actions cascade;
drop table role_actions cascade;
drop table roles cascade;
drop table service_actions cascade;
drop table services cascade;
drop table user_roles cascade;
drop table users cascade;
drop table sessions cascade;
drop table log_messages cascade;
drop table queue cascade;

create table users
(userid serial
,login text
,pass text
,primary key(userid)
);

create unique index login_id on users(login);


create table roles
(role_name text
,description text
,primary key(role_name)
);


create table services
(service_name text
,description text
,primary key(service_name)
);

create table actions
(
action text
,description text
,primary key(action)
);

create table role_actions
(role_name text references roles(role_name)
,service_name text references services(service_name)
,action text references actions(action)
,primary key(role_name,service_name,action)
);

create table user_roles
(userid integer references users(userid)
,role_name text references roles(role_name)
,primary key(userid,role_name)
);


create table service_actions
(service_name text references services(service_name)
,action text
,function text
,primary key(service_name, action)
);

create table sessions
(userid integer references users(userid)
,key text
,primary key(userid)
);

create table log_messages
(
userid integer references users(userid)
,execution_dttm timestamp
,key text
,request jsonb
,response jsonb
,messages text
,primary key(userid,execution_dttm,key)
);

create table queue
(
transactionid serial
,userid integer references users (userid)
,arrival_dttm timestamp
,execution_dttm timestamp
,request jsonb
,response jsonb
,primary key(transactionid)
);

create index queue_idx
on queue(userid,arrival_dttm);

grant select,insert,update,delete on actions to "swsf";
grant select,insert,update,delete on role_actions to "swsf";
grant select,insert,update,delete on roles to "swsf";
grant select,insert,update,delete on service_actions to "swsf";
grant select,insert,update,delete on services to "swsf";
grant select,insert,update,delete on user_roles to "swsf";
grant select,insert,update,delete on users to "swsf";
grant usage on users_userid_seq to swsf;
grant select,insert,update,delete on sessions to "swsf";
grant select,insert,update,delete on log_messages to "swsf";
grant select,insert,update,delete on queue to "swsf";
grant usage on queue_transactionid_seq to "swsf";

insert into users (login,pass) values ('admin','reset');

insert into services (service_name,description) values('role_action','Actions a role can perform');
insert into services (service_name,description) values('role','Roles that can be assigned');
insert into services (service_name,description) values('logs','Log messages');
insert into services (service_name,description) values('action','Actions that exist');
insert into services (service_name,description) values('service','Services that exist');
insert into services (service_name,description) values('service_action','Actions for services');
insert into services (service_name,description) values('user','System users');
insert into services (service_name,description) values('user_role','Roles assigned to users');
insert into services (service_name,description) values('login','Login and logout');

insert into actions (action,description) values ('get','Retrieve');
insert into actions (action,description) values ('add','Add');
insert into actions (action,description) values ('update','update');
insert into actions (action,description) values ('search','Find');
insert into actions (action,description) values ('delete','Remove');
insert into actions (action,description) values ('list','List Items');

insert into service_actions (service_name,action,function) values ('role','list','list_roles');
insert into service_actions (service_name,action,function) values ('role','add','add_role');
insert into service_actions (service_name,action,function) values ('role','update','update_role');
insert into service_actions (service_name,action,function) values ('role','delete','delete_role');
insert into service_actions (service_name,action,function) values ('role_action','get','get_role_action');
insert into service_actions (service_name,action,function) values ('role_action','add','add_role_action');
insert into service_actions (service_name,action,function) values ('role_action','delete','delete_role_action');
insert into service_actions (service_name,action,function) values ('action','list','list_actions');
insert into service_actions (service_name,action,function) values ('service','list','list_services');
insert into service_actions (service_name,action,function) values ('service','add','add_service');
insert into service_actions (service_name,action,function) values ('service','update','update_service');
insert into service_actions (service_name,action,function) values ('service','delete','delete_service');
insert into service_actions (service_name,action,function) values ('action','add','add_action');
insert into service_actions (service_name,action,function) values ('action','update','update_action');
insert into service_actions (service_name,action,function) values ('action','delete','delete_action');
insert into service_actions (service_name,action,function) values ('service_action','list','list_service_action');
insert into service_actions (service_name,action,function) values ('service_action','add','add_service_action');
insert into service_actions (service_name,action,function) values ('service_action','update','update_service_action');
insert into service_actions (service_name,action,function) values ('service_action','delete','delete_service_action');
insert into service_actions (service_name,action,function) values ('user','list','list_users');
insert into service_actions (service_name,action,function) values ('user_role','list','list_user_roles');
insert into service_actions (service_name,action,function) values ('user_role','add','add_user_role');
insert into service_actions (service_name,action,function) values ('user_role','delete','delete_user_role');
insert into service_actions (service_name,action,function) values ('login','get','login_service');
insert into service_actions (service_name,action,function) values ('login','delete','logout_service');

insert into roles (role_name,description) values('public','Public');
insert into roles (role_name,description) values('admin','Administrator');

insert into role_actions (role_name,service_name,action) values ('admin','role_action','search');
insert into role_actions (role_name,service_name,action) values ('admin','role','list');
insert into role_actions (role_name,service_name,action) values ('admin','role','add');
insert into role_actions (role_name,service_name,action) values ('admin','role','update');
insert into role_actions (role_name,service_name,action) values ('admin','role','delete');
insert into role_actions (role_name,service_name,action) values ('admin','role_action','get');
insert into role_actions (role_name,service_name,action) values ('admin','role_action','update');
insert into role_actions (role_name,service_name,action) values ('admin','role_action','add');
insert into role_actions (role_name,service_name,action) values ('admin','role_action','delete');
insert into role_actions (role_name,service_name,action) values ('admin','logs','list');
insert into role_actions (role_name,service_name,action) values ('admin','action','list');
insert into role_actions (role_name,service_name,action) values ('admin','action','add');
insert into role_actions (role_name,service_name,action) values ('admin','action','update');
insert into role_actions (role_name,service_name,action) values ('admin','action','delete');
insert into role_actions (role_name,service_name,action) values ('admin','service','list');
insert into role_actions (role_name,service_name,action) values ('admin','service','add');
insert into role_actions (role_name,service_name,action) values ('admin','service','update');
insert into role_actions (role_name,service_name,action) values ('admin','service','delete');
insert into role_actions (role_name,service_name,action) values ('admin','service_action','list');
insert into role_actions (role_name,service_name,action) values ('admin','service_action','add');
insert into role_actions (role_name,service_name,action) values ('admin','service_action','update');
insert into role_actions (role_name,service_name,action) values ('admin','service_action','delete');
insert into role_actions (role_name,service_name,action) values ('admin','user','list');
insert into role_actions (role_name,service_name,action) values ('admin','user_role','list');
insert into role_actions (role_name,service_name,action) values ('admin','user_role','add');
insert into role_actions (role_name,service_name,action) values ('admin','user_role','delete');
insert into role_actions (role_name,service_name,action) values ('public','login','get');
insert into role_actions (role_name,service_name,action) values ('public','login','delete');

insert into user_roles (userid,role_name) (select userid,'admin' from users where login='admin');

insert into users (login) values('public');
insert into user_roles (userid,role_name) (select userid,'public' from users where login='public');
