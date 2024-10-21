CREATE DATABASE portal_cursos;

USE portal_cursos;

CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre_completo VARCHAR(255) NOT NULL,
    genero ENUM('M', 'F', 'Otro') NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    foto VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'instructor', 'estudiante') NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo', 'bloqueado') DEFAULT 'activo'
);
select*from usuarios;
CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    creador_id INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (creador_id) REFERENCES usuarios(id)
);

CREATE TABLE cursos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255),
    categoria_id INT,
    instructor_id INT,
    precio DECIMAL(10, 2) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    FOREIGN KEY (categoria_id) REFERENCES categorias(id),
    FOREIGN KEY (instructor_id) REFERENCES usuarios(id)
);

CREATE TABLE niveles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    curso_id INT,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT,
    video_url VARCHAR(255),
    FOREIGN KEY (curso_id) REFERENCES cursos(id)
);

CREATE TABLE inscripciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    curso_id INT,
    usuario_id INT,
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    progreso DECIMAL(5, 2) DEFAULT 0.00,
    fecha_completado TIMESTAMP NULL,
    FOREIGN KEY (curso_id) REFERENCES cursos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE comentarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    curso_id INT,
    usuario_id INT,
    comentario TEXT,
    calificacion INT CHECK (calificacion >= 1 AND calificacion <= 5),
    fecha_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (curso_id) REFERENCES cursos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE mensajes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    emisor_id INT,
    receptor_id INT,
    mensaje TEXT,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (emisor_id) REFERENCES usuarios(id),
    FOREIGN KEY (receptor_id) REFERENCES usuarios(id)
);

CREATE TABLE reportes_ventas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    curso_id INT,
    ingresos DECIMAL(10, 2),
    fecha_reporte TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (curso_id) REFERENCES cursos(id)
);
