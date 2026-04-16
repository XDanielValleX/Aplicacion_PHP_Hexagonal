-- Base de datos y tablas para la Actividad 1

CREATE DATABASE IF NOT EXISTS actividad1
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE actividad1;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role_id INT NOT NULL DEFAULT 1,
  status ENUM('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS menu_restaurante (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_plato VARCHAR(120) NOT NULL,
  restaurante VARCHAR(120) NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  cantidad INT NOT NULL,
  duracion INT NOT NULL,
  descripcion TEXT NOT NULL,
  cliente VARCHAR(120) NOT NULL,
  mesero VARCHAR(120) NOT NULL,
  mesa VARCHAR(50) NOT NULL,
  comentarios TEXT NOT NULL,
  evaluacion TINYINT NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
