CREATE TABLE `posts` (`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        `title` varchar(255) NOT NULL,
                        `content` text NOT NULL,
                        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8;


INSERT INTO `posts` (`id`, `title`, `content`, `created_at`)
VALUES
    (1,	'Article One',	'Pie muffin cupcake wafer donut sweet candy canes. Oat cake jelly oat cake carrot cake cotton candy powder toffee. Tart cupcake tart jelly beans fruitcake pie icing cupcake tootsie roll. Tart powder chocolate fruitcake powder chocolate',	CURRENT_TIMESTAMP),
    (2,	'Article Two',	'Jujubes bonbon jelly beans danish lemon drops soufflé tiramisu croissant marzipan. Tootsie roll chocolate apple pie pie chocolate cake gingerbread. Donut halvah jelly beans marzipan sugar plum. Sugar plum brownie pastry liquorice croissan',	CURRENT_TIMESTAMP),
    (3,	'Article Three',	'Pie donut halvah gummi bears jujubes pudding fruitcake liquorice. Ice cream cotton candy muffin bonbon candy canes oat cake chupa chups',	CURRENT_TIMESTAMP);;
