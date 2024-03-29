<?php

// db connection options on almih99OOOwebhost.com
// /*
$dbname = 'id10700845_rocket_business_test_junior';
$user = 'id10700845_rocketbusiness';
$pwd = '123654a.';
// */

// db connection options on localhost
/*
$dbname = 'rocket_business_test_junior';
$user = 'rocketbusiness';
$pwd = '123654a.';
*/

// fill db with random data

$header = array(
    array(
        'Солнечный', 'Траурный', 'Плюшевый', 'Бешеный', 
        'Памятный', 'Трепетный', 'Базовый', 'Скошенный', 
        'Преданный', 'Ласковый', 'Пойманный', 'Радужный', 
        'Огненный', 'Радостный', 'Тензорный', 'Шёлковый', 
        'Пепельный', 'Ламповый', 'Жареный', 'Загнанный'
    ),
    array(
        'зайчик', 'Верник', 'глобус', 'ветер', 
        'щавель', 'пёсик', 'копчик', 'ландыш', 
        'стольник', 'мальчик', 'дольщик', 'Игорь', 
        'невод', 'егерь', 'пончик', 'лобстер', 
        'жемчуг', 'кольщик', 'йогурт', 'овод'
    ),
    array(
        'стеклянного', 'ванильного', 'резонного', 'широкого', 
        'дешёвого', 'горбатого', 'собачьего', 'исконного', 
        'волшебного', 'картонного', 'лохматого', 'арбузного', 
        'огромного', 'запойного', 'великого', 'бараньего', 
        'вандального', 'едрёного', 'парадного', 'укромного'
    ),
    array(
        'глаза', 'плова', 'Пельша', 'мира', 
        'деда', 'жира', 'мема', 'ада', 
        'бура', 'жала', 'нёба', 'гунна', 
        'хлама', 'шума', 'воза', 'сала', 
        'фена', 'зала', 'рака'
    )
);

$body = array(
    array(
        'Я помню', 'Не помню', 'Забыть бы', 'Купите', 
        'Очкуешь', 'Какое', 'Угробил', 'Хреново', 
        'Открою', 'Ты чуешь'
    ),
    array(
        'чудное', 'странное', 'некое', 'вкусное', 
        'пьяное', 'свинское', 'чоткое', 'сраное', 
        'нужное', 'конское'
    ),
    array(
        'мгновенье', 'затменье', 'хотенье', 'варенье', 
        'рождение', 'смущенье', 'печенье', 'теченье', 
        'везенье', 'ученье'
    ),
    array(
        'передо мной', 'под косячком', 'на кладбище', 'в моих мечтах', 
        'под скальпелем', 'в моих штанах', 'из-за угла', 'в моих ушах', 
        'в ночном горшке', 'из головы'
    ),
    array(
        'явилась ты', 'добилась ты', 'торчат кресты', 'стихов листы', 
        'мои трусы', 'поют дрозды', 'из темноты', 'помылась ты', 'забилась ты'
    ),
    array(
        'как'
    ),
    array(
        'мимолётное', 'детородное', 'психотропное', 'кайфоломное', 
        'очевидное', 'у воробушков', 'эдакое вот', 'нам не чуждое', 'блогородное'
    ),
    array(
        'виденье', 'сиденье', 'паренье', 'сужденье', 'вращенье', 
        'сношенье', 'смятенье', 'теченье', 'паденье', 'сплетенье'
    ),
    array(
        'как'
    ),
    array(
        'гений', 'сторож', 'символ', 'спарта', 'правда', 
        'ангел', 'водка', 'пиво', 'ахтунг'
    ),
    array(
        'чистой', 'вечной', 'тухлой', 'просит', 'грязной', 
        'липкой', 'в пене', 'женской', 'жаждет'
    ),
    array(
        'красоты', 'мерзлоты', 'суеты', 'наркоты', 'срамоты', 
        'школоты', 'типа ты', 'простоты', 'наготы'
    )
);

$files = array(
    '01.jpg', '02.jpg', '03.jpg', '04.jpg', '05.jpg', '06.jpg', 
    '07.jpg', '08.jpg', '09.jpg', '10.jpg', '11.jpg', '12.jpg'
);


function makeRandomString ($data) {
    $resault="";
    $delimeter="";
    foreach($data as $listOfWords) {
        $resault = $resault . $delimeter . $listOfWords[array_rand($listOfWords)];
        $delimeter=" ";
    }
    return $resault;
}

function getRandomFilename ($filelist) {
    return $filelist[array_rand($filelist)];
}

$db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pwd);


if(! $db->exec("CREATE TABLE `$dbname`.`articles` (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `header` VARCHAR(100) NOT NULL DEFAULT 'undefined',
                    `text` VARCHAR(250) NOT NULL,
                    `image_url` VARCHAR(45) NOT NULL,
                    `link_url` VARCHAR(100) NOT NULL,
                    PRIMARY KEY (`id`));")) {
    // table exists
    $db->exec("TRUNCATE TABLE articles;");
}

$query=$db->prepare("INSERT INTO articles(header, text, image_url, link_url)
                     VALUES(:h, :t, :i, :l);");
for($i=0; $i<60; $i++) {
    $num=$i+1;
    $query->execute(
        array(
            'h' => makeRandomString($header) . "($num)",
            't' => makeRandomString($body),
            'i' => getRandomFilename($files),
            'l' => '#'
        )
    );
};

echo "finished";
?>