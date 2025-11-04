-- Crear Base de Datos
CREATE DATABASE IF NOT EXISTS cursosOnline;
USE cursosOnline;

-- =============================
-- TABLA PRODUCTO
-- =============================
CREATE TABLE PRODUCTO (
    IDPRODUCTO INT PRIMARY KEY,
    DESCRIPCION VARCHAR(100) NOT NULL,
    DURACION_SEMANAS INT NOT NULL,
    ALUMNOS_TOTALES INT NOT NULL
);

-- Insertar datos en PRODUCTO (total 30 registros)
INSERT INTO PRODUCTO (IDPRODUCTO, DESCRIPCION, DURACION_SEMANAS, ALUMNOS_TOTALES) VALUES
(1, 'Curso SQL', 3, 5000),
(2, 'Curso Big Data', 10, 8000),
(3, 'Python Bootcamp', 4, 9000),
(4, 'Hadoop: Introducción', 2, 5500),
(5, 'SQL vs noSQL', 2, 6500),
(6, 'Machine Learning', 5, 7500),
(8, 'SEO', 8, 9000),
(7, 'DevOps Fundamentals', 6, 7000),
(9, 'Cloud Computing AWS', 7, 8500),
(10, 'Data Visualization', 4, 6000),
(11, 'Cybersecurity Basics', 5, 4500),
(12, 'Web Development Full Stack', 12, 12000),
(13, 'Blockchain Introduction', 3, 4000),
(14, 'AI Ethics', 2, 3000),
(15, 'React Native Mobile', 8, 9500),
(16, 'Docker and Kubernetes', 9, 8000),
(17, 'Data Engineering Pipeline', 11, 6500),
(18, 'NoSQL Databases', 4, 5500),
(19, 'Agile Methodology', 3, 5000),
(20, 'UI/UX Design Principles', 6, 7000),
(21, 'JavaScript Advanced', 5, 7500),
(22, 'Microservices Architecture', 7, 6000),
(23, 'Ethical Hacking', 10, 9000),
(24, 'Big Data Analytics', 8, 10000),
(25, 'Python for Finance', 4, 5500),
(26, 'Machine Learning Operations', 6, 8000),
(27, 'IoT Fundamentals', 5, 4000),
(28, 'Serverless Computing', 3, 3500),
(29, 'GraphQL API Development', 4, 6500),
(30, 'Sustainable Software Engineering', 9, 5000);

-- =============================
-- TABLA PEDIDO
-- =============================
CREATE TABLE PEDIDO (
    IDPEDIDO INT,
    FECHA VARCHAR(10) NOT NULL,
    IDPRODUCTO INT NOT NULL,
    PRIMARY KEY (IDPEDIDO, IDPRODUCTO), -- un pedido puede tener varios productos
    FOREIGN KEY (IDPRODUCTO) REFERENCES PRODUCTO(IDPRODUCTO)
);

-- Insertar datos en PEDIDO (total 30 registros)
INSERT INTO PEDIDO (IDPEDIDO, FECHA, IDPRODUCTO) VALUES
(301, '28/04', 1),
(301, '28/04', 4),
(301, '28/04', 5),
(302, '29/04', 6),
(302, '29/04', 2),
(303, '30/05', 3),
(304, '28/04', 4),
(305, '28/04', 5),
(306, '29/04', 6),
(308, '30/05', 3),
(307, '01/05', 2),
(307, '01/05', 7),
(309, '02/05', 9),
(309, '02/05', 10),
(310, '03/05', 11),
(311, '04/05', 12),
(311, '04/05', 13),
(312, '05/05', 14),
(313, '06/05', 15),
(313, '06/05', 16),
(314, '07/05', 17),
(315, '08/05', 18),
(315, '08/05', 19),
(316, '09/05', 20),
(317, '10/05', 21),
(317, '10/05', 22),
(318, '11/05', 23),
(319, '12/05', 24),
(319, '12/05', 25),
(320, '13/05', 26);