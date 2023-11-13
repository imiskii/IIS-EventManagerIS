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

-- Account table
INSERT INTO Account (email, first_name, last_name, nick, password, account_type, photo, status)
VALUES
    ('jan.novak@email.cz', 'Jan', 'Novák', 'jannov', 'hashed_password', 'regular', NULL, 'active'),
    ('eva.hodkova@email.cz', 'Eva', 'Hodková', 'evahod', 'hashed_password', 'regular', NULL, 'active'),
    ('petr.kral@email.cz', 'Petr', 'Král', 'petrkra', 'hashed_password', 'regular', NULL, 'active'),
    ('katerina.svobodova@email.cz', 'Kateřina', 'Svobodová', 'katisvo', 'hashed_password', 'regular', NULL, 'active'),
    ('marek.jelinek@email.cz', 'Marek', 'Jelínek', 'marejel', 'hashed_password', 'regular', NULL, 'active'),
    ('martina.hermanova@email.cz', 'Martina', 'Hermanová', 'marther', 'hashed_password', 'regular', NULL, 'active'),
    ('ondrej.nemec@email.cz', 'Ondřej', 'Němec', 'ondrnem', 'hashed_password', 'regular', NULL, 'active'),
    ('veronika.havlickova@email.cz', 'Veronika', 'Havlíčková', 'verhav', 'hashed_password', 'regular', NULL, 'active'),
    ('adam.dolezal@email.cz', 'Adam', 'Doležal', 'adadol', 'hashed_password', 'regular', NULL, 'active'),
    ('nikola.bartosova@email.cz', 'Nikola', 'Bartošová', 'nikbart', 'hashed_password', 'regular', NULL, 'active');

-- Category table
INSERT INTO Category (category_name, description, time_of_creation, status, super_category, account_id)
VALUES
    ('Hudební Události', 'Kategorie pro hudební události jako festivaly a koncerty', NOW(), 'Active', NULL, 1),
    ('Koncerty', 'Kategorie pro koncerty', NOW(), 'aktivní', 'Hudební Události', 1),
    ('Divadlo', 'Kategorie pro divadelní představení', NOW(), 'aktivní', NULL, 2),
    ('Výstavy', 'Kategorie pro výstavy a galerie', NOW(), 'aktivní', NULL, 3),
    ('Festivaly', 'Kategorie pro festivaly', NOW(), 'aktivní', 'Hudební Události', 4),
    ('Workshopy', 'Kategorie pro vzdělávací workshopy', NOW(), 'aktivní', NULL, 5),
    ('Kino', 'Kategorie pro kino a filmové projekce', NOW(), 'aktivní', NULL, 6),
    ('Sportovní akce', 'Kategorie pro sportovní akce', NOW(), 'aktivní', NULL, 7),
    ('Zábavní parky', 'Kategorie pro návštěvu zábavních parků', NOW(), 'aktivní', NULL, 8),
    ('Cestování', 'Kategorie pro cestování a dobrodružství', NOW(), 'aktivní', NULL, 9),
    ('Společenské události', 'Kategorie pro společenské události a večírky', NOW(), 'aktivní', NULL, 10);

-- Event table
INSERT INTO Event (event_name, description, icon, rating, time_of_creation, time_of_last_edit, status, category_name, owner_id)
VALUES
    ('Koncert skupiny XYZ', 'Skvělý koncert oblíbené skupiny v moderním koncertním sále.', NULL, 4.5, NOW(), NOW(), 'aktivní', 'Koncerty', 1),
    ('Divadelní představení "Hamlet"', 'Tragická hra o lásce a zradě v podání renomovaného divadla.', NULL, 4.2, NOW(), NOW(), 'aktivní', 'Divadlo', 2),
    ('Výstava moderního umění', 'Prohlídka moderních uměleckých děl od talentovaných umělců.', NULL, 4.0, NOW(), NOW(), 'aktivní', 'Výstavy', 3),
    ('Festival elektronické hudby', 'Největší festival elektronické hudby v regionu s top DJ hvězdami.', NULL, 4.8, NOW(), NOW(), 'aktivní', 'Festivaly', 4),
    ('Workshop: Fotografie pro začátečníky', 'Praktický workshop pro začátečníky zaměřený na základy fotografie.', NULL, 4.3, NOW(), NOW(), 'aktivní', 'Workshopy', 5),
    ('Projekce filmu "Přežít"', 'Dramatický film o přežití v divočině s úžasným hereckým obsazením.', NULL, 4.6, NOW(), NOW(), 'aktivní', 'Kino', 6),
    ('Maratón běhu na 10 km', 'Sportovní událost pro běžecké nadšence v krásném přírodním prostředí.', NULL, 4.7, NOW(), NOW(), 'aktivní', 'Sportovní akce', 7),
    ('Zábavní park: Adrenalinová jízda', 'Napínavé atrakce a adrenalinové jízdy v oblíbeném zábavním parku.', NULL, 4.4, NOW(), NOW(), 'aktivní', 'Zábavní parky', 8),
    ('Cestování po Asii', 'Dojemný příběh cestování po Asii s mnoha zážitky a dobrodružstvími.', NULL, 4.1, NOW(), NOW(), 'aktivní', 'Cestování', 9),
    ('Společenský večírek "Večer s hvězdami"', 'Elegantní společenský večírek pod širým nebem s hudebním programem.', NULL, 4.9, NOW(), NOW(), 'aktivní', 'Společenské události', 10);


-- Address table
INSERT INTO Address (Country, zip, city, street, street_number, state, description, date_of_creation, status, account_id)
VALUES
    ('Česká republika', 11000, 'Praha', 'Václavské náměstí', '25', 'Hlavní město Praha', 'Moderní koncertní sál', NOW(), 'aktivní', 1),
    ('Česká republika', 12000, 'Praha', 'Ovocný trh', '6', 'Hlavní město Praha', 'Národní divadlo', NOW(), 'aktivní', 2),
    ('Česká republika', 13000, 'Praha', 'Dlouhá', '22', 'Hlavní město Praha', 'Galerie umění', NOW(), 'aktivní', 3),
    ('Česká republika', 14000, 'Praha', 'Strahovská', '18', 'Hlavní město Praha', 'Strahovský stadion', NOW(), 'aktivní', 4),
    ('Česká republika', 15000, 'Praha', 'Vodičkova', '22', 'Hlavní město Praha', 'Škola umění a designu', NOW(), 'aktivní', 5),
    ('Česká republika', 16000, 'Praha', 'Národní', '20', 'Hlavní město Praha', 'Kino Lucerna', NOW(), 'aktivní', 6),
    ('Česká republika', 17000, 'Praha', 'Letná', '45', 'Hlavní město Praha', 'Letenský zámeček', NOW(), 'aktivní', 7),
    ('Česká republika', 18000, 'Praha', 'Trojská', '171', 'Hlavní město Praha', 'Zábavní park Mirakulum', NOW(), 'aktivní', 8),
    ('Česká republika', 19000, 'Praha', 'Růžová', '128', 'Hlavní město Praha', 'Prázdninová cestovní agentura', NOW(), 'aktivní', 9),
    ('Česká republika', 20000, 'Praha', 'Staroměstské náměstí', '1', 'Hlavní město Praha', 'Staroměstská radnice', NOW(), 'aktivní', 10);


-- Event_instance table
INSERT INTO Event_instance (event_id, address_id, time_from, time_to)
VALUES
    (1, 1, '2023-05-01 19:00:00', '2023-05-01 22:00:00'),
    (2, 2, '2023-06-15 18:30:00', '2023-06-15 22:30:00'),
    (3, 3, '2023-07-10 10:00:00', '2023-07-10 18:00:00'),
    (4, 4, '2023-08-05 20:00:00', '2023-08-05 23:00:00'),
    (5, 5, '2023-09-02 14:00:00', '2023-09-02 17:00:00'),
    (6, 6, '2023-10-20 17:30:00', '2023-10-20 22:30:00'),
    (7, 7, '2023-11-12 09:00:00', '2023-11-12 13:00:00'),
    (8, 8, '2023-12-03 13:00:00', '2023-12-03 18:00:00'),
    (9, 9, '2024-01-18 19:30:00', '2024-01-18 22:30:00'),
    (10, 10, '2024-02-08 20:00:00', '2024-02-08 23:00:00');

-- Entrance_fee table
INSERT INTO Entrance_fee (instance_id, name, shopping_method, cost, max_tickets, sold_tickets)
VALUES
    (1, 'Vstupenka standard', 'Online', 250.00, 500, 150),
    (2, 'Vstupenka VIP', 'Online', 450.00, 100, 75),
    (3, 'Vstupenka dospělý', 'Na místě', 120.00, 300, 180),
    (4, 'Vstupenka festivalová', 'Online', 600.00, 1500, 800),
    (5, 'Účast na workshopu', 'Na místě', 80.00, 50, 30),
    (6, 'Vstupenka standard', 'Online', 150.00, 300, 120),
    (7, 'Startovné běžeckého maratónu', 'Online', 200.00, 500, 250),
    (8, 'Vstupenka na atrakce', 'Na místě', 180.00, 200, 100),
    (9, 'Balíček cestování po Asii', 'Online', 1200.00, 30, 20),
    (10, 'Vstupenka VIP', 'Online', 350.00, 200, 120);

-- Registration table
INSERT INTO Registration (owner_id, instance_id, time_of_confirmation, fee_name)
VALUES
    (1, 1, NOW(), 'Vstupenka standard'),
    (2, 2, NOW(), 'Vstupenka VIP'),
    (3, 3, NOW(), 'Vstupenka dospělý'),
    (4, 4, NOW(), 'Vstupenka festivalová'),
    (5, 5, NOW(), 'Účast na workshopu'),
    (6, 6, NOW(), 'Vstupenka standard'),
    (7, 7, NOW(), 'Startovné běžeckého maratónu'),
    (8, 8, NOW(), 'Vstupenka na atrakce'),
    (9, 9, NOW(), 'Balíček cestování po Asii'),
    (10, 10, NOW(), 'Vstupenka VIP');

-- Comment
INSERT INTO Comment (time_of_posting, comment_text, author_id, super_comment, event_id)
VALUES
    ('2023-05-02 08:45:00', 'Skvělý koncert, nemohl jsem si ho nechat ujít!', 1, NULL, 1),
    ('2023-06-16 15:20:00', 'Hamlet byl úžasný, skvělá herecká představení!', 2, NULL, 2),
    ('2023-07-11 12:30:00', 'Výstava mě opravdu inspiruje, skvělé umění!', 3, NULL, 3),
    ('2023-08-06 22:10:00', 'Festival elektronické hudby mě dostal do varu, super zážitek!', 4, NULL, 4),
    ('2023-09-03 16:40:00', 'Workshop byl skvělý, hodně jsem se naučil!', 5, NULL, 5),
    ('2023-10-21 19:05:00', 'Film "Přežít" byl napínavý, moc dobrý!', 6, NULL, 6),
    ('2023-11-13 10:55:00', 'Běžecký maratón byl úžasný, skvělá organizace!', 7, NULL, 7),
    ('2023-12-04 14:25:00', 'Zábavní park byl parádní, atrakce jsou skvělé!', 8, NULL, 8),
    ('2024-01-19 20:15:00', 'Cestování po Asii bylo dobrodružství, krásné zážitky!', 9, NULL, 9),
    ('2024-02-09 21:30:00', 'Společenský večírek byl elegantní, skvělá atmosféra!', 10, NULL, 10);
