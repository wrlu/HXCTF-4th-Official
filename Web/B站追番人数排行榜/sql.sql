create database web5;
use web5;

create table anime(
    id varchar(100) primary key not null,
    name varchar(200) not null,
    rate int not null
)  ENGINE=MyISAM DEFAULT CHARSET=utf8;

insert into anime values(1,'紫罗兰永恒花园',387),(2,'欢迎来到实力至上主义的教室',376),(3,'Re：从零开始的异世界生活',368),(4,'埃罗芒阿老师',358),(5,'在下坂本，有何贵干？',318),(6,'OVERLORDⅡ',313),(7,'小林家的龙女仆',303),(8,'干物妹！小埋R',301),(9,'Fate/Apocrypha',297),(10,'魔卡少女樱 CLEAR CARD篇',243),(11,'Re:CREATORS',241),(12,'干物妹！小埋',232),(13,'徒然喜欢你',226),(14,'如果有妹妹就好了。',212),(15,'Fate/stay night [Unlimited Blade Works] 第一季',203),(16,'Fate/EXTRA Last Encore',202);

create table secret(
	id int primary key not null,
    s3cret varchar(200) not null
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

insert into secret value(1,'HXCTF{D4TE-4-L1V3}');

create user 'yiruma'@'localhost' identified by 'kaoyanyaojin';
grant all privileges on `web5`.* to 'yiruma'@'localhost' identified by 'kaoyanyaojin';
