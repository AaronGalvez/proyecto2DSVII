CREATE DATABASE panama_turismo;
USE panama_turismo;

CREATE TABLE administradores (
                                 id_admin INT AUTO_INCREMENT PRIMARY KEY,
                                 usuario VARCHAR(50) NOT NULL UNIQUE,
                                 password VARCHAR(255) NOT NULL
);

CREATE TABLE paquetes (
                          id_paquete INT AUTO_INCREMENT PRIMARY KEY,
                          nombre VARCHAR(100) NOT NULL,
                          provincia VARCHAR(50) NOT NULL,
                          descripcion TEXT,
                          precio DECIMAL(10,2) NOT NULL,
                          dias INT NOT NULL,
                          transporte VARCHAR(50),
                          imagen VARCHAR(255)
);

CREATE TABLE reservas (

                          id_reserva INT AUTO_INCREMENT PRIMARY KEY,

                          id_paquete INT NOT NULL,

                          nombre_cliente VARCHAR(100) NOT NULL,
                          email VARCHAR(100) NOT NULL,
                          telefono VARCHAR(20),

                          fecha_reserva DATE NOT NULL,

                          personas INT NOT NULL,

                          total DECIMAL(10,2) NOT NULL,

                          notas TEXT,

                          fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,

                          FOREIGN KEY (id_paquete)
                              REFERENCES paquetes(id_paquete)
);

CREATE TABLE contactos (

                           id_contacto INT AUTO_INCREMENT PRIMARY KEY,

                           nombre VARCHAR(100) NOT NULL,
                           email VARCHAR(100) NOT NULL,

                           asunto VARCHAR(150) NOT NULL,

                           mensaje TEXT NOT NULL,

                           fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,

                           estado ENUM(
        'Pendiente',
        'Respondido'
    ) DEFAULT 'Pendiente'
);

CREATE TABLE respuestas_contacto (

                                     id_respuesta INT AUTO_INCREMENT PRIMARY KEY,

                                     id_contacto INT NOT NULL,

                                     respuesta TEXT NOT NULL,

                                     fecha_respuesta DATETIME DEFAULT CURRENT_TIMESTAMP,

                                     FOREIGN KEY(id_contacto)
                                         REFERENCES contactos(id_contacto)
);

INSERT INTO administradores
(usuario,password)
VALUES
    ('Kevin22','1GS134'),('Amy33','1GS134'),('Aaron44', '1GS134');