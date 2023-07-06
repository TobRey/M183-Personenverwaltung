CREATE TABLE user(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255)
);

CREATE TABLE type(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(255)
);

CREATE TABLE person(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    type_id INT,
    firstname VARCHAR(255),
    lastname MEDIUMTEXT,
    completed TINYINT,
    FOREIGN KEY(user_id) REFERENCES user(id),
    FOREIGN KEY(type_id) REFERENCES type(id)
);

INSERT INTO type(label) VALUES ("ToDo"), ("Bug"), ("Improvement"), ("Feature");