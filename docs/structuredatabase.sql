CREATE DATABASE clinique_db;
USE clinique_db;

-- =========================
-- Table: users
-- =========================
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       firstname VARCHAR(100) NOT NULL,
                       lastname VARCHAR(100) NOT NULL,
                       email VARCHAR(150) UNIQUE NOT NULL,
                       password VARCHAR(255) NOT NULL,
                       phone VARCHAR(20),
                       role ENUM('admin', 'doctor', 'patient') NOT NULL
);

-- =========================
-- Table: specialities
-- =========================
CREATE TABLE specialities (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              name VARCHAR(100) NOT NULL,
                              description VARCHAR(255)
);

-- =========================
-- Table: doctors
-- =========================
CREATE TABLE doctors (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         id_user INT NOT NULL,
                         id_speciality INT NOT NULL,
                         is_active BOOLEAN DEFAULT TRUE,

                         CONSTRAINT fk_doctor_user
                             FOREIGN KEY (id_user)
                                 REFERENCES users(id)
                                 ON DELETE CASCADE,

                         CONSTRAINT fk_doctor_speciality
                             FOREIGN KEY (id_speciality)
                                 REFERENCES specialities(id)
                                 ON DELETE RESTRICT
);

-- =========================
-- Table: timeslots
-- =========================
CREATE TABLE timeslots (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           start_time TIMESTAMP NOT NULL,
                           end_time TIMESTAMP NOT NULL,
                           is_available BOOLEAN DEFAULT TRUE,
                           id_doctor INT NOT NULL,

                           CONSTRAINT fk_timeslot_doctor
                               FOREIGN KEY (id_doctor)
                                   REFERENCES doctors(id)
                                   ON DELETE CASCADE
);

-- =========================
-- Table: appointments
-- =========================
CREATE TABLE appointments (
                              id INT AUTO_INCREMENT PRIMARY KEY,

                              id_patient INT NOT NULL,
                              id_doctor INT NOT NULL,

                              status ENUM(
        'En attente',
        'Confirmé',
        'Annulé',
        'Terminé'
    ) NOT NULL DEFAULT 'En attente',

                              id_timeslot INT NOT NULL,

                              CONSTRAINT fk_appointment_patient
                                  FOREIGN KEY (id_patient)
                                      REFERENCES users(id)
                                      ON DELETE CASCADE,

                              CONSTRAINT fk_appointment_doctor
                                  FOREIGN KEY (id_doctor)
                                      REFERENCES doctors(id)
                                      ON DELETE CASCADE,

                              CONSTRAINT fk_appointment_timeslot
                                  FOREIGN KEY (id_timeslot)
                                      REFERENCES timeslots(id)
                                      ON DELETE CASCADE
);

-- =========================
-- Table: prescriptions
-- =========================
CREATE TABLE prescriptions (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               description VARCHAR(255) NOT NULL,
                               id_appointment INT NOT NULL UNIQUE,

                               CONSTRAINT fk_prescription_appointment
                                   FOREIGN KEY (id_appointment)
                                       REFERENCES appointments(id)
                                       ON DELETE CASCADE
);