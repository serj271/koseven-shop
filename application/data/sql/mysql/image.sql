USE shop33;
SET NAMES utf8;
DROP TABLE IF EXISTS image ;
CREATE TABLE image(
    id int(11) NOT NULL  auto_increment,
    caption TEXT NOT NULL default '',
    comment TEXT NOT NULL default '',
    exifData varchar(50) NOT NULL default '',
    representativeOfPage tinyint(1) unsigned DEFAULT '0',
    thumbnail int(11) NOT NULL default '1',
    bitrate TEXT NOT NULL default '',
    contentSize varchar(256) NOT NULL default '',
    contentUrl varchar(256) NOT NULL default '',
    thumbnailUrl varchar(256) NOT NULL default '',
    height varchar(11),
    width varchar(11),
    position varchar(11),
    uploadDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    copyrightHolder TEXT NOT NULL default '',
    PRIMARY KEY(id)
);
GRANT select, update, insert, delete ON shop33.image TO 'user_db'@'localhost';