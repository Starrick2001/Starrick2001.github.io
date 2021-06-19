CREATE TABLE `member`(
    `email` VARCHAR(255) NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `birth` DATE NOT NULL,
    `password` VARCHAR(255) NOT NULL
);

CREATE TABLE `posts`(
    `post_id` INTEGER(11) AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `imgUrl` VARCHAR(100),
    `content` TEXT NOT NULL,
    `author` TEXT NOT NULL
); 

CREATE TABLE `comments`(
    `id` INTEGER(11) AUTO_INCREMENT PRIMARY KEY,
    `post_id` INTEGER(11) NOT NULL,
    `content` TEXT NOT NULL,
    `author` TEXT NOT NULL,
    CONSTRAINT `fk_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`)
);