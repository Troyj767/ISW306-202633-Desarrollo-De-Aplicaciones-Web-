CREATE USER IF NOT EXISTS 'novashop'@'localhost' IDENTIFIED BY 'novashop_local_2026';
GRANT ALL PRIVILEGES ON novashop_db.* TO 'novashop'@'localhost';
FLUSH PRIVILEGES;