/* Creating the tables this app will use */
CREATE TABLE cards (
    id int AUTO_INCREMENT NOT NULL,
    card_number int NOT NULL,
    access_number int NOT NULL,
    active tinyint NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    UNIQUE(card_number)
);

CREATE TABLE temp_cards (
    id int AUTO_INCREMENT NOT NULL,
    user VARCHAR(255) NOT NULL,
    card_id int NOT NULL,
    submission_date DATE NOT NULL,
    requested_date DATE NOT NULL,
    reason_for_card VARCHAR(255) NOT NULL,
    administrator VARCHAR(255) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (card_id) REFERENCES cards(id)
);
