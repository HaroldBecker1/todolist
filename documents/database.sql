CREATE DATABASE IF NOT EXISTS todolist;

USE todolist;

CREATE TABLE IF NOT EXISTS task (
    uuid INT NOT NULL AUTO_INCREMENT,
    type VARCHAR(60) NOT NULL,
    content VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL,
    done BOOLEAN NOT NULL,
    date_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid)
);

ALTER TABLE task ADD INDEX (uuid);
