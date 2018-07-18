<?php

  $url = parse_url(getenv("DATABASE_URL"));     
  $dsn = 'pgsql:host='.$url['host'].';port='.$url['port'].';dbname='.substr($url["path"], 1);     
  $username = $url["user"];     
  $password = $url["pass"];


return [     
	'class' => 'yii\db\Connection',     
	'dsn' => $dsn,
	'username' => $username,     
	'password' => $password,     
	'charset' => 'utf8', 
];

//return [
//    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=localhost;dbname=ideapool',
//    'dsn' => 'pgsql:host=ec2-23-21-238-28.compute-1.amazonaws.com;port=5432;dbname=d893o1rd59nnbj',
//    'username' => 'ypmhsfbyzdfzxj',
//    'password' => '86a190e6e5c6653fbc41413708a36df5906b0d18a82917b6478c34b81c1252ce',
//    'charset' => 'utf8',
//    'dsn'=>'postgres://ypmhsfbyzdfzxj:86a190e6e5c6653fbc41413708a36df5906b0d18a82917b6478c34b81c1252ce@ec2-23-21-238-28.compute-1.amazonaws.com:5432/d893o1rd59nnbj',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
//];
