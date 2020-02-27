<?php
include("$_SERVER[DOCUMENT_ROOT]/config/database.php");
//Connexion a la DB et creation de la DB
try
{
    $db = new PDO("mysql:host=172.18.0.1", 'root', 'rootpass');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("CREATE DATABASE IF NOT EXISTS db_camagru");
    $db->query("use db_camagru");
}

catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

//Creation des tables
try 
{
    $sql = "
    CREATE TABLE IF NOT EXISTS utilisateurs (
        id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username varchar(32) NOT NULL UNIQUE,
        email varchar(255) NOT NULL UNIQUE,
        passwd text(512) NOT NULL,
        confirmation tinyint DEFAULT NULL,
        confirmation_code text DEFAULT NULL,
        notifications boolean DEFAULT 1
    );

    CREATE TABLE IF NOT EXISTS pwdReset (
        pwdResetId int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        pwdResetEmail text NOT NULL,
        pwdResetSelector text NOT NULL,
        pwdResetToken longtext NOT NULL,
        pwdResetExpires text NOT NULL
    );

	CREATE TABLE IF NOT EXISTS images (
        id_image int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        dir tinytext NOT NULL,
        user varchar(32) NOT NULL,
        nb_like int(11) DEFAULT 0,
        titleImage text NULL
    );
    
	CREATE TABLE IF NOT EXISTS commentaires (
	    id_comments int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	    comment TEXT NOT NULL,
        id_image int(11) NOT NULL,
        username varchar(32) NOT NULL
    );
    
    CREATE TABLE IF NOT EXISTS likes (
        id_like int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        id_image int(11) NOT NULL,
        username_like varchar(32) NOT NULL,
        likes boolean DEFAULT NULL
    );
    ";
    $db->exec($sql);
}

catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

?>