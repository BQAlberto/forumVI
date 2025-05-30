
-- FORO VALUE INVESTING - SCRIPT COMPLETO
-- Incluye estructura, relaciones, datos de prueba y usuarios de MySQL
-- Compatible con PhpMyAdmin o consola MySQL

DROP DATABASE IF EXISTS aa2forum_value;
CREATE DATABASE aa2forum_value CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE aa2forum_value;


CREATE TABLE users (
  userID INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(150) NOT NULL,
  role VARCHAR(20) NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE topics (
  topicID INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);


CREATE TABLE threads (
  threadID INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  message VARCHAR(500) NOT NULL,
  userID INT NOT NULL,
  topicID INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE,
  FOREIGN KEY (topicID) REFERENCES topics(topicID) ON DELETE CASCADE
);


CREATE TABLE posts (
  postID INT AUTO_INCREMENT PRIMARY KEY,
  message VARCHAR(500) NOT NULL,
  userID INT NOT NULL,
  threadID INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE,
  FOREIGN KEY (threadID) REFERENCES threads(threadID) ON DELETE CASCADE
);


INSERT INTO topics (name) VALUES
('Análisis de empresas'),
('Ideas de inversión'),
('Buffett y Munger'),
('Lecturas recomendadas'),
('Macroeconomía y mercados');

INSERT INTO users (username, password, name, email, role) VALUES
('admin', 'admin1234', 'Admin Foro', 'admin@foro.com', 'admin'),
('valueuser1', 'clave1234', 'Usuario Uno', 'uno@foro.com', 'user'),
('valueuser2', 'clave1234', 'Usuario Dos', 'dos@foro.com', 'user');

-- Crear usuarios de base de datos (administrador y limitado)
-- (Solo ejecutar si se tiene permisos de administración)
--
-- CREATE USER 'admin_foro'@'localhost' IDENTIFIED BY 'admin1234';
-- GRANT ALL PRIVILEGES ON aa2forum.* TO 'admin_foro'@'localhost';
--
-- CREATE USER 'limitado_foro'@'localhost' IDENTIFIED BY 'limitado1234';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON aa2forum.posts TO 'limitado_foro'@'localhost';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON aa2forum.threads TO 'limitado_foro'@'localhost';
-- FLUSH PRIVILEGES;
