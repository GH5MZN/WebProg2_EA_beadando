-- F1 Tech Solutions MySQL adatbázis létrehozása
-- Futtasd le ezt a scriptet phpMyAdmin-ben vagy MySQL Workbench-ben

CREATE DATABASE IF NOT EXISTS f1_tech_solutions 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE f1_tech_solutions;

-- Ellenőrzés
SHOW DATABASES;