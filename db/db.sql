-- Dropping tables for development purposes
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Photos;
DROP TABLE IF EXISTS Registration;
DROP TABLE IF EXISTS Entrance_fee;
DROP TABLE IF EXISTS Event_instance;
DROP TABLE IF EXISTS Address;
DROP TABLE IF EXISTS Event;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Account;

CREATE TABLE Account (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(256) NOT NULL,
    first_name VARCHAR(128),
    last_name VARCHAR(128),
    nick VARCHAR(128),
    password VARCHAR(128),
    account_type VARCHAR(32),
    photo BLOB,
    status VARCHAR(64)
);

CREATE TABLE Category (
    category_name VARCHAR(128) PRIMARY KEY,
    description MEDIUMTEXT,
    time_of_creation DATETIME,
    status VARCHAR(64),

    super_category VARCHAR(128),
    account_id INT,

    CONSTRAINT fk_super_category
    FOREIGN KEY (super_category)
    REFERENCES Category(category_name),

    CONSTRAINT fk_category_proposed_by_account
    FOREIGN KEY (account_id)
    REFERENCES Account(id)
);

CREATE TABLE Event (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(128),
    description MEDIUMTEXT,
    icon BLOB,
    rating FLOAT,
    time_of_creation DATETIME,
    time_of_last_edit DATETIME,
    status VARCHAR(64),

    category_name VARCHAR(128),
    owner_id INT,

    CONSTRAINT fk_event_category
    FOREIGN KEY (category_name)
    REFERENCES Category(category_name),

    CONSTRAINT fk_event_owner /* merged owner and proposal statuses - they can
                                 be differentiated in the status field */

    FOREIGN KEY (owner_id)
    REFERENCES Account(id)
);

CREATE TABLE Address (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Country VARCHAR(128),
    zip INT,
    city VARCHAR(128),
    street VARCHAR(128),
    street_number VARCHAR(128), -- VARCHAR so it is possible to type 1982/54 etc.
    state VARCHAR(128),
    description MEDIUMTEXT,
    date_of_creation DATETIME,
    status VARCHAR(64),
    account_id INT,

    CONSTRAINT fk_address_proposed_by_account
    FOREIGN KEY (account_id)
    REFERENCES Account(id)
);

CREATE TABLE Event_instance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    address_id INT,
    time_from DATETIME,
    time_to DATETIME,

    CONSTRAINT fk_instance_of_event
    FOREIGN KEY (event_id)
    REFERENCES Event(id) ON DELETE CASCADE,

    CONSTRAINT fk_address_of_instance
    FOREIGN KEY (address_id)
    REFERENCES Address(id) ON DELETE CASCADE
);

CREATE TABLE Entrance_fee (
    instance_id INT,
    name VARCHAR(128),
    shopping_method VARCHAR(64),
    cost DECIMAL,
    max_tickets INT,
    sold_tickets INT,

    PRIMARY KEY(instance_id, name),

    CONSTRAINT fk_event_instance_fee
    FOREIGN KEY (instance_id)
    REFERENCES Event_instance(id) ON DELETE CASCADE
);

CREATE TABLE Registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT,
    instance_id INT,
    time_of_confirmation DATETIME,
    fee_name VARCHAR(128),

    CONSTRAINT fk_fee_registration
    FOREIGN KEY (instance_id, fee_name)
    REFERENCES Entrance_fee(instance_id, name) ON DELETE CASCADE,

    CONSTRAINT fk_account_registered
    FOREIGN KEY (owner_id)
    REFERENCES Account(id) ON DELETE CASCADE
);

CREATE TABLE Photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    photo BLOB,

    event_id INT,
    address_id INT,

    CONSTRAINT fk_event_photo
    FOREIGN KEY (event_id)
    REFERENCES Event(id) ON DELETE CASCADE,

    CONSTRAINT fk_address_photo
    FOREIGN KEY (address_id)
    REFERENCES Address(id) ON DELETE CASCADE
);

CREATE TABLE Comment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    time_of_posting DATETIME,
    comment_text MEDIUMTEXT,

    author_id INT,
    super_comment INT,
    event_id INT,

    CONSTRAINT fk_comment_author
    FOREIGN KEY (author_id)
    REFERENCES Account(id),

    CONSTRAINT fk_super_comment
    FOREIGN KEY (super_comment)
    REFERENCES Comment(id) ON DELETE CASCADE,

    CONSTRAINT fk_comment_on_event
    FOREIGN KEY (event_id)
    REFERENCES Event(id) ON DELETE CASCADE
);
