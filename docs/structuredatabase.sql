-- ============================================================
-- 1. Création de la Base de Données
-- ============================================================
CREATE DATABASE IF NOT EXISTS clinique_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE clinique_db;

-- ============================================================
-- 2. Table: specialities
-- ============================================================
CREATE TABLE specialities (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              name VARCHAR(255) NOT NULL,
                              description VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. Table: users (Admins, Médecins, Patients)
-- ============================================================
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       firstname VARCHAR(255) NOT NULL,
                       lastname VARCHAR(255) NOT NULL,
                       email VARCHAR(255) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL,
                       phone VARCHAR(255) NOT NULL,
                       role ENUM('admin', 'doctor', 'patient') NOT NULL,
                       id_speciality INT NULL,
                       CONSTRAINT fk_users_speciality
                           FOREIGN KEY (id_speciality) REFERENCES specialities(id)
                               ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. Table: timeslots (Les créneaux des médecins)
-- ============================================================
CREATE TABLE timeslots (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           start_time TIMESTAMP NOT NULL,
                           end_time TIMESTAMP NOT NULL,
                           is_available BOOLEAN NOT NULL DEFAULT TRUE,
                           id_doctor INT NOT NULL,
                           CONSTRAINT fk_timeslots_doctor
                               FOREIGN KEY (id_doctor) REFERENCES users(id)
                                   ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 5. Table: appointments (Réservations avec ENUM pour le Status)
-- ============================================================
CREATE TABLE appointments (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              id_patient INT NOT NULL,
                              id_doctor INT NOT NULL,
                              status ENUM('En attente', 'Confirmé', 'Annulé', 'Terminé') NOT NULL DEFAULT 'En attente',
                              id_timeslot INT NOT NULL,
                              CONSTRAINT fk_appointments_patient
                                  FOREIGN KEY (id_patient) REFERENCES users(id)
                                      ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT fk_appointments_doctor
                                  FOREIGN KEY (id_doctor) REFERENCES users(id)
                                      ON DELETE CASCADE ON UPDATE CASCADE,
                              CONSTRAINT fk_appointments_timeslot
                                  FOREIGN KEY (id_timeslot) REFERENCES timeslots(id)
                                      ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 6. Table: prescriptions (Les ordonnances)
-- ============================================================
CREATE TABLE prescriptions (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               description VARCHAR(255) NOT NULL,
                               id_appointment INT NOT NULL,
                               CONSTRAINT fk_prescriptions_appointment
                                   FOREIGN KEY (id_appointment) REFERENCES appointments(id)
                                       ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;