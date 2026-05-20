CREATE TABLE products (
      id INT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      price INT NOT NULL,
      currency VARCHAR(10) DEFAULT 'BYN',
      image_path VARCHAR(255) NULL
);

INSERT INTO products (title, price, currency, image_path) VALUES
      ('iPhone 15', 400000, 'BYN', 'public/img/iphone-15.png'),
      ('iPhone 15 Pro Max', 550000, 'BYN', 'public/img/iphone-15-promax.png'),
      ('Samsung Galaxy S24 Ultra', 520000, 'BYN', 'public/img/galaxy-s24.png'),
      ('Xiaomi 14 Ultra', 430000, 'BYN', 'public/img/xiaomi-14.png'),

      ('AirPods Pro 2', 35000, 'BYN', 'public/img/airpods-pro.png'),
      ('Sony WH-1000XM5', 140000, 'BYN', 'public/img/sony-xm5.png');