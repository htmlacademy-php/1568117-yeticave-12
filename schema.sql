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

/* ���������� ���������� � ������� ��������� */
INSERT INTO categories (cat_name, cat_code) VALUES 
    ('����� � ����', 'boards'),
    ('���������', 'attachment'),
    ('�������', 'boots'),
    ('������', 'clothing'),
    ('�����������', 'tools'),
    ('������', 'other');

/* ���������� ���������� � ������� ������������ */
INSERT INTO users (email, username, password, contact) VALUES 
    ('caseller@test.ru', 'caseller', 'Password1', '+79161234567'),
    ('topseller@test.ru', 'topseller', 'Password2', '@topseller'),
    ('best_buyer@test.ru', 'best_buyer', 'Password3', '+79167654321'),
    ('allbuy@test.ru', 'allbuy', 'Password4', '@allbuy');

/* ���������� ���������� � ������� ���� */
INSERT INTO lots (lot_name, description, image, start_price, bid_increment, price, owner_id, cat_id, dt_end) VALUES 
    ('2014 Rossignol District Snowboard', '��������. ������ 2014 ����', 'img/lot-1.jpg', '10999', '500', start_price, '1', '1', ADDDATE(NOW(), INTERVAL 10 DAY)),
    ('DC Ply Mens 2016/2017 Snowboard', '��������. ������ 2016 ����', 'img/lot-2.jpg', '159999', '5000', start_price, '2', '1', ADDDATE(NOW(), INTERVAL 10 DAY)),
    ('��������� Union Contact Pro 2015 ���� ������ L/XL', '������ L/XL', 'img/lot-3.jpg', '8000', '400', start_price, '1', '2', ADDDATE(NOW(), INTERVAL 10 DAY)),
    ('������� ��� ��������� DC Mutiny Charocal', '������ �������', 'img/lot-4.jpg', '10999', '1000', start_price, '1', '3', ADDDATE(NOW(), INTERVAL 10 DAY)),
    ('������ ��� ��������� DC Mutiny Charocal', '����� ������ ������', 'img/lot-5.jpg', '7500', '500', start_price, '2', '4', ADDDATE(NOW(), INTERVAL 10 DAY)),
    ('����� Oakley Canopy', '�������� ���������� �����', 'img/lot-6.jpg', '1400', '100', start_price, '2', '6', ADDDATE(NOW(), INTERVAL 10 DAY));

/* ���������� ���������� � ������� ������ */
INSERT INTO bids (lot_id, user_id, price) VALUES 
    ('1', '3', '10999'),
    ('1', '4', '11499'),
    ('1', '3', '11999'),
    ('1', '4', '12499');

/* �������� ��� ��������� */
SELECT cat_name FROM categories;

/* �������� ����� �����, �������� ����. ������ ��� ������ �������� ��������, ��������� ����, ������ �� �����������, ������� ����, �������� ��������� */
SELECT lots.lot_name, lots.start_price, lots.image, lots.price, categories.cat_name
FROM lots
INNER JOIN categories on lots.cat_id = categories.id
WHERE lots.dt_create > DATE_SUB(NOW(), INTERVAL 1 DAY);

/* �������� ��� �� ��� id. �������� ����� �������� ���������, � ������� ����������� ��� */
SELECT lots.lot_name, categories.cat_name FROM lots INNER JOIN categories using(id) WHERE id=3;

/* �������� �������� ���� �� ��� �������������� */
UPDATE lots SET lot_name = '������ ������ ��� ���������' WHERE id = 5;

/* �������� ������ ������ ��� ���� �� ��� �������������� � ����������� �� ���� */
SELECT lots.lot_name, users.username, bids.price
FROM bids
INNER JOIN lots on bids.lot_id = lots.id
INNER JOIN users on bids.user_id = users.id
WHERE bids.lot_id = 1 ORDER BY bids.dt_bids DESC;