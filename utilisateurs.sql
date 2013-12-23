CREATE TABLE `utilisateurs` (
	`userid` int(10) NOT NULL auto_increment,
	`login` varchar(20),
	`password` varchar(30),
	`mail` varchar(100),
	UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 auto_increment=1;


ALTER TABLE `Billets`
ADD id_auteur int(10);


insert into utilisateurs values(1, "user_test", "passw_test", "user@orange.com");
