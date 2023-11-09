CREATE TABLE `book` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `description` VARCHAR(200) NOT NULL
);

CREATE TABLE `category_product` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `category_id` INT,
  `product_id` INT
)
ALTER TABLE `book`
ADD CONSTRAINT fk_book_author
FOREIGN KEY (author_id)
REFERENCES `author`(id);

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

INSERT INTO book (title, author_id)
VALUES
  ('Les Voyageurs du Temps', 1),
  ('Un Amour Inoubliable', 2),
  ('L''Énigme de la Chambre Rouge', 3),
  ('Le Royaume des Dragons', 4),
  ('L''Art de la Programmation', 5),
  ('Les Secrets du Cosmos', 6),
  ('Au Cœur de la Forêt', 7),
  ('Le Mystère de la Pyramide', 8),
  ('La Quête de l''Épée Magique', 9),
  ('Programmation Avancée en PHP', 10);

INSERT INTO book (title, author_id, description)
VALUES
  (`Les Voyageurs du Temps`, 1, `Un passionnant voyage à travers les époques.`),
  (`Un Amour Inoubliable`, 2, `Une histoire d'amour émouvante et inoubliable.`),
  (`L'Énigme de la Chambre Rouge`, 3, `Un mystère palpitant dans un manoir hanté.`),
  (`Le Royaume des Dragons`, 4, `Une aventure fantastique avec des dragons majestueux.`),
  (`L'Art de la Programmation`, 5, `Un guide essentiel pour les programmeurs.`),
  (`Les Secrets du Cosmos`, 6, `Une exploration fascinante de l'univers.`),
  (`Au Cœur de la Forêt`, 7, `Une aventure en pleine nature.`),
  (`Le Mystère de la Pyramide`, 8, `Une quête archéologique passionnante.`),
  (`La Quête de l'Épée Magique`, 9, `Un voyage épique pour sauver le royaume.`),
  (`Programmation Avancée en PHP`, 10, `Un guide avancé pour les développeurs PHP.`);
