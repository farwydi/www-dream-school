<?php

/*
 * Copyright (C) 2016 Leonid aka DEX Zharikov
 * Email: leon.zharikov@gmail.com
 * GitHub: https://github.com/LeonDEXZ
 * License: GNU General Public License
 */


function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function run_sql_file($commands){

    //delete comments
    $lines = explode("\n",$commands);
    $commands = '';
    foreach($lines as $line){
        $line = trim($line);
        if( $line && !startsWith($line,'--') ){
            $commands .= $line . "\n";
        }
    }

    //convert to array
    $commands = explode(";", $commands);

    //run commands
    $total = $success = 0;
    foreach($commands as $command){
        if(trim($command)){
            $success += (@mysql_query($command)==false ? 0 : 1);
            $total += 1;
        }
    }

    //return number of successful queries and total number of queries found
    return array(
        "success" => $success,
        "total" => $total
    );
}

if (
	isset($_GET["sitedir"])
	&& isset($_GET["ip"])
	&& isset($_GET["port"])
	&& isset($_GET["name"])
	&& isset($_GET["password"])
	&& isset($_GET["table"])
)
{
	if ($_GET["table"] != "")
	{
		// def var
		$password = "";
		$name = "root";
		$port = "3306";
		$host = "localhost";
		$sitedir = "localhost/build";
		$table = $_GET["table"];

		if ($_GET["sitedir"] != "") {
			$sitedir = $_GET["sitedir"];
		}
		if ($_GET["ip"] != "") {
			$host = $_GET["ip"];
		}
		if ($_GET["port"] != "") {
			$port = $_GET["port"];
		}
		if ($_GET["name"] != "") {
			$name = $_GET["name"];
		}
		if ($_GET["password"] != "") {
			$password = $_GET["password"];
		}

		// TEST
		$link = mysql_connect($host.":".(int)$port, $name, $password) or die("mysql_connect == error");

$q = <<<EOD
DROP DATABASE IF EXISTS `{$table}`;
CREATE DATABASE IF NOT EXISTS `{$table}`;
USE `{$table}`;
CREATE TABLE IF NOT EXISTS `auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` char(50) DEFAULT NULL,
  `hash_auth` char(255) DEFAULT NULL,
  `steamID` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL DEFAULT '',
  `preview` varchar(20000) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
INSERT INTO `blog` (`id`, `title`, `preview`, `content`) VALUES
	(1, 'М.Видео DOTA2 Open by Red Square уже в июле!', 'Компания Game Show совместно с крупнейшей российской торговой сетью М.Видео и производителем компьютерной периферии Red Square анонсируют турнир...', 'А вот собственно и само описание подехало ..................................................................................................................................... конец'),
	(2, 'Короткометражки для Valve: лучшее', 'Не за горами The International 2016. В июне уже традиционно Valve объявили конкурс короткометражных фильмов от пользователей, прием работ на...', '<b>Не за горами The International 2016. В июне уже традиционно Valve объявили конкурс короткометражных фильмов от пользователей, прием работ на который закончится через неделю. Мы подобрали для вас наиболее интересные работы как от признанных видеоблоггеров, давно работающих в сфере Dota 2, так и тех, кто только пробует свои силы в видеомейкерстве или в конкретной сфере.</b>\\r\\n<p>Говорят, что краткость, сестра таланта - поэтому наиболее жесткое требование разработчиков было связано с временными рамками. Лишь одна минута на все: на демонстрацию своего скилла, на реализацию заготовки, на детали и пасхалки. Тем интереснее взглянуть, как авторы ужимали свои задумки в эти рамки.</p><iframe class="text-center" width="560" height="315" src="https://www.youtube.com/embed/KhdTEZEJVrA" frameborder="0" allowfullscreen></iframe>\\r\\n<p>Большинство конкурсных работ выполнено в Source Filmmaker. Создатели видео уже привычно использовали модельки героев в своих личных целях. Так, одним из самых популярных роликов такого типа стал сюжет Настоящий герой от MayorPixel, который опубликовала на своем канале известная видеостудия DotaCinema. Большая поддержка фанатов DC вполне в состоянии помочь работе оказаться в числе лучших: впрочем, она того действительно стоит.</p>\\r\\n<p>Ролик от Алексея Дмитриева - безумно динамичный и яркий. The Courage довольно круто показал моменты битвы и добавляет трагичности в конце. Сам автор отмечает, что к созданию видео причастен не он один:</p>\\r\\n<blockquote><p>Ооо, ролик создавался с конца мая, как только мы узнали о начале конкурса. Сразу же я собрал своих друзей-сфмеров: Portability, Evil, Niknite.</p><p>Изначально мы долго метались при выборе идеи для ролика - хотели сделать перемещение Войда во времена Доты 2012 года и до сегоднешнего дня, комедию про Пуджика и простой интродьюс.\\r\\nЭта же идея в итоге пришла после рейтинговой игры, когда мы дефались против мегакрипов почти тем же пиком, что и в ролике. Вдохновившись, мы буквально за два дня сделил сториборд и приступили к работе.</p><p>В процессе создания проект переделывали от начала и до конца несколько раз, то в хронометраж не укладывались, то сцена не нравилась,то проект крашился и приходилось сцены по новой воссоздавать. От изначальной версии ролика осталось 30% сцен, остальные исправляли, чтобы сделать сюжет понятным для зрителя.</p></blockquote>sdfsdfsfsdfsdfsdfsfdsdfsdfsfdsdsssss'),
	(3, 'ПРимер 2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, doloremque, facilis! Maiores eum sunt, consequuntur, quae deserunt vero inventore, molestias necessitatibus minus amet ducimus nulla quasi voluptates nobis nisi unde?', 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Дорогу жизни она по всей рыбного подпоясал жаренные буквенных, взобравшись предупреждал на берегу рукописи! Осталось от всех текста лучше, даже рот курсивных рукопись власти вдали, на берегу продолжил коварный запятой, грамматики прямо, переписали живет! Свою бросил скатился реторический проектах, свой ведущими рыбного щеке буквоград пояс рекламных предложения предупредила подпоясал продолжил алфавит океана ты маленький. На берегу его что текстами, деревни, сих повстречался не, если она там, обеспечивает парадигматическая взобравшись ты собрал свой свою. Не, необходимыми, оксмокс? Великий ведущими буквенных снова большого ipsum свою собрал, образ маленький оксмокс одна, имени семантика свое. Назад великий живет знаках, ipsum решила он журчит. Точках пунктуация несколько вопроса маленький это свое за взобравшись, вскоре свой вершину путь, коварных жаренные, инициал. Запятой единственное ему снова, залетают взгляд знаках до города текстов образ! Имени одна lorem эта предложения языкового осталось семантика там грамматики! Послушавшись рот, рукопись. Снова бросил, коварный языком проектах все, языкового ты от всех прямо что своего злых большой предупреждал до они заголовок переулка родного власти ему, не путь. О курсивных они, на берегу эта путь живет взгляд заманивший текста, осталось выйти своего, все оксмокс грамматики заголовок текстами проектах вопроса. Пояс взгляд сих за, свой своего возвращайся, продолжил злых родного маленькая ее повстречался безорфографичный последний мир сбить пустился заголовок lorem текстов одна! Взгляд, щеке необходимыми он наш текста языкового снова переписывается бросил дал, страна дороге языком от всех, инициал буквоград залетают маленькая города.'),
	(4, 'b34545', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, doloremque, facilis! Maiores eum sunt, consequuntur, quae deserunt vero inventore, molestias necessitatibus minus amet ducimus nulla quasi voluptates nobis nisi unde?', 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Дорогу жизни она по всей рыбного подпоясал жаренные буквенных, взобравшись предупреждал на берегу рукописи! Осталось от всех текста лучше, даже рот курсивных рукопись власти вдали, на берегу продолжил коварный запятой, грамматики прямо, переписали живет! Свою бросил скатился реторический проектах, свой ведущими рыбного щеке буквоград пояс рекламных предложения предупредила подпоясал продолжил алфавит океана ты маленький. На берегу его что текстами, деревни, сих повстречался не, если она там, обеспечивает парадигматическая взобравшись ты собрал свой свою. Не, необходимыми, оксмокс? Великий ведущими буквенных снова большого ipsum свою собрал, образ маленький оксмокс одна, имени семантика свое. Назад великий живет знаках, ipsum решила он журчит. Точках пунктуация несколько вопроса маленький это свое за взобравшись, вскоре свой вершину путь, коварных жаренные, инициал. Запятой единственное ему снова, залетают взгляд знаках до города текстов образ! Имени одна lorem эта предложения языкового осталось семантика там грамматики! Послушавшись рот, рукопись. Снова бросил, коварный языком проектах все, языкового ты от всех прямо что своего злых большой предупреждал до они заголовок переулка родного власти ему, не путь. О курсивных они, на берегу эта путь живет взгляд заманивший текста, осталось выйти своего, все оксмокс грамматики заголовок текстами проектах вопроса. Пояс взгляд сих за, свой своего возвращайся, продолжил злых родного маленькая ее повстречался безорфографичный последний мир сбить пустился заголовок lorem текстов одна! Взгляд, щеке необходимыми он наш текста языкового снова переписывается бросил дал, страна дороге языком от всех, инициал буквоград залетают маленькая города.'),
	(5, '1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, doloremque, facilis! Maiores eum sunt, consequuntur, quae deserunt vero inventore, molestias necessitatibus minus amet ducimus nulla quasi voluptates nobis nisi unde?', 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Дорогу жизни она по всей рыбного подпоясал жаренные буквенных, взобравшись предупреждал на берегу рукописи! Осталось от всех текста лучше, даже рот курсивных рукопись власти вдали, на берегу продолжил коварный запятой, грамматики прямо, переписали живет! Свою бросил скатился реторический проектах, свой ведущими рыбного щеке буквоград пояс рекламных предложения предупредила подпоясал продолжил алфавит океана ты маленький. На берегу его что текстами, деревни, сих повстречался не, если она там, обеспечивает парадигматическая взобравшись ты собрал свой свою. Не, необходимыми, оксмокс? Великий ведущими буквенных снова большого ipsum свою собрал, образ маленький оксмокс одна, имени семантика свое. Назад великий живет знаках, ipsum решила он журчит. Точках пунктуация несколько вопроса маленький это свое за взобравшись, вскоре свой вершину путь, коварных жаренные, инициал. Запятой единственное ему снова, залетают взгляд знаках до города текстов образ! Имени одна lorem эта предложения языкового осталось семантика там грамматики! Послушавшись рот, рукопись. Снова бросил, коварный языком проектах все, языкового ты от всех прямо что своего злых большой предупреждал до они заголовок переулка родного власти ему, не путь. О курсивных они, на берегу эта путь живет взгляд заманивший текста, осталось выйти своего, все оксмокс грамматики заголовок текстами проектах вопроса. Пояс взгляд сих за, свой своего возвращайся, продолжил злых родного маленькая ее повстречался безорфографичный последний мир сбить пустился заголовок lorem текстов одна! Взгляд, щеке необходимыми он наш текста языкового снова переписывается бросил дал, страна дороге языком от всех, инициал буквоград залетают маленькая города.'),
	(6, '45', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, doloremque, facilis! Maiores eum sunt, consequuntur, quae deserunt vero inventore, molestias necessitatibus minus amet ducimus nulla quasi voluptates nobis nisi unde?', 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Дорогу жизни она по всей рыбного подпоясал жаренные буквенных, взобравшись предупреждал на берегу рукописи! Осталось от всех текста лучше, даже рот курсивных рукопись власти вдали, на берегу продолжил коварный запятой, грамматики прямо, переписали живет! Свою бросил скатился реторический проектах, свой ведущими рыбного щеке буквоград пояс рекламных предложения предупредила подпоясал продолжил алфавит океана ты маленький. На берегу его что текстами, деревни, сих повстречался не, если она там, обеспечивает парадигматическая взобравшись ты собрал свой свою. Не, необходимыми, оксмокс? Великий ведущими буквенных снова большого ipsum свою собрал, образ маленький оксмокс одна, имени семантика свое. Назад великий живет знаках, ipsum решила он журчит. Точках пунктуация несколько вопроса маленький это свое за взобравшись, вскоре свой вершину путь, коварных жаренные, инициал. Запятой единственное ему снова, залетают взгляд знаках до города текстов образ! Имени одна lorem эта предложения языкового осталось семантика там грамматики! Послушавшись рот, рукопись. Снова бросил, коварный языком проектах все, языкового ты от всех прямо что своего злых большой предупреждал до они заголовок переулка родного власти ему, не путь. О курсивных они, на берегу эта путь живет взгляд заманивший текста, осталось выйти своего, все оксмокс грамматики заголовок текстами проектах вопроса. Пояс взгляд сих за, свой своего возвращайся, продолжил злых родного маленькая ее повстречался безорфографичный последний мир сбить пустился заголовок lorem текстов одна! Взгляд, щеке необходимыми он наш текста языкового снова переписывается бросил дал, страна дороге языком от всех, инициал буквоград залетают маленькая города.'),
	(7, 'sfd', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, doloremque, facilis! Maiores eum sunt, consequuntur, quae deserunt vero inventore, molestias necessitatibus minus amet ducimus nulla quasi voluptates nobis nisi unde?', 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Дорогу жизни она по всей рыбного подпоясал жаренные буквенных, взобравшись предупреждал на берегу рукописи! Осталось от всех текста лучше, даже рот курсивных рукопись власти вдали, на берегу продолжил коварный запятой, грамматики прямо, переписали живет! Свою бросил скатился реторический проектах, свой ведущими рыбного щеке буквоград пояс рекламных предложения предупредила подпоясал продолжил алфавит океана ты маленький. На берегу его что текстами, деревни, сих повстречался не, если она там, обеспечивает парадигматическая взобравшись ты собрал свой свою. Не, необходимыми, оксмокс? Великий ведущими буквенных снова большого ipsum свою собрал, образ маленький оксмокс одна, имени семантика свое. Назад великий живет знаках, ipsum решила он журчит. Точках пунктуация несколько вопроса маленький это свое за взобравшись, вскоре свой вершину путь, коварных жаренные, инициал. Запятой единственное ему снова, залетают взгляд знаках до города текстов образ! Имени одна lorem эта предложения языкового осталось семантика там грамматики! Послушавшись рот, рукопись. Снова бросил, коварный языком проектах все, языкового ты от всех прямо что своего злых большой предупреждал до они заголовок переулка родного власти ему, не путь. О курсивных они, на берегу эта путь живет взгляд заманивший текста, осталось выйти своего, все оксмокс грамматики заголовок текстами проектах вопроса. Пояс взгляд сих за, свой своего возвращайся, продолжил злых родного маленькая ее повстречался безорфографичный последний мир сбить пустился заголовок lorem текстов одна! Взгляд, щеке необходимыми он наш текста языкового снова переписывается бросил дал, страна дороге языком от всех, инициал буквоград залетают маленькая города.'),
	(8, 'ПРимерddd54454', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, doloremque, facilis! Maiores eum sunt, consequuntur, quae deserunt vero inventore, molestias necessitatibus minus amet ducimus nulla quasi voluptates nobis nisi unde?', 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Дорогу жизни она по всей рыбного подпоясал жаренные буквенных, взобравшись предупреждал на берегу рукописи! Осталось от всех текста лучше, даже рот курсивных рукопись власти вдали, на берегу продолжил коварный запятой, грамматики прямо, переписали живет! Свою бросил скатился реторический проектах, свой ведущими рыбного щеке буквоград пояс рекламных предложения предупредила подпоясал продолжил алфавит океана ты маленький. На берегу его что текстами, деревни, сих повстречался не, если она там, обеспечивает парадигматическая взобравшись ты собрал свой свою. Не, необходимыми, оксмокс? Великий ведущими буквенных снова большого ipsum свою собрал, образ маленький оксмокс одна, имени семантика свое. Назад великий живет знаках, ipsum решила он журчит. Точках пунктуация несколько вопроса маленький это свое за взобравшись, вскоре свой вершину путь, коварных жаренные, инициал. Запятой единственное ему снова, залетают взгляд знаках до города текстов образ! Имени одна lorem эта предложения языкового осталось семантика там грамматики! Послушавшись рот, рукопись. Снова бросил, коварный языком проектах все, языкового ты от всех прямо что своего злых большой предупреждал до они заголовок переулка родного власти ему, не путь. О курсивных они, на берегу эта путь живет взгляд заманивший текста, осталось выйти своего, все оксмокс грамматики заголовок текстами проектах вопроса. Пояс взгляд сих за, свой своего возвращайся, продолжил злых родного маленькая ее повстречался безорфографичный последний мир сбить пустился заголовок lorem текстов одна! Взгляд, щеке необходимыми он наш текста языкового снова переписывается бросил дал, страна дороге языком от всех, инициал буквоград залетают маленькая города.'),
	(9, 'ПРимерdddvv', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, doloremque, facilis! Maiores eum sunt, consequuntur, quae deserunt vero inventore, molestias necessitatibus minus amet ducimus nulla quasi voluptates nobis nisi unde?', 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Дорогу жизни она по всей рыбного подпоясал жаренные буквенных, взобравшись предупреждал на берегу рукописи! Осталось от всех текста лучше, даже рот курсивных рукопись власти вдали, на берегу продолжил коварный запятой, грамматики прямо, переписали живет! Свою бросил скатился реторический проектах, свой ведущими рыбного щеке буквоград пояс рекламных предложения предупредила подпоясал продолжил алфавит океана ты маленький. На берегу его что текстами, деревни, сих повстречался не, если она там, обеспечивает парадигматическая взобравшись ты собрал свой свою. Не, необходимыми, оксмокс? Великий ведущими буквенных снова большого ipsum свою собрал, образ маленький оксмокс одна, имени семантика свое. Назад великий живет знаках, ipsum решила он журчит. Точках пунктуация несколько вопроса маленький это свое за взобравшись, вскоре свой вершину путь, коварных жаренные, инициал. Запятой единственное ему снова, залетают взгляд знаках до города текстов образ! Имени одна lorem эта предложения языкового осталось семантика там грамматики! Послушавшись рот, рукопись. Снова бросил, коварный языком проектах все, языкового ты от всех прямо что своего злых большой предупреждал до они заголовок переулка родного власти ему, не путь. О курсивных они, на берегу эта путь живет взгляд заманивший текста, осталось выйти своего, все оксмокс грамматики заголовок текстами проектах вопроса. Пояс взгляд сих за, свой своего возвращайся, продолжил злых родного маленькая ее повстречался безорфографичный последний мир сбить пустился заголовок lorem текстов одна! Взгляд, щеке необходимыми он наш текста языкового снова переписывается бросил дал, страна дороге языком от всех, инициал буквоград залетают маленькая города.'),
	(10, 'ПРимерddds3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, doloremque, facilis! Maiores eum sunt, consequuntur, quae deserunt vero inventore, molestias necessitatibus minus amet ducimus nulla quasi voluptates nobis nisi unde?', 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Дорогу жизни она по всей рыбного подпоясал жаренные буквенных, взобравшись предупреждал на берегу рукописи! Осталось от всех текста лучше, даже рот курсивных рукопись власти вдали, на берегу продолжил коварный запятой, грамматики прямо, переписали живет! Свою бросил скатился реторический проектах, свой ведущими рыбного щеке буквоград пояс рекламных предложения предупредила подпоясал продолжил алфавит океана ты маленький. На берегу его что текстами, деревни, сих повстречался не, если она там, обеспечивает парадигматическая взобравшись ты собрал свой свою. Не, необходимыми, оксмокс? Великий ведущими буквенных снова большого ipsum свою собрал, образ маленький оксмокс одна, имени семантика свое. Назад великий живет знаках, ipsum решила он журчит. Точках пунктуация несколько вопроса маленький это свое за взобравшись, вскоре свой вершину путь, коварных жаренные, инициал. Запятой единственное ему снова, залетают взгляд знаках до города текстов образ! Имени одна lorem эта предложения языкового осталось семантика там грамматики! Послушавшись рот, рукопись. Снова бросил, коварный языком проектах все, языкового ты от всех прямо что своего злых большой предупреждал до они заголовок переулка родного власти ему, не путь. О курсивных они, на берегу эта путь живет взгляд заманивший текста, осталось выйти своего, все оксмокс грамматики заголовок текстами проектах вопроса. Пояс взгляд сих за, свой своего возвращайся, продолжил злых родного маленькая ее повстречался безорфографичный последний мир сбить пустился заголовок lorem текстов одна! Взгляд, щеке необходимыми он наш текста языкового снова переписывается бросил дал, страна дороге языком от всех, инициал буквоград залетают маленькая города.'),
	(11, 'dfg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, doloremque, facilis! Maiores eum sunt, consequuntur, quae deserunt vero inventore, molestias necessitatibus minus amet ducimus nulla quasi voluptates nobis nisi unde?', 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Дорогу жизни она по всей рыбного подпоясал жаренные буквенных, взобравшись предупреждал на берегу рукописи! Осталось от всех текста лучше, даже рот курсивных рукопись власти вдали, на берегу продолжил коварный запятой, грамматики прямо, переписали живет! Свою бросил скатился реторический проектах, свой ведущими рыбного щеке буквоград пояс рекламных предложения предупредила подпоясал продолжил алфавит океана ты маленький. На берегу его что текстами, деревни, сих повстречался не, если она там, обеспечивает парадигматическая взобравшись ты собрал свой свою. Не, необходимыми, оксмокс? Великий ведущими буквенных снова большого ipsum свою собрал, образ маленький оксмокс одна, имени семантика свое. Назад великий живет знаках, ipsum решила он журчит. Точках пунктуация несколько вопроса маленький это свое за взобравшись, вскоре свой вершину путь, коварных жаренные, инициал. Запятой единственное ему снова, залетают взгляд знаках до города текстов образ! Имени одна lorem эта предложения языкового осталось семантика там грамматики! Послушавшись рот, рукопись. Снова бросил, коварный языком проектах все, языкового ты от всех прямо что своего злых большой предупреждал до они заголовок переулка родного власти ему, не путь. О курсивных они, на берегу эта путь живет взгляд заманивший текста, осталось выйти своего, все оксмокс грамматики заголовок текстами проектах вопроса. Пояс взгляд сих за, свой своего возвращайся, продолжил злых родного маленькая ее повстречался безорфографичный последний мир сбить пустился заголовок lorem текстов одна! Взгляд, щеке необходимыми он наш текста языкового снова переписывается бросил дал, страна дороге языком от всех, инициал буквоград залетают маленькая города.'),
	(12, 'М.Видео DOTA2 Open by Red Square уже в июле!', 'Компания Game Show совместно с крупнейшей российской торговой сетью М.Видео и производителем компьютерной периферии Red Square анонсируют турнир...', 'А вот собственно и само описание подехало ..................................................................................................................................... конец'),
	(13, 'ddddddg', 'Компания Game Show совместно с крупнейшей российской торговой сетью М.Видео и производителем компьютерной периферии Red Square анонсируют турнир...', 'А вот собственно и само описание подехало ..................................................................................................................................... конец');
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `place` char(50) DEFAULT NULL,
  `first` tinyint(1) DEFAULT NULL,
  `answer` int(10) unsigned DEFAULT NULL,
  `comment` text,
  `user` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
INSERT INTO `comments` (`id`, `place`, `first`, `answer`, `comment`, `user`) VALUES
	(1, 'trainer_profile_1', 1, NULL, 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Назад мир, точках переулка злых если взгляд маленький несколько путь? Прямо встретил дал, дороге своего. Прямо, взгляд, ты. Послушавшись заголовок то обеспечивает свою парадигматическая ipsum там, подзаголовок залетают вопрос вершину, несколько о имени. Запятой силуэт бросил, от всех курсивных свой. Страна, все языком однажды встретил свой вопрос. Вопроса вскоре предложения осталось до инициал, своих ты использовало меня вдали предупредила по всей, сбить встретил не коварных. Пояс сбить семантика, все заглавных за текстов?', 3),
	(5, 'trainer_profile_1', 1, NULL, 'h5h565h65h6', 3),
	(12, 'trainer_profile_1', NULL, NULL, '\\n\\r', 3),
	(13, 'trainer_profile_1', NULL, NULL, '*/select * from auth;', 3),
	(24, 'trainer_profile_1', NULL, NULL, 'ghjgh', 3),
	(36, 'trainer_profile_2', NULL, NULL, 'bvnmbnm', 3),
	(39, 'blog_1', NULL, NULL, 'gfhj', 3),
	(40, 'trainer_profile_1', NULL, NULL, 'апрспмр', 3),
	(51, 'blog_2', NULL, NULL, 'asdasd', 3),
	(52, 'blog_2', NULL, NULL, 'sdfsdsd', 3),
	(53, 'blog_2', NULL, NULL, 'sdfsdf', 3),
	(54, 'blog_2', NULL, NULL, 'd', 3),
	(55, 'blog_3', NULL, NULL, 'hjghjk', 3),
	(56, 'blog_2', NULL, NULL, '3', 3),
	(57, 'trainer_profile_1', NULL, NULL, 'dfgbfdg', 3),
	(58, 'blog_1', NULL, NULL, 'asd', 3),
	(59, 'trainer_profile_1', NULL, NULL, 'dfgfg', 3),
	(60, 'trainer_profile_1', NULL, NULL, 'ghjhjg', 3);
CREATE TABLE IF NOT EXISTS `trainer_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL,
  `nickname` varchar(80) DEFAULT NULL,
  `info` text,
  `url` char(50) DEFAULT NULL,
  `type` char(80) DEFAULT NULL,
  `rmm` smallint(5) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
INSERT INTO `trainer_profile` (`id`, `first_name`, `last_name`, `nickname`, `info`, `url`, `type`, `rmm`) VALUES
	(1, 'Владимир', 'Аносов', 'PGG', 'Возраст: 23 года. <br>8-9 лет играю в Dota1 - Dota2. <br>Играл в многих профессиональных командах, в данный момент играю в команде m5. <br>Если кто не знает даже ездил капитаном m5 на \' THE INTERNATINOAL 2 "<br>играю на всех ролях, от фулл супорта до мида. <br>Обучение игроков будет проходить на любую роль.', NULL, 'coach,booster', 9521),
	(2, 'sdf', NULL, NULL, 'asda', NULL, 'coach,booster', 0),
	(3, 'nm,', NULL, NULL, 'hj', NULL, 'coach', 0);
EOD;

		mysql_query("SET NAMES 'utf8'"); 
		mysql_query("SET CHARACTER SET 'utf8'");
		mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");
		run_sql_file($q);

		// BUILD
$date = <<<EOD
<?php
/*
 * Copyright (C) 2016 Leonid aka DEX Zharikov
 * email: leon.zharikov@gmail.com
 * git: https://github.com/leonzharikov
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

defined('DEX_INDEX') or die;

\$_GConfig['name'] = 'DEX';

\$_GConfig['db_enable'] = true;
\$_GConfig['db_host'] = '{$host}';
\$_GConfig['db_port'] = '{$port}';
\$_GConfig['db_user'] = '{$name}';
\$_GConfig['db_password'] = '{$password}';
\$_GConfig['db_database'] = '{$table}';
\$_GConfig['db_encoding'] = 'utf8';

\$_GConfig['def_controller'] = 'dreamschool';

\$_GConfig['tmp_main_file'] = 'DreamSchool/main_tmp.php';

\$_GConfig['lang'] = 'ru'; // name lang file php for dir lang

define('DEX_SITE_PATH_LITE', '{$sitedir}');
define('DEX_SITE_PATH', 'http://'.DEX_SITE_PATH_LITE);
EOD;
		file_put_contents("../configuration.php", $date);

		if (mysql_select_db($table)) {
			die("Готово! Не забудьте удалить папку Installer\\ <a href=\"http://{$sitedir}\">К сайту</a>");
		} 
	}
	else die("MySQL Database Table == empty!");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Installer DEX CMS</title>
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
	<style>
		body {
			background-color: #404040;
			margin: 0;
			color: #fff;
			font-size: 18px;
			font-family: 'PT Sans', sans-serif;
		}
		.main {
			margin: 0 auto;
			width: 960px;
			border-left: 4px solid #b30000;
			border-right: 4px solid #b30000;
			background-color: #262626;
			padding: 25px;
		}
		input {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			box-sizing: border-box;
		}
	</style>
</head>
<body>
	<div class="main">
		<h1>DEX CMS INSTALLER</h1>
		<form action="index.php" method="get">
			<h3>Настройка сайта</h3>

			<label>Site Location:</label>
			<input type="text" name="sitedir" placeholder="localhost/build">

			<h3>Настройка MySQL</h3>

			<label>MySQL Location:</label>
			<input type="text" name="ip" placeholder="localhost">

			<label>MySQL Port:</label>
			<input type="text" name="port" placeholder="3306">

			<label>MySQL Name:</label>
			<input type="text" name="name" placeholder="root">

			<label>MySQL Password:</label>
			<input type="password" name="password" placeholder="empty">

			<label><strong>*</strong> MySQL Table:</label>
			<input type="text" name="table" placeholder="MySQL Database Table">

			<br>
			<br>

			<input type="submit" value="Install"> 
		</form>
	</div>
</body>
</html>