USE PWCI_Curso;
-- Procedimientos Almacenados --
-- IMPLEMENTADOS --

-- USUARIOS --
-- Procedimiento para bloquear usuario después de 3 intentos fallidos
DELIMITER //
CREATE PROCEDURE BloquearUsuario(IN user_id INT)
BEGIN
    UPDATE Usuarios SET activo = FALSE WHERE idUsuario = user_id;
END //
DELIMITER ;

-- Procedimiento para Cambiar Estado
DELIMITER //
CREATE PROCEDURE CambiarEstadoUsuario(
    IN p_idUsuario INT,
    IN p_nuevoEstado BOOLEAN
)
BEGIN
    UPDATE Usuarios
    SET activo = p_nuevoEstado
    WHERE idUsuario = p_idUsuario;
END //
DELIMITER ;


-- CATEGORIAS --
-- Registro de Categoría
DELIMITER //
CREATE PROCEDURE RegistrarCategoria(
    IN nombre_categoria VARCHAR(255),
    IN descripcion TEXT,
    IN id_creador INT
)
BEGIN
    INSERT INTO Categorias (nombre_categoria, descripcion, id_creador)
    VALUES (nombre_categoria, descripcion, id_creador);
END //
DELIMITER ;


-- CURSOS --
-- Procedimiento para publicar un curso
DELIMITER //
CREATE PROCEDURE InsertarCurso(
    IN p_titulo VARCHAR(255),
    IN p_descripcion TEXT,
    IN p_imagen BLOB,
    IN p_costo DECIMAL(10, 2),
    IN p_niveles INT,
    IN p_id_instructor INT,
    IN p_id_categoria INT,
    OUT p_id_curso INT
)
BEGIN
    -- Insertar el curso en la tabla Cursos
    INSERT INTO Cursos (titulo, descripcion, imagen, costo, niveles, id_instructor, id_categoria)
    VALUES (p_titulo, p_descripcion, p_imagen, p_costo, p_niveles, p_id_instructor, p_id_categoria);

    -- Obtener el id del curso recién insertado y asignarlo a la variable de salida
    SET p_id_curso = LAST_INSERT_ID();
END //
DELIMITER ;


-- NIVELES --
DELIMITER //
CREATE PROCEDURE InsertarNivel(
    IN p_id_curso INT,
    IN p_numero_nivel INT,
    IN p_titulo_nivel VARCHAR(255),
    IN p_video LONGBLOB,
    IN p_contenido TEXT,
    IN p_archivos LONGBLOB,
    IN p_costo DECIMAL(10, 2)
)
BEGIN
    -- Insertar el nivel en la tabla Niveles
    INSERT INTO Niveles (id_curso, numero_nivel, titulo_nivel, video, contenido, archivos, costo)
    VALUES (p_id_curso, p_numero_nivel, p_titulo_nivel, p_video, p_contenido, p_archivos, p_costo);
END //
DELIMITER ;


-- INSCRIPCIONES --
DELIMITER //
CREATE PROCEDURE RegistrarInscripcion(
    IN p_id_curso INT,
    IN p_id_usuario INT
)
BEGIN
    INSERT INTO Inscripciones (id_curso, id_usuario, fecha_inscripcion, fecha_ultimo_acceso, progreso, estado)
    VALUES (p_id_curso, p_id_usuario, NOW(), NOW(), 0, 'en curso');
END //
DELIMITER ;


-- Funcion1 ---
DELIMITER //
CREATE FUNCTION obtenerPromedioCurso(idCurso INT)
RETURNS DECIMAL(3, 2)
DETERMINISTIC
BEGIN
    DECLARE promedio DECIMAL(3, 2);

    SELECT AVG(calificacion)
    INTO promedio
    FROM Comentarios
    WHERE id_curso = idCurso;

    RETURN IFNULL(promedio, 0);
END //
DELIMITER ;




-- VIEWS --
-- Cursos más vendidos ---
CREATE OR REPLACE VIEW CursosMasVendidos AS
SELECT c.id_curso, c.titulo, c.imagen, c.descripcion, c.costo, cat.nombre_categoria, COUNT(v.id_venta) AS total_ventas
FROM cursos c
JOIN ventas v ON c.id_curso = v.id_curso
JOIN categorias cat ON c.id_categoria = cat.id_categoria
WHERE c.activo = TRUE
GROUP BY c.id_curso, c.titulo, c.imagen, c.descripcion, c.costo, cat.nombre_categoria
ORDER BY total_ventas DESC;

-- Cursos recientes ---
CREATE OR REPLACE VIEW CursosRecientes AS
SELECT c.id_curso, c.titulo, c.imagen, c.descripcion, c.costo, cat.nombre_categoria, cat.fecha_creacion
FROM cursos c
JOIN categorias cat ON c.id_categoria = cat.id_categoria
WHERE c.activo = TRUE
ORDER BY cat.fecha_creacion DESC
LIMIT 10;

-- Cursos mejor calificados ---
CREATE OR REPLACE VIEW CursosMejorCalificados AS
SELECT c.id_curso, c.titulo, c.imagen, c.descripcion, c.costo, cat.nombre_categoria, c.calificacion_promedio
FROM cursos c
JOIN categorias cat ON c.id_categoria = cat.id_categoria
WHERE c.activo = TRUE
ORDER BY c.calificacion_promedio DESC;



-- Vista de cursos activos
CREATE OR REPLACE VIEW CursosActivos AS
SELECT 
    c.id_curso,
    c.titulo,
    c.descripcion,
    c.imagen,
    c.costo,
    c.niveles,
    c.calificacion_promedio,
    c.id_instructor,
    c.id_categoria,
    c.fecha_creacion,
    i.nombre AS nombre_instructor,
    cat.nombre_categoria
FROM cursos c
JOIN usuarios i ON c.id_instructor = i.idUsuario
JOIN categorias cat ON c.id_categoria = cat.id_categoria
WHERE c.activo = TRUE;


-- Vista instructores --
CREATE OR REPLACE VIEW InstructoresActivos AS
SELECT 
    idUsuario,
    nombre,
    foto_avatar,
    correo
FROM 
    Usuarios
WHERE 
    id_rol = 2
    AND activo = TRUE;



-- Categorias activas
-- Con Cursos activos
CREATE VIEW CategoriasActivas AS
SELECT DISTINCT cat.id_categoria, cat.nombre_categoria
FROM categorias cat
JOIN cursos c ON cat.id_categoria = c.id_categoria
WHERE c.activo = TRUE;

-- No cursos Activos--
CREATE OR REPLACE VIEW CategoriasActivas AS
SELECT id_categoria, nombre_categoria
FROM Categorias
WHERE activo = TRUE;


-- Reportes
CREATE VIEW ReporteInstructores AS
SELECT 
    u.idUsuario AS id_instructor,
    u.nombre AS nombre_instructor,
    u.fecha_registro AS fecha_ingreso,
    COUNT(c.id_curso) AS cantidad_cursos_ofrecidos,
    IFNULL(SUM(v.precio_pagado), 0) AS total_ganancias
FROM 
    Usuarios u
LEFT JOIN 
    Cursos c ON u.idUsuario = c.id_instructor
LEFT JOIN 
    Ventas v ON c.id_curso = v.id_curso
WHERE 
    u.id_rol = (SELECT id_rol FROM Roles WHERE rol_nombre = 'Instructor')
GROUP BY 
    u.idUsuario, u.nombre, u.fecha_registro;
    

CREATE VIEW ReporteEstudiantes AS
SELECT 
    u.idUsuario AS id_estudiante,
    u.nombre AS nombre_estudiante,
    u.fecha_registro AS fecha_ingreso,
    COUNT(i.id_inscripcion) AS cantidad_cursos_inscritos,
    CONCAT(
        ROUND(
            (SUM(CASE WHEN i.completado = TRUE THEN 1 ELSE 0 END) / COUNT(i.id_inscripcion)) * 100, 
            2
        ), 
        '%'
    ) AS porcentaje_cursos_terminados
FROM 
    Usuarios u
LEFT JOIN 
    Inscripciones i ON u.idUsuario = i.id_usuario
WHERE 
    u.id_rol = (SELECT id_rol FROM Roles WHERE rol_nombre = 'Estudiante')
GROUP BY 
    u.idUsuario, u.nombre, u.fecha_registro;


CREATE VIEW TotalIngresosPorPago AS
SELECT forma_pago, SUM(precio_pagado) AS total_ingresos
FROM Ventas
GROUP BY forma_pago;







-- BUSQUEDAS --
DELIMITER //
CREATE PROCEDURE BuscarCursosPorPalabraClave(IN palabraClave VARCHAR(255))
BEGIN
    SELECT c.id_curso, c.titulo, c.descripcion, c.imagen, c.costo, c.niveles, c.calificacion_promedio, 
           cat.nombre_categoria, u.nombre AS nombre_instructor
    FROM cursos c
    JOIN categorias cat ON c.id_categoria = cat.id_categoria
    JOIN usuarios u ON c.id_instructor = u.idUsuario
    WHERE c.activo = TRUE
      AND (c.titulo LIKE CONCAT('%', palabraClave, '%') 
           OR c.descripcion LIKE CONCAT('%', palabraClave, '%'));
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE BuscarCursosDinamico(
    IN in_categoriaID INT,
    IN in_instructorID INT,
    IN in_fechaInicio DATE,
    IN in_fechaFin DATE
)
BEGIN
    SELECT * FROM CursosActivos
    WHERE (in_categoriaID IS NULL OR id_categoria = in_categoriaID)
      AND (in_instructorID IS NULL OR id_instructor = in_instructorID)
      AND (in_fechaInicio IS NULL OR fecha_creacion >= in_fechaInicio)
      AND (in_fechaFin IS NULL OR fecha_creacion <= in_fechaFin);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE BuscarKardexDinamico(
    IN in_categoriaID INT,
    IN in_estado VARCHAR(20),
    IN in_fechaInicio DATE,
    IN in_fechaFin DATE,
    IN in_usuarioID INT
)
BEGIN
    SELECT 
        i.id_inscripcion,
        i.id_curso,  -- Asegúrate de seleccionar id_curso aquí
        c.titulo AS titulo,
        i.fecha_inscripcion,
        i.fecha_ultimo_acceso,
        i.progreso,
        i.fecha_terminacion,
        cat.nombre_categoria AS categoria,
        i.estado
    FROM Inscripciones i
    JOIN Cursos c ON i.id_curso = c.id_curso
    JOIN Categorias cat ON c.id_categoria = cat.id_categoria
    WHERE i.id_usuario = in_usuarioID
      AND (in_categoriaID IS NULL OR c.id_categoria = in_categoriaID)
      AND (in_estado IS NULL OR i.estado = in_estado)
      AND (in_fechaInicio IS NULL OR i.fecha_inscripcion >= in_fechaInicio)
      AND (in_fechaFin IS NULL OR i.fecha_inscripcion <= in_fechaFin);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE BuscarVentasDinamico(
    IN in_categoriaID INT,
    IN in_estado VARCHAR(20),
    IN in_fechaInicio DATE,
    IN in_fechaFin DATE,
    IN in_usuarioID INT
)
BEGIN
    SELECT 
        c.id_curso,
        c.titulo AS titulo,
        c.activo,
        COUNT(i.id_usuario) AS alumnos_inscritos,
        AVG(i.progreso) AS nivel_promedio,
        SUM(v.precio_pagado) AS ingresos_totales,
        cat.nombre_categoria AS categoria
    FROM Cursos c
    LEFT JOIN Inscripciones i ON c.id_curso = i.id_curso
    LEFT JOIN Ventas v ON c.id_curso = v.id_curso
    LEFT JOIN Categorias cat ON c.id_categoria = cat.id_categoria
    WHERE c.id_instructor = in_usuarioID
      AND (in_categoriaID IS NULL OR c.id_categoria = in_categoriaID)
      AND (in_estado IS NULL 
           OR (in_estado = 'activo' AND c.activo = 1)
           OR (in_estado = 'inactivo' AND c.activo = 0))
      AND (in_fechaInicio IS NULL OR v.fecha_venta >= in_fechaInicio)
      AND (in_fechaFin IS NULL OR v.fecha_venta <= in_fechaFin)
    GROUP BY c.id_curso;
END //
DELIMITER ;



CALL BuscarVentasDinamico(NULL, 1, NULL, NULL, 23);



-- TRIGGERS --

DELIMITER //
CREATE TRIGGER reset_intentos_fallidos
AFTER UPDATE ON Usuarios
FOR EACH ROW
BEGIN
    -- Solo agrega el idUsuario a la tabla temporal si el usuario ha sido activado
    IF NEW.activo = TRUE AND OLD.activo = FALSE THEN
        INSERT INTO TempUsuariosActivados (idUsuario) VALUES (NEW.idUsuario);
    END IF;
END//
DELIMITER ;


DELIMITER $$
CREATE TRIGGER trg_update_estado_completado
BEFORE UPDATE ON Inscripciones
FOR EACH ROW
BEGIN
    -- Verificar si el progreso es igual o superior a 100%
    IF NEW.progreso >= 100 THEN
        -- Actualizar el estado a 'completado' y establecer completado a TRUE
        SET NEW.estado = 'completado';
        SET NEW.completado = TRUE;
        SET NEW.fecha_terminacion = NOW();
    END IF;
END$$
DELIMITER ;




DROP TRIGGER IF EXISTS reset_intentos_fallidos;



