-- Crear Base de Datos
CREATE DATABASE IF NOT EXISTS cursosOnline;
USE cursosOnline;

-- =============================
-- TABLA CATEGORIA
-- =============================
CREATE TABLE CATEGORIA (
    IDCATEGORIA INT PRIMARY KEY,
    NOMBRE VARCHAR(50) NOT NULL
);

-- Insertar datos en CATEGORIA (total 10 registros, ya que son categorías limitadas)
INSERT INTO CATEGORIA (IDCATEGORIA, NOMBRE) VALUES
(1, 'Bases de Datos'),
(2, 'Big Data'),
(3, 'Programación'),
(4, 'DevOps'),
(5, 'Cloud Computing'),
(6, 'Seguridad'),
(7, 'Desarrollo Web'),
(8, 'Blockchain e IA'),
(9, 'Metodologías'),
(10, 'Diseño');

-- =============================
-- TABLA INSTRUCTOR
-- =============================
CREATE TABLE INSTRUCTOR (
    IDINSTRUCTOR INT PRIMARY KEY,
    NOMBRE VARCHAR(100) NOT NULL,
    EXPERIENCIA_ANOS INT NOT NULL
);

-- Insertar datos en INSTRUCTOR (total 30 registros)
INSERT INTO INSTRUCTOR (IDINSTRUCTOR, NOMBRE, EXPERIENCIA_ANOS) VALUES
(1, 'Juan Pérez', 10),
(2, 'María López', 8),
(3, 'Carlos García', 12),
(4, 'Ana Martínez', 6),
(5, 'Luis Rodríguez', 15),
(6, 'Sofía Hernández', 9),
(7, 'Miguel Sánchez', 11),
(8, 'Laura Torres', 7),
(9, 'Pedro Ramírez', 14),
(10, 'Elena Vargas', 5),
(11, 'Roberto Díaz', 13),
(12, 'Carmen Ruiz', 10),
(13, 'José Morales', 8),
(14, 'Isabel Castro', 12),
(15, 'Fernando Silva', 9),
(16, 'Patricia Navarro', 11),
(17, 'Antonio Ortega', 7),
(18, 'Raquel Jiménez', 15),
(19, 'Diego Soto', 6),
(20, 'Lucía Mendoza', 14),
(21, 'Javier Blanco', 10),
(22, 'Marta Alonso', 8),
(23, 'Sergio Guerrero', 12),
(24, 'Pilar Romero', 9),
(25, 'Óscar Vidal', 11),
(26, 'Noelia Cruz', 7),
(27, 'Rubén Molina', 13),
(28, 'Verónica Peña', 5),
(29, 'Ignacio Flores', 10),
(30, 'Adriana Vega', 16);

-- =============================
-- TABLA PRODUCTO
-- =============================
CREATE TABLE PRODUCTO (
    IDPRODUCTO INT PRIMARY KEY,
    DESCRIPCION VARCHAR(100) NOT NULL,
    DURACION_SEMANAS INT NOT NULL,
    ALUMNOS_TOTALES INT NOT NULL,
    IDCATEGORIA INT NOT NULL,
    IDINSTRUCTOR INT NOT NULL,
    FOREIGN KEY (IDCATEGORIA) REFERENCES CATEGORIA(IDCATEGORIA),
    FOREIGN KEY (IDINSTRUCTOR) REFERENCES INSTRUCTOR(IDINSTRUCTOR)
);

-- Insertar datos en PRODUCTO (total 30 registros)
INSERT INTO PRODUCTO (IDPRODUCTO, DESCRIPCION, DURACION_SEMANAS, ALUMNOS_TOTALES, IDCATEGORIA, IDINSTRUCTOR) VALUES
(1, 'Curso SQL', 3, 5000, 1, 1),
(2, 'Curso Big Data', 10, 8000, 2, 2),
(3, 'Python Bootcamp', 4, 9000, 3, 3),
(4, 'Hadoop: Introducción', 2, 5500, 2, 4),
(5, 'SQL vs noSQL', 2, 6500, 1, 5),
(6, 'Machine Learning', 5, 7500, 8, 6),
(8, 'SEO', 8, 9000, 7, 7),
(7, 'DevOps Fundamentals', 6, 7000, 4, 8),
(9, 'Cloud Computing AWS', 7, 8500, 5, 9),
(10, 'Data Visualization', 4, 6000, 2, 10),
(11, 'Cybersecurity Basics', 5, 4500, 6, 11),
(12, 'Web Development Full Stack', 12, 12000, 7, 12),
(13, 'Blockchain Introduction', 3, 4000, 8, 13),
(14, 'AI Ethics', 2, 3000, 8, 14),
(15, 'React Native Mobile', 8, 9500, 7, 15),
(16, 'Docker and Kubernetes', 9, 8000, 4, 16),
(17, 'Data Engineering Pipeline', 11, 6500, 2, 17),
(18, 'NoSQL Databases', 4, 5500, 1, 18),
(19, 'Agile Methodology', 3, 5000, 9, 19),
(20, 'UI/UX Design Principles', 6, 7000, 10, 20),
(21, 'JavaScript Advanced', 5, 7500, 3, 21),
(22, 'Microservices Architecture', 7, 6000, 4, 22),
(23, 'Ethical Hacking', 10, 9000, 6, 23),
(24, 'Big Data Analytics', 8, 10000, 2, 24),
(25, 'Python for Finance', 4, 5500, 3, 25),
(26, 'Machine Learning Operations', 6, 8000, 8, 26),
(27, 'IoT Fundamentals', 5, 4000, 8, 27),
(28, 'Serverless Computing', 3, 3500, 5, 28),
(29, 'GraphQL API Development', 4, 6500, 7, 29),
(30, 'Sustainable Software Engineering', 9, 5000, 9, 30);

-- =============================
-- TABLA ALUMNO
-- =============================
CREATE TABLE ALUMNO (
    IDALUMNO INT PRIMARY KEY,
    NOMBRE VARCHAR(100) NOT NULL,
    EMAIL VARCHAR(100) NOT NULL,
    FECHA_INSCRIPCION DATE NOT NULL
);

-- Insertar datos en ALUMNO (total 30 registros)
INSERT INTO ALUMNO (IDALUMNO, NOMBRE, EMAIL, FECHA_INSCRIPCION) VALUES
(101, 'Alberto Fernández', 'alberto@email.com', '2025-01-15'),
(102, 'Beatriz Gómez', 'beatriz@email.com', '2025-02-20'),
(103, 'Cristian Herrera', 'cristian@email.com', '2025-03-10'),
(104, 'Diana Ibáñez', 'diana@email.com', '2025-04-05'),
(105, 'Eduardo Jara', 'eduardo@email.com', '2025-01-25'),
(106, 'Fabiola Kwan', 'fabiola@email.com', '2025-02-15'),
(107, 'Gabriel López', 'gabriel@email.com', '2025-03-20'),
(108, 'Helena Mena', 'helena@email.com', '2025-04-12'),
(109, 'Iván Navarro', 'ivan@email.com', '2025-01-30'),
(110, 'Julia Ortega', 'julia@email.com', '2025-02-28'),
(111, 'Kevin Pérez', 'kevin@email.com', '2025-03-05'),
(112, 'Lorena Quiroz', 'lorena@email.com', '2025-04-18'),
(113, 'Manuel Reyes', 'manuel@email.com', '2025-01-20'),
(114, 'Natalia Soto', 'natalia@email.com', '2025-02-10'),
(115, 'Óscar Torres', 'oscar@email.com', '2025-03-15'),
(116, 'Paula Uribe', 'paula@email.com', '2025-04-01'),
(117, 'Quintín Vargas', 'quintin@email.com', '2025-01-10'),
(118, 'Raquel Winters', 'raquel@email.com', '2025-02-25'),
(119, 'Santiago Xavier', 'santiago@email.com', '2025-03-25'),
(120, 'Tamara Yanes', 'tamara@email.com', '2025-04-08'),
(121, 'Ursula Zamora', 'ursula@email.com', '2025-01-05'),
(122, 'Víctor Alonso', 'victor@email.com', '2025-02-05'),
(123, 'Wanda Bravo', 'wanda@email.com', '2025-03-30'),
(124, 'Xavier Castillo', 'xavier@email.com', '2025-04-20'),
(125, 'Yolanda Duarte', 'yolanda@email.com', '2025-01-12'),
(126, 'Zacarías Espino', 'zacarias@email.com', '2025-02-18'),
(127, 'Andrea Fuentes', 'andrea@email.com', '2025-03-12'),
(128, 'Bruno Gil', 'bruno@email.com', '2025-04-03'),
(129, 'Celia Hidalgo', 'celia@email.com', '2025-01-18'),
(130, 'David Ibarra', 'david@email.com', '2025-02-22');

-- =============================
-- TABLA PEDIDO
-- =============================
CREATE TABLE PEDIDO (
    IDPEDIDO INT,
    FECHA VARCHAR(10) NOT NULL,
    IDPRODUCTO INT NOT NULL,
    IDALUMNO INT NOT NULL,
    PRIMARY KEY (IDPEDIDO, IDPRODUCTO),
    FOREIGN KEY (IDPRODUCTO) REFERENCES PRODUCTO(IDPRODUCTO),
    FOREIGN KEY (IDALUMNO) REFERENCES ALUMNO(IDALUMNO)
);

-- Insertar datos en PEDIDO (total 30 registros)
INSERT INTO PEDIDO (IDPEDIDO, FECHA, IDPRODUCTO, IDALUMNO) VALUES
(301, '28/04', 1, 101),
(301, '28/04', 4, 101),
(301, '28/04', 5, 101),
(302, '29/04', 6, 102),
(302, '29/04', 2, 102),
(303, '30/05', 3, 103),
(304, '28/04', 4, 104),
(305, '28/04', 5, 105),
(306, '29/04', 6, 106),
(308, '30/05', 3, 107),
(307, '01/05', 2, 108),
(307, '01/05', 7, 108),
(309, '02/05', 9, 109),
(309, '02/05', 10, 109),
(310, '03/05', 11, 110),
(311, '04/05', 12, 111),
(311, '04/05', 13, 111),
(312, '05/05', 14, 112),
(313, '06/05', 15, 113),
(313, '06/05', 16, 113),
(314, '07/05', 17, 114),
(315, '08/05', 18, 115),
(315, '08/05', 19, 115),
(316, '09/05', 20, 116),
(317, '10/05', 21, 117),
(317, '10/05', 22, 117),
(318, '11/05', 23, 118),
(319, '12/05', 24, 119),
(319, '12/05', 25, 119),
(320, '13/05', 26, 120);