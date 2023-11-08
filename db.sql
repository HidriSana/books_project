CREATE TABLE `category` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL
)

CREATE TABLE `category_product` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `category_id` INT,
  `product_id` INT
)
ALTER TABLE category_product
ADD CONSTRAINT fk_category_product_product
FOREIGN KEY (product_id)
REFERENCES `product`(id);

CREATE TABLE `book_category` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `book_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  FOREIGN KEY (`book_id`) REFERENCES book(id),
  FOREIGN KEY (`category_id`) REFERENCES category(id)
);

CREATE TABLE `category` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL
);

INSERT INTO book (title, author_id) VALUES
  ("Les Voyageurs du Temps", 1),
  ("Un Amour Inoubliable", 2),
  ("L'Énigme de la Chambre Rouge", 3),
  ("Le Royaume des Dragons", 4),
  ("L'Art de la Programmation", 5);

  INSERT INTO book_category (book_id, category_id) VALUES
  (1, 1),  
  (2, 2), 
  (3, 3),  
  (4, 4),
  (5, 5);  
  
  SELECT b.id, b.title, a.firstname, a.lastname, c.name
  FROM book b
  LEFT JOIN author a ON b.author_id = a.id;
  LEFT JOIN category c ON b.category_id = c.id;
  WHERE b.id =  . $_GET['identifiant'];

CREATE TABLE `user` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(100) NOT NULL
);
