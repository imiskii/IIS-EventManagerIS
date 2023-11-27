ALTER DATABASE xlazik00 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE Account (
    account_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(256) NOT NULL,
    first_name VARCHAR(128),
    last_name VARCHAR(128),
    nick VARCHAR(128),
    password VARCHAR(128),
    account_type VARCHAR(32),
    profile_icon VARCHAR(256),
    account_status VARCHAR(64)
);

CREATE TABLE Category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(128),
    category_description MEDIUMTEXT,
    time_of_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    category_status VARCHAR(64),

    super_category_id INT,
    account_id INT, -- on account delete category can persist, not adding constraint

    CONSTRAINT fk_super_category
    FOREIGN KEY (super_category_id)
    REFERENCES Category(category_id) ON DELETE CASCADE
);

CREATE TABLE Event (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(128),
    event_description MEDIUMTEXT,
    event_icon VARCHAR(256),
    rating FLOAT,
    time_of_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    time_of_last_edit DATETIME,
    event_status VARCHAR(64),

    category_id INT,
    account_id INT,

    CONSTRAINT fk_event_owner
    FOREIGN KEY (account_id)
    REFERENCES Account(account_id) ON DELETE CASCADE
);

CREATE TABLE Address (
    address_id INT AUTO_INCREMENT PRIMARY KEY,
    country VARCHAR(128),
    zip INT,
    city VARCHAR(128),
    street VARCHAR(128),
    street_number INT,
    state VARCHAR(128),
    address_description MEDIUMTEXT,
    date_of_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    address_status VARCHAR(64),
    account_id INT -- on account delete address can persist, not adding constraint
);

CREATE TABLE Event_instance (
    instance_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    address_id INT,
    date_from DATE,
    time_from TIME,
    date_to DATE,
    time_to TIME,

    CONSTRAINT fk_instance_of_event
    FOREIGN KEY (event_id)
    REFERENCES Event(event_id) ON DELETE CASCADE,

    CONSTRAINT fk_address_of_instance
    FOREIGN KEY (address_id)
    REFERENCES Address(address_id) ON DELETE CASCADE
);

CREATE TABLE Entrance_fee (
    instance_id INT,
    fee_name VARCHAR(128),
    shopping_method VARCHAR(64),
    cost DECIMAL,
    max_tickets INT,
    sold_tickets INT,

    PRIMARY KEY(instance_id, fee_name),

    CONSTRAINT fk_event_instance_fee
    FOREIGN KEY (instance_id)
    REFERENCES Event_instance(instance_id) ON DELETE CASCADE
);

CREATE TABLE Registration (
    reg_id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT,
    instance_id INT,
    ticket_count INT,
    time_of_confirmation DATETIME,
    fee_name VARCHAR(128),

    CONSTRAINT fk_fee_registration
    FOREIGN KEY (instance_id, fee_name)
    REFERENCES Entrance_fee(instance_id, fee_name) ON DELETE CASCADE,

    CONSTRAINT fk_account_registered
    FOREIGN KEY (account_id)
    REFERENCES Account(account_id) ON DELETE CASCADE
);

CREATE TABLE Photos (
    photo_id INT AUTO_INCREMENT PRIMARY KEY,
    photo_path VARCHAR(256),

    event_id INT,

    CONSTRAINT fk_event_photo
    FOREIGN KEY (event_id)
    REFERENCES Event(event_id) ON DELETE CASCADE
);

CREATE TABLE Comment (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    time_of_posting DATETIME DEFAULT CURRENT_TIMESTAMP,
    comment_text MEDIUMTEXT,
    comment_rating FLOAT,

    account_id INT,
    super_comment INT,
    event_id INT,

    FOREIGN KEY (account_id)
    REFERENCES Account(account_id) ON DELETE CASCADE,

    CONSTRAINT fk_super_comment
    FOREIGN KEY (super_comment)
    REFERENCES Comment(comment_id) ON DELETE CASCADE,

    CONSTRAINT fk_comment_on_event
    FOREIGN KEY (event_id)
    REFERENCES Event(event_id) ON DELETE CASCADE
);

DELIMITER //

CREATE TRIGGER update_event_rating_after_insert
AFTER INSERT ON Comment
FOR EACH ROW
BEGIN
    UPDATE Event
    SET rating = (
        SELECT AVG(comment_rating)
        FROM Comment
        WHERE event_id = NEW.event_id AND comment_rating IS NOT NULL
    )
    WHERE event_id = NEW.event_id;
END;

//

CREATE TRIGGER update_event_rating_after_update
AFTER UPDATE ON Comment
FOR EACH ROW
BEGIN
    UPDATE Event
    SET rating = (
        SELECT AVG(comment_rating)
        FROM Comment
        WHERE event_id = OLD.event_id AND comment_rating IS NOT NULL
    )
    WHERE event_id = OLD.event_id;
END;

//

CREATE TRIGGER update_event_rating_after_delete
AFTER DELETE ON Comment
FOR EACH ROW
BEGIN
    UPDATE Event
    SET rating = (
        SELECT AVG(comment_rating)
        FROM Comment
        WHERE event_id = OLD.event_id AND comment_rating IS NOT NULL
    )
    WHERE event_id = OLD.event_id;
END;

//

CREATE TRIGGER update_sold_tickets
AFTER UPDATE ON Registration
FOR EACH ROW
BEGIN
    UPDATE Entrance_fee
    SET sold_tickets = (
        SELECT SUM(ticket_count)
        FROM Registration
        WHERE instance_id = OLD.instance_id AND fee_name = OLD.fee_name AND time_of_confirmation IS NOT NULL
    )
    WHERE instance_id = OLD.instance_id AND fee_name = OLD.fee_name;
END;

//

CREATE TRIGGER after_delete_category
AFTER DELETE
ON Category FOR EACH ROW

BEGIN
    UPDATE Event
    SET event_status = 'pending'
    WHERE category_id = OLD.category_id;

END;
//

DELIMITER ;

-- Account table
INSERT INTO Account (email, first_name, last_name, nick, password, account_type, profile_icon, account_status)
VALUES
    ('jan.novak@email.cz', 'Jan', 'Novák', 'jannov', 'password', 'regular', NULL, 'active'),
    ('eva.hodkova@email.cz', 'Eva', 'Hodková', 'evahod', 'password', 'administrator', NULL, 'active'),
    ('petr.kral@email.cz', 'Petr', 'Král', 'petrkra', 'password', 'regular', NULL, 'active'),
    ('katerina.svobodova@email.cz', 'Kateřina', 'Svobodová', 'katisvo', 'password', 'regular', NULL, 'active'),
    ('marek.jelinek@email.cz', 'Marek', 'Jelínek', 'marejel', 'password', 'administrator', NULL, 'active'),
    ('martina.hermanova@email.cz', 'Martina', 'Hermanová', 'marther', 'password', 'regular', NULL, 'active'),
    ('ondrej.nemec@email.cz', 'Ondřej', 'Němec', 'ondrnem', 'password', 'moderator', NULL, 'active'),
    ('veronika.havlickova@email.cz', 'Veronika', 'Havlíčková', 'verhav', 'password', 'regular', NULL, 'active'),
    ('adam.dolezal@email.cz', 'Adam', 'Doležal', 'adadol', 'password', 'administrator', NULL, 'active'),
    ('nikola.bartosova@email.cz', 'Nikola', 'Bartošová', 'nikbart', 'password', 'moderator', NULL, 'active');

-- Category table
INSERT INTO Category (category_name, category_description, time_of_creation, category_status, super_category_id, account_id)
VALUES
    ('Hudební Události', 'Kategorie pro hudební události jako festivaly a koncerty', NOW(), 'approved', NULL, 1),
    ('Koncerty', 'Kategorie pro koncerty', NOW(), 'approved', 1, 1),
    ('Divadlo', 'Kategorie pro divadelní představení', NOW(), 'approved', NULL, 2),
    ('Výstavy', 'Kategorie pro výstavy a galerie', NOW(), 'approved', NULL, 3),
    ('Festivaly', 'Kategorie pro festivaly', NOW(), 'approved', 1, 4),
    ('Workshopy', 'Kategorie pro vzdělávací workshopy', NOW(), 'approved', NULL, 5),
    ('Kino', 'Kategorie pro kino a filmové projekce', NOW(), 'approved', NULL, 6),
    ('Sportovní akce', 'Kategorie pro sportovní akce', NOW(), 'approved', NULL, 7),
    ('Zábavní parky', 'Kategorie pro návštěvu zábavních parků', NOW(), 'approved', NULL, 8),
    ('Cestování', 'Kategorie pro cestování a dobrodružství', NOW(), 'approved', NULL, 9),
    ('Společenské události', 'Kategorie pro společenské události a večírky', NOW(), 'approved', NULL, 10),
    -- pending
    ('Gastronomie', 'Kategorie pro gastronomické události a ochutnávky', NOW(), 'pending', NULL, 3),
    ('Literární akce', 'Kategorie pro literární setkání a knižní večery', NOW(), 'pending', NULL, 6),
    ('Umělecká díla', 'Kategorie pro prezentaci a vystavování uměleckých děl', NOW(), 'pending', 4, 9),
    ('Adrenalinové sporty', 'Kategorie pro extrémní sportovní události a zážitky', NOW(), 'pending', 8, 4),
    ('Filmový festival', 'Kategorie pro filmové festivaly a premiéry', NOW(), 'pending', 6, 7);

-- Event table
INSERT INTO Event (event_name, event_description, event_icon, time_of_creation, time_of_last_edit, event_status, category_id, account_id)
VALUES
    ('Koncert skupiny XYZ', 'Skvělý koncert oblíbené skupiny v moderním koncertním sále.', NULL, NOW(), NOW(), 'approved', 2, 1),
    ('Divadelní představení "Hamlet"', 'Tragická hra o lásce a zradě v podání renomovaného divadla.', NULL, NOW(), NOW(), 'approved', 3, 2),
    ('Výstava moderního umění', 'Prohlídka moderních uměleckých děl od talentovaných umělců.', NULL, NOW(), NOW(), 'approved', 4, 3),
    ('Festival elektronické hudby', 'Největší festival elektronické hudby v regionu s top DJ hvězdami.', NULL, NOW(), NOW(), 'approved', 5, 4),
    ('Workshop: Fotografie pro začátečníky', 'Praktický workshop pro začátečníky zaměřený na základy fotografie.', NULL, NOW(), NOW(), 'approved', 6, 5),
    ('Projekce filmu "Přežít"', 'Dramatický film o přežití v divočině s úžasným hereckým obsazením.', NULL, NOW(), NOW(), 'approved', 7, 6),
    ('Maratón běhu na 10 km', 'Sportovní událost pro běžecké nadšence v krásném přírodním prostředí.', NULL, NOW(), NOW(), 'approved', 8, 7),
    ('Zábavní park: Adrenalinová jízda', 'Napínavé atrakce a adrenalinové jízdy v oblíbeném zábavním parku.', NULL, NOW(), NOW(), 'approved', 9, 8),
    ('Cestování po Asii', 'Dojemný příběh cestování po Asii s mnoha zážitky a dobrodružstvími.', NULL, NOW(), NOW(), 'approved', 10, 9),
    ('Společenský večírek "Večer s hvězdami"', 'Elegantní společenský večírek pod širým nebem s hudebním programem.', NULL, NOW(), NOW(), 'approved', 11, 10);

-- Addresses
INSERT INTO Address (country, zip, city, street, street_number, state, address_description, date_of_creation, address_status, account_id)
VALUES
    ('Česká republika', 12000, 'Praha', 'Ovocný trh', '25', 'Hlavní město Praha', 'Moderní koncertní sál v centru města.', NOW(), 'approved', 1),
    ('Česká republika', 70030, 'Ostrava', 'Náměstí republiky', '12', 'Moravskoslezský kraj', 'Nádherné divadelní představení v historickém divadle.', NOW(), 'approved', 2),
    ('Česká republika', 60200, 'Brno', 'Údolní', '15', 'Jihomoravský kraj', 'Galerie s moderními uměleckými díly v samém centru Brna.', NOW(), 'approved', 3),
    ('Česká republika', 13000, 'Praha', 'Výstaviště', '1', 'Hlavní město Praha', 'Velký festivalový areál s bohatým programem.', NOW(), 'approved', 4),
    ('Česká republika', 12000, 'Praha', 'Václavské náměstí', '48', 'Hlavní město Praha', 'Výukový workshop pro začátečníky v oblasti fotografie.', NOW(), 'approved', 5),
    ('Česká republika', 13000, 'Praha', 'Národní', '22', 'Hlavní město Praha', 'Moderní kino s nejnovějším technologickým vybavením.', NOW(), 'approved', 6),
    ('Česká republika', 60200, 'Brno', 'Úvoz', '1', 'Jihomoravský kraj', 'Lezecké centrum se stěnami pro všechny obtížnosti.', NOW(), 'approved', 7),
    ('Česká republika', 70030, 'Ostrava', 'Svinovská', '11', 'Moravskoslezský kraj', 'Největší zábavní park v okolí s atrakcemi pro všechny věkové kategorie.', NOW(), 'approved', 8),
    ('Česká republika', 60200, 'Brno', 'Mendlovo náměstí', '1', 'Jihomoravský kraj', 'Poutavá cestovatelská přednáška v moderním kongresovém centru.', NOW(), 'approved', 9),
    ('Česká republika', 37001, 'České Budějovice', 'Náměstí Přemysla Otakara II.', '1', 'Jihočeský kraj', 'Otevřený koncert na náměstí s atmosférou open-air akce.', NOW(), 'approved', 10),
    ('Česká republika', 60200, 'Brno', 'Křenová', '10', 'Jihomoravský kraj', 'Připravovaný kulturní prostor v centru Brna.', NOW(), 'pending', 9),
    ('Česká republika', 11000, 'Praha', 'Národní', '18', 'Hlavní město Praha', 'Nová moderní galerie s nejnovějšími uměleckými trendy.', NOW(), 'pending', 6),
    ('Česká republika', 60200, 'Brno', 'Kounicova', '56', 'Jihomoravský kraj', 'Plánované sportovní centrum s multifunkčními hřišti.', NOW(), 'pending', 7),
    ('Česká republika', 13000, 'Praha', 'Na Příkopě', '22', 'Hlavní město Praha', 'Budoucí místo konání prestižního filmového festivalu.', NOW(), 'pending', 8),
    ('Česká republika', 70030, 'Ostrava', 'Zámecká', '8', 'Moravskoslezský kraj', 'Plánovaná kulturní scéna s pravidelnými divadelními představeními.', NOW(), 'pending', 8);


-- Event_instance table
INSERT INTO Event_instance (event_id, address_id, date_from, time_from, date_to, time_to)
VALUES
    (1, 3, '2023-07-15', '21:00:00', '2023-07-15', '23:30:00'),
    (1, 5, '2023-08-20', '18:30:00', '2023-08-20', '21:00:00'),
    (1, 7, '2023-09-10', '20:30:00', '2023-09-10', '23:00:00'),
    (2, 4, '2023-07-20', '19:30:00', '2023-07-20', '22:00:00'),
    (2, 6, '2023-08-25', '20:00:00', '2023-08-25', '22:30:00'),
    (2, 8, '2023-09-15', '18:00:00', '2023-09-15', '20:30:00'),
    (3, 5, '2023-07-12', '11:00:00', '2023-07-12', '17:00:00'),
    (3, 7, '2023-08-30', '14:30:00', '2023-08-30', '20:30:00'),
    (3, 9, '2023-09-20', '12:00:00', '2023-09-20', '18:00:00'),
    (4, 6, '2023-08-15', '22:00:00', '2023-08-15', '23:59:59'),
    (4, 8, '2023-09-05', '19:30:00', '2023-09-05', '22:30:00'),
    (4, 10, '2023-10-01', '21:00:00', '2023-10-01', '23:30:00'),
    (5, 7, '2023-09-10', '15:00:00', '2023-09-10', '18:30:00'),
    (5, 9, '2023-10-05', '13:30:00', '2023-10-05', '17:00:00'),
    (5, 2, '2023-11-02', '14:00:00', '2023-11-02', '17:30:00'),
    (6, 8, '2023-10-25', '18:00:00', '2023-10-25', '21:30:00'),
    (6, 10, '2023-11-15', '17:30:00', '2023-11-15', '20:00:00'),
    (6, 1, '2023-12-05', '19:00:00', '2023-12-05', '22:30:00'),
    (7, 9, '2023-11-25', '12:30:00', '2023-11-25', '16:30:00'),
    (7, 2, '2023-12-20', '11:00:00', '2023-12-20', '15:00:00'),
    (7, 4, '2024-01-15', '13:30:00', '2024-01-15', '17:30:00'),
    (8, 10, '2024-01-05', '11:00:00', '2024-01-05', '16:00:00'),
    (8, 3, '2024-02-10', '14:30:00', '2024-02-10', '18:30:00'),
    (8, 5, '2024-03-01', '12:00:00', '2024-03-01', '16:00:00'),
    (9, 1, '2024-01-20', '19:00:00', '2024-01-20', '21:30:00'),
    (9, 3, '2024-02-15', '18:30:00', '2024-02-15', '22:00:00'),
    (9, 5, '2024-03-10', '20:00:00', '2024-03-10', '23:30:00'),
    (10, 6, '2024-02-25', '19:30:00', '2024-02-25', '22:00:00'),
    (10, 8, '2024-03-20', '18:00:00', '2024-03-20', '21:30:00'),
    (10, 10, '2024-04-15', '20:30:00', '2024-04-15', '23:00:00');


-- Entrance_fee table
INSERT INTO Entrance_fee (instance_id, fee_name, shopping_method, cost, max_tickets, sold_tickets)
VALUES
    (1, 'Vstupenka standard', 'Online', 250.00, 500, 150),
    (1, 'Vstupenka VIP', 'Online', 450.00, 100, 75),
    (1, 'Vstupenka dospělý', 'Na místě', 120.00, 300, 180),
    (2, 'Vstupenka standard', 'Online', 260.00, 510, 160),
    (2, 'Vstupenka VIP', 'Online', 460.00, 110, 85),
    (2, 'Vstupenka dospělý', 'Na místě', 130.00, 310, 190),
    (3, 'Vstupenka standard', 'Online', 270.00, 520, 170),
    (3, 'Vstupenka VIP', 'Online', 470.00, 120, 95),
    (3, 'Vstupenka dospělý', 'Na místě', 140.00, 320, 200),
    (4, 'Vstupenka standard', 'Online', 280.00, 530, 180),
    (4, 'Vstupenka VIP', 'Online', 480.00, 130, 105),
    (4, 'Vstupenka dospělý', 'Na místě', 150.00, 330, 210),
    (5, 'Vstupenka standard', 'Online', 290.00, 540, 190),
    (5, 'Vstupenka VIP', 'Online', 490.00, 140, 115),
    (5, 'Vstupenka dospělý', 'Na místě', 160.00, 340, 220),
    (6, 'Vstupenka standard', 'Online', 300.00, 550, 200),
    (6, 'Vstupenka VIP', 'Online', 500.00, 150, 125),
    (6, 'Vstupenka dospělý', 'Na místě', 170.00, 350, 230),
    (7, 'Vstupenka standard', 'Online', 310.00, 560, 210),
    (7, 'Vstupenka VIP', 'Online', 510.00, 160, 135),
    (7, 'Vstupenka dospělý', 'Na místě', 180.00, 360, 240),
    (8, 'Vstupenka standard', 'Online', 320.00, 570, 220),
    (8, 'Vstupenka VIP', 'Online', 520.00, 170, 145),
    (8, 'Vstupenka dospělý', 'Na místě', 190.00, 370, 250),
    (9, 'Vstupenka standard', 'Online', 330.00, 580, 230),
    (9, 'Vstupenka VIP', 'Online', 530.00, 180, 155),
    (9, 'Vstupenka dospělý', 'Na místě', 200.00, 380, 260),
    (10, 'Vstupenka standard', 'Online', 340.00, 590, 240),
    (10, 'Vstupenka VIP', 'Online', 540.00, 190, 165),
    (10, 'Vstupenka dospělý', 'Na místě', 210.00, 390, 270),
    (11, 'Vstupenka standard', 'Online', 250.00, 500, 150),
    (11, 'Vstupenka VIP', 'Online', 450.00, 100, 75),
    (11, 'Vstupenka dospělý', 'Na místě', 120.00, 300, 180),
    (12, 'Vstupenka standard', 'Online', 260.00, 510, 160),
    (12, 'Vstupenka VIP', 'Online', 460.00, 110, 85),
    (12, 'Vstupenka dospělý', 'Na místě', 130.00, 310, 190),
    (13, 'Vstupenka standard', 'Online', 270.00, 520, 170),
    (13, 'Vstupenka VIP', 'Online', 470.00, 120, 95),
    (13, 'Vstupenka dospělý', 'Na místě', 140.00, 320, 200),
    (14, 'Vstupenka standard', 'Online', 280.00, 530, 180),
    (14, 'Vstupenka VIP', 'Online', 480.00, 130, 105),
    (14, 'Vstupenka dospělý', 'Na místě', 150.00, 330, 210),
    (15, 'Vstupenka standard', 'Online', 290.00, 540, 190),
    (15, 'Vstupenka VIP', 'Online', 490.00, 140, 115),
    (15, 'Vstupenka dospělý', 'Na místě', 160.00, 340, 220),
    (16, 'Vstupenka standard', 'Online', 300.00, 550, 200),
    (16, 'Vstupenka VIP', 'Online', 500.00, 150, 125),
    (16, 'Vstupenka dospělý', 'Na místě', 170.00, 350, 230),
    (17, 'Vstupenka standard', 'Online', 310.00, 560, 210),
    (17, 'Vstupenka VIP', 'Online', 510.00, 160, 135),
    (17, 'Vstupenka dospělý', 'Na místě', 180.00, 360, 240),
    (18, 'Vstupenka standard', 'Online', 320.00, 570, 220),
    (18, 'Vstupenka VIP', 'Online', 520.00, 170, 145),
    (18, 'Vstupenka dospělý', 'Na místě', 190.00, 370, 250),
    (19, 'Vstupenka standard', 'Online', 330.00, 580, 230),
    (19, 'Vstupenka VIP', 'Online', 530.00, 180, 155),
    (19, 'Vstupenka dospělý', 'Na místě', 200.00, 380, 260),
    (20, 'Vstupenka standard', 'Online', 340.00, 590, 240),
    (20, 'Vstupenka VIP', 'Online', 540.00, 190, 165),
    (20, 'Vstupenka dospělý', 'Na místě', 210.00, 390, 270),
    (21, 'Vstupenka standard', 'Online', 250.00, 500, 150),
    (21, 'Vstupenka VIP', 'Online', 450.00, 100, 75),
    (21, 'Vstupenka dospělý', 'Na místě', 120.00, 300, 180),
    (22, 'Vstupenka standard', 'Online', 260.00, 510, 160),
    (22, 'Vstupenka VIP', 'Online', 460.00, 110, 85),
    (22, 'Vstupenka dospělý', 'Na místě', 130.00, 310, 190),
    (23, 'Vstupenka standard', 'Online', 270.00, 520, 170),
    (23, 'Vstupenka VIP', 'Online', 470.00, 120, 95),
    (23, 'Vstupenka dospělý', 'Na místě', 140.00, 320, 200),
    (24, 'Vstupenka standard', 'Online', 280.00, 530, 180),
    (24, 'Vstupenka VIP', 'Online', 480.00, 130, 105),
    (24, 'Vstupenka dospělý', 'Na místě', 150.00, 330, 210),
    (25, 'Vstupenka standard', 'Online', 290.00, 540, 190),
    (25, 'Vstupenka VIP', 'Online', 490.00, 140, 115),
    (25, 'Vstupenka dospělý', 'Na místě', 160.00, 340, 220),
    (26, 'Vstupenka standard', 'Online', 300.00, 550, 200),
    (26, 'Vstupenka VIP', 'Online', 500.00, 150, 125),
    (26, 'Vstupenka dospělý', 'Na místě', 170.00, 350, 230),
    (27, 'Vstupenka standard', 'Online', 310.00, 560, 210),
    (27, 'Vstupenka VIP', 'Online', 510.00, 160, 135),
    (27, 'Vstupenka dospělý', 'Na místě', 180.00, 360, 240),
    (28, 'Vstupenka standard', 'Online', 320.00, 570, 220),
    (28, 'Vstupenka VIP', 'Online', 520.00, 170, 145),
    (28, 'Vstupenka dospělý', 'Na místě', 190.00, 370, 250),
    (29, 'Vstupenka standard', 'Online', 330.00, 580, 230),
    (29, 'Vstupenka VIP', 'Online', 530.00, 180, 155),
    (29, 'Vstupenka dospělý', 'Na místě', 200.00, 380, 260),
    (30, 'Vstupenka standard', 'Online', 340.00, 590, 240),
    (30, 'Vstupenka VIP', 'Online', 540.00, 190, 165),
    (30, 'Vstupenka dospělý', 'Na místě', 210.00, 390, 270);

-- Registration table
INSERT INTO Registration (account_id, instance_id, time_of_confirmation, fee_name, ticket_count)
VALUES
    (1, 1, '2023-11-22 12:30:00', 'Vstupenka standard', 1),
    (1, 5, NULL, 'Vstupenka VIP', 2),
    (1, 9, '2023-11-24 15:20:00', 'Vstupenka dospělý', 3),
    (2, 4, NULL, 'Vstupenka standard', 4),
    (2, 5, '2023-11-26 11:25:00', 'Vstupenka VIP', 5),
    (2, 6, NULL, 'Vstupenka dospělý', 2),
    (3, 7, '2023-11-28 09:45:00', 'Vstupenka standard', 2),
    (3, 8, NULL, 'Vstupenka VIP', 4),
    (3, 9, '2023-11-30 17:15:00', 'Vstupenka dospělý', 2),
    (4, 10, NULL, 'Vstupenka standard', 1),
    (4, 11, '2023-12-02 10:40:00', 'Vstupenka VIP', 2),
    (4, 12, NULL, 'Vstupenka dospělý', 6),
    (5, 13, '2023-12-04 11:10:00', 'Vstupenka standard', 2),
    (5, 14, NULL, 'Vstupenka VIP', 2),
    (5, 15, '2023-12-06 14:45:00', 'Vstupenka dospělý', 19),
    (6, 16, NULL, 'Vstupenka standard', 2),
    (6, 17, '2023-12-08 10:00:00', 'Vstupenka VIP', 2),
    (6, 18, NULL, 'Vstupenka dospělý', 2),
    (7, 19, '2023-12-10 15:30:00', 'Vstupenka standard', 2),
    (7, 20, NULL, 'Vstupenka VIP', 2),
    (7, 21, '2023-12-12 11:50:00', 'Vstupenka dospělý', 2),
    (8, 22, NULL, 'Vstupenka standard', 2),
    (8, 23, '2023-12-14 09:00:00', 'Vstupenka VIP', 2),
    (8, 24, NULL, 'Vstupenka dospělý', 2),
    (9, 25, '2023-12-16 12:15:00', 'Vstupenka standard', 2),
    (9, 26, NULL, 'Vstupenka VIP', 2),
    (9, 27, '2023-12-18 18:55:00', 'Vstupenka dospělý', 2),
    (10, 28, NULL, 'Vstupenka standard', 2),
    (10, 29, '2023-12-20 11:35:00', 'Vstupenka VIP', 2),
    (10, 30, NULL, 'Vstupenka dospělý', 2),
    (1, 1, '2023-11-22 12:30:00', 'Vstupenka standard', 1),
    (1, 5, NULL, 'Vstupenka VIP', 2),
    (1, 9, '2023-11-24 15:20:00', 'Vstupenka dospělý', 3),
    (2, 4, NULL, 'Vstupenka standard', 4),
    (2, 5, '2023-11-26 11:25:00', 'Vstupenka VIP', 5),
    (2, 6, NULL, 'Vstupenka dospělý', 2),
    (3, 7, '2023-11-28 09:45:00', 'Vstupenka standard', 2),
    (3, 8, NULL, 'Vstupenka VIP', 4),
    (3, 9, '2023-11-30 17:15:00', 'Vstupenka dospělý', 2),
    (4, 10, NULL, 'Vstupenka standard', 1),
    (4, 11, '2023-12-02 10:40:00', 'Vstupenka VIP', 2),
    (4, 12, NULL, 'Vstupenka dospělý', 6),
    (5, 13, '2023-12-04 11:10:00', 'Vstupenka standard', 2),
    (5, 14, NULL, 'Vstupenka VIP', 2),
    (5, 15, '2023-12-06 14:45:00', 'Vstupenka dospělý', 19),
    (6, 16, NULL, 'Vstupenka standard', 2),
    (6, 17, '2023-12-08 10:00:00', 'Vstupenka VIP', 2),
    (6, 18, NULL, 'Vstupenka dospělý', 2),
    (7, 19, '2023-12-10 15:30:00', 'Vstupenka standard', 2),
    (7, 20, NULL, 'Vstupenka VIP', 2),
    (7, 21, '2023-12-12 11:50:00', 'Vstupenka dospělý', 2),
    (8, 22, NULL, 'Vstupenka standard', 2),
    (8, 23, '2023-12-14 09:00:00', 'Vstupenka VIP', 2),
    (8, 24, NULL, 'Vstupenka dospělý', 2),
    (9, 25, '2023-12-16 12:15:00', 'Vstupenka standard', 2),
    (9, 26, NULL, 'Vstupenka VIP', 2),
    (9, 27, '2023-12-18 18:55:00', 'Vstupenka dospělý', 2),
    (10, 28, NULL, 'Vstupenka standard', 2),
    (10, 29, '2023-12-20 11:35:00', 'Vstupenka VIP', 2),
    (10, 30, NULL, 'Vstupenka dospělý', 2),
    (1, 1, '2023-12-22 14:30:00', 'Vstupenka dospělý', 7),
    (1, 1, NULL, 'Vstupenka VIP', 5),
    (2, 2, '2023-12-24 09:15:00', 'Vstupenka standard', 3),
    (2, 2, NULL, 'Vstupenka dospělý', 4),
    (3, 3, '2023-12-26 17:45:00', 'Vstupenka VIP', 2),
    (3, 3, NULL, 'Vstupenka standard', 8),
    (4, 4, '2023-12-28 08:00:00', 'Vstupenka VIP', 3),
    (4, 4, NULL, 'Vstupenka dospělý', 6),
    (5, 5, '2023-12-30 13:10:00', 'Vstupenka standard', 2),
    (5, 5, NULL, 'Vstupenka VIP', 2),
    (6, 6, '2024-01-01 16:55:00', 'Vstupenka dospělý', 5),
    (6, 6, NULL, 'Vstupenka standard', 3),
    (7, 7, '2024-01-03 11:30:00', 'Vstupenka VIP', 2),
    (7, 7, NULL, 'Vstupenka dospělý', 4),
    (8, 8, '2024-01-05 14:20:00', 'Vstupenka standard', 2),
    (8, 8, NULL, 'Vstupenka VIP', 2),
    (9, 9, '2024-01-07 10:45:00', 'Vstupenka dospělý', 2),
    (9, 9, NULL, 'Vstupenka standard', 2),
    (10, 10, '2024-01-09 09:00:00', 'Vstupenka VIP', 2),
    (10, 10, NULL, 'Vstupenka dospělý', 2);



-- Comment
INSERT INTO Comment (time_of_posting, comment_text, account_id, super_comment, event_id, comment_rating)
VALUES
    ('2023-06-18 17:30:00', 'Fantastický koncert skupiny XYZ, nejlepší zážitek!', 1, NULL, 1, 5),
    ('2023-07-13 14:45:00', 'Hamlet byl emotivní, skvělá herecká představení!', 2, NULL, 2, 4),
    ('2023-08-10 01:20:00', 'Výstava moderního umění mě oslovila, úžasná tvorba!', 3, NULL, 3, 3),
    ('2023-09-06 19:10:00', 'Festival elektronické hudby byl nezapomenutelný, skvělá hudba!', 4, NULL, 4, 5),
    ('2023-10-24 22:00:00', 'Fotografický workshop byl skvělý, přínosné informace!', 5, NULL, 5, 4),
    ('2023-11-16 13:40:00', 'Film "Přežít" byl napínavý, skvělý scénář!', 6, NULL, 6, 4),
    ('2023-12-07 16:00:00', 'Běžecký maratón byl úžasný, skvělá atmosféra!', 7, NULL, 7, 4),
    ('2024-01-23 21:30:00', 'Zábavní park nabídl adrenalinovou jízdu, skvělá zábava!', 8, NULL, 8, 5),
    ('2024-02-14 23:45:00', 'Cestování po Asii bylo dojemné, krásné vzpomínky!', 9, NULL, 9, 4),
    ('2023-06-20 11:30:00', 'Skvělý koncert skupiny XYZ, úžasná hudba!', 10, NULL, 1, 4),
    ('2023-07-15 18:20:00', 'Hamlet byl skvělý, emocionální zážitek!', 1, NULL, 2, 5),
    ('2023-08-12 09:45:00', 'Výstava moderního umění mě nadchla, skvělá prezentace!', 2, NULL, 3, 3),
    ('2023-09-08 14:30:00', 'Festival elektronické hudby byl úžasný, nejlepší DJ!', 3, NULL, 4, 4),
    ('2023-10-26 16:50:00', 'Fotografický workshop byl inspirativní, skvělé tipy!', 4, NULL, 5, 3),
    ('2023-11-18 20:05:00', 'Film "Přežít" byl skvělý, napínavý příběh!', 5, NULL, 6, 5),
    ('2023-12-09 11:35:00', 'Běžecký maratón byl úžasný, skvělá trasa!', 6, NULL, 7, 5),
    ('2024-01-25 15:20:00', 'Zábavní park byl skvělý, adrenalinové atrakce!', 7, NULL, 8, 4),
    ('2024-02-17 17:40:00', 'Cestování po Asii bylo dobrodružství, nezapomenutelné zážitky!', 8, NULL, 9, 5);
