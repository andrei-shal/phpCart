CREATE TABLE products (
      id INT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      price INT NOT NULL,
      currency VARCHAR(10) DEFAULT 'BYN',
      image_path VARCHAR(255) NULL
);

INSERT INTO products (title, price, currency) VALUES
      ('iPhone 15', 400000, 'BYN'),
      ('AirPods Pro', 35000, 'BYN'),
      ('MacBook Air', 700000, 'BYN');