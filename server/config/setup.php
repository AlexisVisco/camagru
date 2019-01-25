<?php

// Le fichier db.sql est directement injecté lors du premier docker compose.
// De ce fait il n'y a pas besoin de setup le site.

/**
db:
    image: mysql:5.7
    ports:
    - "3306:3306"
    environment:
        MYSQL_DATABASE: camagru
        MYSQL_USER: user
        MYSQL_PASSWORD: test
        MYSQL_ROOT_PASSWORD: test
    volumes:
    - ./database:/docker-entrypoint-initdb.d <-- init the database
    - persistent:/var/lib/mysql
    networks:
    - default
 */
