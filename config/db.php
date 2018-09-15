<?php


if (!YII_ENV_DEV) {
//    $url = parse_url(getenv("DATABASE_URL"));
//    $dsn = 'pgsql:host=' . $url['host'] . ';port=' . $url['port'] . ';dbname=' . substr($url["path"], 1);
//    $username = $url["user"];
//    $password = $url["pass"];
    $dsn = 'mysql:host=server01.inetadmin.eu;dbname=roszkopf_ideapool';
    $username = 'roszkopf_ideapool';
    $password = 'Codementor$18';


} else {
    $dsn = 'mysql:host=localhost;dbname=ideapool';
    $username = 'root';
    $password = 'root';
}


return [
    'class' => 'yii\db\Connection',
    'dsn' => $dsn,
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
];
