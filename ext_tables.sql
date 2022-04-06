# noinspection SqlNoDataSourceInspectionForFile

CREATE TABLE tx_socialdata_domain_model_feed (
    name varchar(255) DEFAULT '' NOT NULL,
    storage_pid int(11) unsigned,
    connector_identifier varchar(255) DEFAULT '' NOT NULL,
    connector_configuration mediumtext,
    connector_status tinytext,
    posts int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_socialdata_domain_model_post (
    type varchar(100) NOT NULL DEFAULT '0',
    social_id varchar(255) NOT NULL DEFAULT '',

    feed int(11) unsigned NOT NULL,

    datetime bigint(20) unsigned DEFAULT '0' NOT NULL,
    title tinytext,
    content mediumtext,
    url text,
    media_url text,
    poster_url text,

    KEY feed (feed),
    KEY social_id (social_id)
);

CREATE TABLE tx_socialdata_domain_model_wall (
    name varchar(255) DEFAULT '' NOT NULL,
    feeds int(11) unsigned
);
