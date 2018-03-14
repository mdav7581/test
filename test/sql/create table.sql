CREATE TABLE auth (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(100),
password VARCHAR(100),
created_date datetime,
updated_date datetime,
created_by INT(6) UNSIGNED,
updated_by INT(6) UNSIGNED
)

CREATE TABLE session (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user_id INT(6) UNSIGNED,
token VARCHAR(100),
token_expiry_date datetime,
created_date datetime,
updated_date datetime,
created_by INT(6) UNSIGNED,
updated_by INT(6) UNSIGNED
)

CREATE TABLE audit (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user_id INT(6) UNSIGNED,
category VARCHAR(100),
label VARCHAR(100),
info BLOB,
created_date datetime,
updated_date datetime,
created_by INT(6) UNSIGNED,
updated_by INT(6) UNSIGNED
)

CREATE TABLE data (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
data BLOB,
created_date datetime,
updated_date datetime,
created_by INT(6) UNSIGNED,
updated_by INT(6) UNSIGNED
)

CREATE TABLE accessor (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user_id INT(6) UNSIGNED,
data_id INT(6) UNSIGNED,
type VARCHAR(100),
filter BLOB,
created_date datetime,
updated_date datetime,
created_by INT(6) UNSIGNED,
updated_by INT(6) UNSIGNED
)


