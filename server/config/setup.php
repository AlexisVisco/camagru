<?php

// Le fichier db.sql est irectement executé lors du docker compose.
// de ce fait il n'y a pas besoin de setup la base de donnée.
// Lors de la configuration

function setup()
{
    $d = new Database();
    $d->q("
        CREATE TABLE `user`(
            `id` VARCHAR(255) PRIMARY KEY,
            `username` VARCHAR(255) UNIQUE NOT NULL,
            `email` VARCHAR(255) UNIQUE NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `confirmed` BOOLEAN DEFAULT 0,
          `notified` BOOLEAN DEFAULT 0
        );
        
        CREATE TABLE `token` (
          `id` varchar(255) NOT NULL,
          `token` varchar(255) PRIMARY KEY,
          `type` int(11) NOT NULL
        );
        
        
        CREATE TABLE `picture` (
          `id` VARCHAR(255) PRIMARY KEY,
          `id_user` VARCHAR(255) NOT NULL,
          `data` MEDIUMTEXT NOT NULL,
          `date` DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE TABLE `like` (
          `id_picture` VARCHAR(255) PRIMARY KEY,
          `id_user` VARCHAR(255),
          `date` DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE TABLE `comment` (
          `id` VARCHAR(255) PRIMARY KEY,
          `id_picture` VARCHAR(255) NOT NULL,
          `id_user` VARCHAR(255) NOT NULL,
          `body` TEXT NOT NULL,
          `date` DATETIME DEFAULT CURRENT_TIMESTAMP
        );"
    );
}