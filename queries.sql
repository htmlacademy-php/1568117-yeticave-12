/* Добавление данных в таблицу categories */
INSERT INTO categories (cat_name, cat_code) VALUES 
    ('Доски и лыжи', 'boards'),
    ('Крепления', 'attachment'),
    ('Ботинки', 'boots'),
    ('Одежда', 'clothing'),
    ('Инструменты', 'tools'),
    ('Разное', 'other');

/* Добавление данных в таблицу users */
INSERT INTO users (email, username, password, contact) VALUES 
    ('caseller@test.ru', 'caseller', 'Password1', '+79161234567'),
    ('topseller@test.ru', 'topseller', 'Password2', '@topseller'),
    ('best_buyer@test.ru', 'best_buyer', 'Password3', '+79167654321'),
    ('allbuy@test.ru', 'allbuy', 'Password4', '@allbuy');

/* Добавление данных в таблицу lots */
INSERT INTO lots (lot_name, description, image, start_price, bid_increment, price, owner_id, cat_id, dt_end) VALUES 
    ('2014 Rossignol District Snowboard', 'Сноуборд. Модель 2014 года', 'img/lot-1.jpg', '10999', '500', start_price, '1', '1', ADDDATE(NOW(), INTERVAL 10 DAY)),
    ('DC Ply Mens 2016/2017 Snowboard', 'Сноуборд. Модель 2016 года', 'img/lot-2.jpg', '159999', '5000', start_price, '2', '1', ADDDATE(NOW(), INTERVAL 10 DAY)),
    ('Крепления Union Contact Pro 2015 года размер L/XL', 'Размер L/XL', 'img/lot-3.jpg', '8000', '400', start_price, '1', '2', ADDDATE(NOW(), INTERVAL 10 DAY)),
    ('Ботинки для сноуборда DC Mutiny Charocal', 'Крутые ботинки', 'img/lot-4.jpg', '10999', '1000', start_price, '1', '3', ADDDATE(NOW(), INTERVAL 10 DAY)),
    ('Куртка для сноуборда DC Mutiny Charocal', 'Очень теплая куртка', 'img/lot-5.jpg', '7500', '500', start_price, '2', '4', ADDDATE(NOW(), INTERVAL 10 DAY)),
    ('Маска Oakley Canopy', 'Стильная спортивная маска', 'img/lot-6.jpg', '1400', '100', start_price, '2', '6', ADDDATE(NOW(), INTERVAL 10 DAY));

/* Добавление данных в таблицу bids */
INSERT INTO bids (lot_id, user_id, price) VALUES 
    ('1', '3', '10999'),
    ('1', '4', '11499'),
    ('1', '3', '11999'),
    ('1', '4', '12499');

/* получить все категории */
SELECT cat_name FROM categories;

/* получить самые новые, открытые лоты */
SELECT lots.lot_name, lots.start_price, lots.image, lots.price, categories.cat_name
FROM lots
INNER JOIN categories on lots.cat_id = categories.id
WHERE lots.dt_create > DATE_SUB(NOW(), INTERVAL 1 DAY);

/* показать лот по его id */
SELECT lots.lot_name, categories.cat_name
FROM lots
INNER JOIN categories using(id)
WHERE id='3';

/* обновить название лота по его идентификатору */
UPDATE lots SET lot_name = 'Теплая куртка для сноуборда'
WHERE id = '5';

/* показать лот по его id */
SELECT lots.lot_name, users.username, bids.price
FROM bids
INNER JOIN lots on bids.lot_id = lots.id
INNER JOIN users on bids.user_id = users.id
WHERE bids.lot_id = '1' ORDER BY bids.dt_bids DESC;