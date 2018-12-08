# OKA_Nwe_CTO

Таблица "kkm_info'
---------------------
~~~
create table kkm_info
(
  id                int                  not null
    primary key,
  date_upd          datetime             not null comment 'Дата внесения информации',
  mex_code          int                  not null comment 'Код механника',
  name_org          varchar(200)         null comment 'Название организации',
  inn               int        default 0 not null comment 'ИНН организации',
  kkm_model         varchar(200)         null comment 'Модель ККМ',
  kkm_number        int        default 0 not null comment 'Заводской номер ККМ',
  kkm_sno           char                 null comment 'Система налогооблажения',
  kkm_firmware      varchar(20)          null comment 'Номер текущей прошивки',
  fn_size           int(2)     default 0 not null comment 'Срок действия ФН в месяцах',
  fn_protocol       varchar(5)           null comment 'Протокол обмена ФН',
  sub_firmware      date                 null comment 'Подписка на сервис обновлений',
  auto_upd_firmware tinyint(1) default 0 not null comment 'Автоматическое обновление прошивки',
  groups_product    char                 null comment 'Группы товаров',
  constraint kkm_info_kkm_number_uindex
    unique (kkm_number)
)
  comment 'Информация по ккм';

~~~

Таблица "zayavki'
---------------------
~~~
create table zayavki
(
  idz        int auto_increment
    primary key,
  nomer      varchar(11)                 not null,
  client     varchar(30)                 not null,
  adress     varchar(100)                not null,
  mexcod     varchar(24)                 not null,
  problema   varchar(2000)               null,
  comment    varchar(2000)               null,
  vipolnil   int         default 0       not null,
  vipolnilpc int         default 0       not null,
  prinal     int         default 0       not null,
  prinalpc   int         default 0       not null,
  time       int                         not null,
  data       varchar(10) default ''      not null,
  datatime   varchar(5)  default '00:00' not null,
  datasort   varchar(8)  default ''      not null
)
comment 'Заявки клиентов в СЦ';
~~~