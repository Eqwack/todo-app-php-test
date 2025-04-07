



CREATE DATABASE IF NOT EXISTS tache;
USE tache;



Create TABLE taches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    date_creation date,
    statut ENUM('à faire', 'fait') DEFAULT 'à faire'
);
