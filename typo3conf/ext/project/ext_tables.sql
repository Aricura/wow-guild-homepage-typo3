CREATE TABLE tt_content (
  tx_project_content_carousel_slides INT(11),
  tx_project_image_square            INT(11),
  tx_project_content_wheel_slides    INT(11)
);

CREATE TABLE tx_wow_battle_groups (
  uid       INT(11)    NOT NULL AUTO_INCREMENT,
  pid       INT(11)    NOT NULL DEFAULT '0',
  tstamp    INT(11)    NOT NULL DEFAULT '0',
  crdate    INT(11)    NOT NULL DEFAULT '0',
  cruser_id INT(11)    NOT NULL DEFAULT '0',
  sorting   INT(11)    NOT NULL DEFAULT '0',
  deleted   TINYINT(1) NOT NULL DEFAULT '0',
  hidden    TINYINT(1) NOT NULL DEFAULT '0',

  slug      VARCHAR(255),
  name      VARCHAR(255),

  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_wow_realms (
  uid                     INT(11)    NOT NULL AUTO_INCREMENT,
  pid                     INT(11)    NOT NULL DEFAULT '0',
  tstamp                  INT(11)    NOT NULL DEFAULT '0',
  crdate                  INT(11)    NOT NULL DEFAULT '0',
  cruser_id               INT(11)    NOT NULL DEFAULT '0',
  sorting                 INT(11)    NOT NULL DEFAULT '0',
  deleted                 TINYINT(1) NOT NULL DEFAULT '0',
  hidden                  TINYINT(1) NOT NULL DEFAULT '0',

  tx_wow_battle_group_uid INT(11),
  slug                    VARCHAR(255),
  name                    VARCHAR(255),
  type                    VARCHAR(255),
  population              VARCHAR(255),
  locale                  VARCHAR(8),

  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_wow_fractions (
  uid       INT(11)    NOT NULL AUTO_INCREMENT,
  pid       INT(11)    NOT NULL DEFAULT '0',
  tstamp    INT(11)    NOT NULL DEFAULT '0',
  crdate    INT(11)    NOT NULL DEFAULT '0',
  cruser_id INT(11)    NOT NULL DEFAULT '0',
  sorting   INT(11)    NOT NULL DEFAULT '0',
  deleted   TINYINT(1) NOT NULL DEFAULT '0',
  hidden    TINYINT(1) NOT NULL DEFAULT '0',

  slug      VARCHAR(255),
  name      VARCHAR(255),

  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_wow_races (
  uid                 INT(11)    NOT NULL AUTO_INCREMENT,
  pid                 INT(11)    NOT NULL DEFAULT '0',
  tstamp              INT(11)    NOT NULL DEFAULT '0',
  crdate              INT(11)    NOT NULL DEFAULT '0',
  cruser_id           INT(11)    NOT NULL DEFAULT '0',
  sorting             INT(11)    NOT NULL DEFAULT '0',
  deleted             TINYINT(1) NOT NULL DEFAULT '0',
  hidden              TINYINT(1) NOT NULL DEFAULT '0',

  foreign_id          INT(11),
  tx_wow_fraction_uid INT(11),
  mask                INT(11),
  name                VARCHAR(255),

  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_wow_classes (
  uid        INT(11)    NOT NULL AUTO_INCREMENT,
  pid        INT(11)    NOT NULL DEFAULT '0',
  tstamp     INT(11)    NOT NULL DEFAULT '0',
  crdate     INT(11)    NOT NULL DEFAULT '0',
  cruser_id  INT(11)    NOT NULL DEFAULT '0',
  sorting    INT(11)    NOT NULL DEFAULT '0',
  deleted    TINYINT(1) NOT NULL DEFAULT '0',
  hidden     TINYINT(1) NOT NULL DEFAULT '0',

  foreign_id INT(11),
  mask       INT(11),
  name       VARCHAR(255),
  power_type VARCHAR(255),

  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_wow_class_specialisations (
  uid              INT(11)    NOT NULL AUTO_INCREMENT,
  pid              INT(11)    NOT NULL DEFAULT '0',
  tstamp           INT(11)    NOT NULL DEFAULT '0',
  crdate           INT(11)    NOT NULL DEFAULT '0',
  cruser_id        INT(11)    NOT NULL DEFAULT '0',
  sorting          INT(11)    NOT NULL DEFAULT '0',
  deleted          TINYINT(1) NOT NULL DEFAULT '0',
  hidden           TINYINT(1) NOT NULL DEFAULT '0',

  tx_wow_class_uid INT(11),
  name             VARCHAR(255),
  background_image VARCHAR(255),
  icon             VARCHAR(255),

  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_wow_guilds (
  uid                 INT(11)    NOT NULL AUTO_INCREMENT,
  pid                 INT(11)    NOT NULL DEFAULT '0',
  tstamp              INT(11)    NOT NULL DEFAULT '0',
  crdate              INT(11)    NOT NULL DEFAULT '0',
  cruser_id           INT(11)    NOT NULL DEFAULT '0',
  sorting             INT(11)    NOT NULL DEFAULT '0',
  deleted             TINYINT(1) NOT NULL DEFAULT '0',
  hidden              TINYINT(1) NOT NULL DEFAULT '0',

  tx_wow_realm_uid    INT(11),
  tx_wow_fraction_uid INT(11),
  name                VARCHAR(255),
  level               INT(11),
  achievement_points  INT(11),
  last_modified       DATETIME            DEFAULT NULL,

  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_wow_guild_members (
  uid                             INT(11)    NOT NULL AUTO_INCREMENT,
  pid                             INT(11)    NOT NULL DEFAULT '0',
  tstamp                          INT(11)    NOT NULL DEFAULT '0',
  crdate                          INT(11)    NOT NULL DEFAULT '0',
  cruser_id                       INT(11)    NOT NULL DEFAULT '0',
  sorting                         INT(11)    NOT NULL DEFAULT '0',
  deleted                         TINYINT(1) NOT NULL DEFAULT '0',
  hidden                          TINYINT(1) NOT NULL DEFAULT '0',

  tx_wow_guild_uid                INT(11),
  tx_wow_realm_uid                INT(11),
  tx_wow_race_uid                 INT(11),
  tx_wow_class_uid                INT(11),
  tx_wow_class_specialisation_uid INT(11),
  guild_rank                      INT(11),
  gender                          INT(11),
  name                            VARCHAR(255),
  level                           INT(11),
  achievement_points              INT(11),
  thumbnail                       VARCHAR(255),
  item_level_equipped             DOUBLE,
  item_level_total                DOUBLE,
  last_modified                   DATETIME            DEFAULT NULL,
  is_raid_member                  TINYINT(1),

  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_project_content_carousel_slides (
  uid          INT(11)    NOT NULL AUTO_INCREMENT,
  pid          INT(11)    NOT NULL DEFAULT '0',
  tstamp       INT(11)    NOT NULL DEFAULT '0',
  crdate       INT(11)    NOT NULL DEFAULT '0',
  cruser_id    INT(11)    NOT NULL DEFAULT '0',
  sorting      INT(11)    NOT NULL DEFAULT '0',
  deleted      TINYINT(1) NOT NULL DEFAULT '0',
  hidden       TINYINT(1) NOT NULL DEFAULT '0',
  starttime    INT(11)    NOT NULL DEFAULT '0',
  endtime      INT(11)    NOT NULL DEFAULT '0',
  parent_id    INT(11)             DEFAULT NULL,
  parent_table VARCHAR(255)        DEFAULT NULL,

  title        VARCHAR(100),
  bodytext     VARCHAR(255),
  image        INT(11)             DEFAULT NULL,
  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_project_content_wheel_slides (
  uid          INT(11)    NOT NULL AUTO_INCREMENT,
  pid          INT(11)    NOT NULL DEFAULT '0',
  tstamp       INT(11)    NOT NULL DEFAULT '0',
  crdate       INT(11)    NOT NULL DEFAULT '0',
  cruser_id    INT(11)    NOT NULL DEFAULT '0',
  sorting      INT(11)    NOT NULL DEFAULT '0',
  deleted      TINYINT(1) NOT NULL DEFAULT '0',
  hidden       TINYINT(1) NOT NULL DEFAULT '0',
  starttime    INT(11)    NOT NULL DEFAULT '0',
  endtime      INT(11)    NOT NULL DEFAULT '0',
  parent_id    INT(11)             DEFAULT NULL,
  parent_table VARCHAR(255)        DEFAULT NULL,

  title        VARCHAR(100),
  bodytext     MEDIUMTEXT,
  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_wow_raids (
  uid                INT(11)    NOT NULL AUTO_INCREMENT,
  pid                INT(11)    NOT NULL DEFAULT '0',
  tstamp             INT(11)    NOT NULL DEFAULT '0',
  crdate             INT(11)    NOT NULL DEFAULT '0',
  cruser_id          INT(11)    NOT NULL DEFAULT '0',
  sorting            INT(11)    NOT NULL DEFAULT '0',
  deleted            TINYINT(1) NOT NULL DEFAULT '0',
  hidden             TINYINT(1) NOT NULL DEFAULT '0',
  starttime          INT(11)    NOT NULL DEFAULT '0',
  endtime            INT(11)    NOT NULL DEFAULT '0',

  title              VARCHAR(100),
  image              INT(11)             DEFAULT NULL,
  tx_wow_raid_bosses INT(11),
  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_wow_raid_bosses (
  uid               INT(11)    NOT NULL AUTO_INCREMENT,
  pid               INT(11)    NOT NULL DEFAULT '0',
  tstamp            INT(11)    NOT NULL DEFAULT '0',
  crdate            INT(11)    NOT NULL DEFAULT '0',
  cruser_id         INT(11)    NOT NULL DEFAULT '0',
  sorting           INT(11)    NOT NULL DEFAULT '0',
  deleted           TINYINT(1) NOT NULL DEFAULT '0',
  hidden            TINYINT(1) NOT NULL DEFAULT '0',
  starttime         INT(11)    NOT NULL DEFAULT '0',
  endtime           INT(11)    NOT NULL DEFAULT '0',
  parent_id         INT(11)             DEFAULT NULL,
  parent_table      VARCHAR(255)        DEFAULT NULL,

  title             VARCHAR(100),
  first_kill_normal DATE                DEFAULT NULL,
  first_kill_heroic DATE                DEFAULT NULL,
  first_kill_mythic DATE                DEFAULT NULL,
  PRIMARY KEY (uid),
  KEY parent (pid)
);
