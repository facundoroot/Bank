CREATE DATABASE register;
USE register;

CREATE TABLE users(
    id              int(255) auto_increment not null,
    name            varchar(100) not null,
    last_name       varchar(255),
    email           varchar(255) not null,
    password        varchar(255) not null,

CONSTRAINT pk_users PRIMARY KEY(id),
CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDb;

CREATE TABLE credit_card(
    id              int(255) auto_increment not null,
    user_id         int(255) not null,
    card_number     int(255) not null,
    money_amount    int(255) not null,

CONSTRAINT pk_credit_card PRIMARY KEY(id),
CONSTRAINT uq_card_number UNIQUE(card_number),
CONSTRAINT fk_credit_card_user FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;


CREATE TABLE transference(
    id              int(255) auto_increment not null,
    transferer_id   int(255) not null,
    transfered_to   varchar(255) not null,
    amount          int(255),

CONSTRAINT pk_transference PRIMARY KEY(id),
CONSTRAINT fk_transference_user FOREIGN KEY(transferer_id) REFERENCES users(id)
)ENGINE=InnoDb;