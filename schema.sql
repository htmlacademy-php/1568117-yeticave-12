CREATE DATABASE AuctionDB
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE AuctionDB;

CREATE TABLE categories (
  id INT unsigned AUTO_INCREMENT PRIMARY KEY,
  cat_name VARCHAR(32) NOT NULL UNIQUE,
  cat_code VARCHAR(32) NOT NULL UNIQUE
);

CREATE TABLE users (
  id INT unsigned AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(64) NOT NULL UNIQUE,
  username VARCHAR(64) NOT NULL UNIQUE,
  password CHAR(32) NOT NULL,
  contact TEXT,
  dt_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE lots (
  id INT unsigned AUTO_INCREMENT PRIMARY KEY,
  lot_name VARCHAR(64) NOT NULL,
  description TEXT NULL,
  image VARCHAR(128),
  start_price INT unsigned NOT NULL,
  bid_increment INT unsigned NOT NULL DEFAULT 100,
  price INT unsigned NOT NULL,
  owner_id INT unsigned NOT NULL,
  winner_id INT unsigned ,
  cat_id INT unsigned NOT NULL,
  dt_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt_end TIMESTAMP,
  FOREIGN KEY (owner_id) REFERENCES users(id),
  FOREIGN KEY (winner_id) REFERENCES users(id),
  FOREIGN KEY (cat_id) REFERENCES categories(id)
);

CREATE TABLE bids (
  id INT unsigned AUTO_INCREMENT PRIMARY KEY,
  lot_id INT unsigned,
  user_id INT unsigned,
  price INT unsigned NOT NULL,
  dt_bids TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (lot_id) REFERENCES lots(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);