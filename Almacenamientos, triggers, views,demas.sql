USE PWCI_Curso;
-- ---------------- PROCEDIMIENTOS AMACENADOS -------------------------


-- ------USUARIOS --------
DELIMITER //
CREATE PROCEDURE BloquearUsuario(IN user_id INT)
BEGIN
    UPDATE Usuarios SET activo = FALSE WHERE idUsuario = user_id;
END //
DELIMITER ;

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

DELIMITER //
CREATE PROCEDURE ObtenerUsuarios()
BEGIN
    SELECT idUsuario, nombre, correo, fecha_registro, activo, id_rol
    FROM Usuarios;
END //
DELIMITER ;

-- ------CATEGORIAS ----------

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

DELIMITER //
CREATE PROCEDURE ObtenerCategorias(IN p_id_creador INT)
BEGIN
    SELECT id_categoria, nombre_categoria, descripcion, activo
    FROM Categorias
    WHERE id_creador = p_id_creador;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GetAllCategorias()
BEGIN
    SELECT id_categoria, nombre_categoria
    FROM Categorias;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ActualizarCategoria(
    IN p_id_categoria INT,
    IN p_nombre_categoria VARCHAR(255),
    IN p_descripcion TEXT
)
BEGIN
    UPDATE Categorias
    SET nombre_categoria = p_nombre_categoria, descripcion = p_descripcion
    WHERE id_categoria = p_id_categoria;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE CambiarEstadoCategoria(
    IN p_id_categoria INT,
    IN p_nuevoEstado BOOLEAN
)
BEGIN
    UPDATE Categorias
    SET activo = p_nuevoEstado
    WHERE id_categoria = p_id_categoria;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerCategoriasActivas()
BEGIN
    SELECT id_categoria, nombre_categoria FROM Categorias WHERE activo = TRUE;
END //
DELIMITER ;






-- --------CURSOS ---------

DELIMITER //
CREATE PROCEDURE InsertarCurso(
    IN p_titulo VARCHAR(255),
    IN p_descripcion TEXT,
    IN p_imagen MEDIUMBLOB,
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

DELIMITER $$
CREATE PROCEDURE ActualizarCurso(
    IN p_id_curso INT,
    IN p_titulo VARCHAR(255),
    IN p_descripcion TEXT,
    IN p_imagen BLOB,
    IN p_costo DECIMAL(10, 2),
    IN p_id_categoria INT
)
BEGIN
    UPDATE Cursos
    SET
        titulo = p_titulo,
        descripcion = p_descripcion,
        imagen = IF(p_imagen IS NOT NULL, p_imagen, imagen), -- Solo actualiza la imagen si no es NULL
        costo = p_costo,
        id_categoria = p_id_categoria
    WHERE id_curso = p_id_curso;
END$$
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerCursos()
BEGIN
    SELECT cursos.id_curso, cursos.titulo, cursos.descripcion, cursos.activo, usuarios.nombre AS instructor_nombre
    FROM cursos
    JOIN usuarios ON cursos.id_instructor = usuarios.idUsuario;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ActualizarEstadoCurso(
    IN p_idCurso INT,
    IN p_nuevoEstado INT
)
BEGIN
    UPDATE cursos
    SET activo = p_nuevoEstado
    WHERE id_curso = p_idCurso;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerCursoPorId(
    IN p_idCurso INT
)
BEGIN
    SELECT 
        Cursos.*, 
        Usuarios.nombre AS nombre_creador, 
        Categorias.nombre_categoria AS nombre_categoria 
    FROM Cursos
    JOIN Usuarios ON Cursos.id_instructor = Usuarios.idUsuario
    JOIN Categorias ON Cursos.id_categoria = Categorias.id_categoria
    WHERE Cursos.id_curso = p_idCurso;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerCursosInscritosPorUsuario(
    IN p_idUsuario INT
)
BEGIN
    SELECT i.*, c.titulo AS curso_titulo, cat.nombre_categoria AS categoria
    FROM Inscripciones i
    JOIN Cursos c ON i.id_curso = c.id_curso
    JOIN Categorias cat ON c.id_categoria = cat.id_categoria
    WHERE i.id_usuario = p_idUsuario;
END //
DELIMITER ;


-- --------NIVELES ----------
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

DELIMITER $$
CREATE PROCEDURE ActualizarNivel(
    IN p_id_nivel INT,          
    IN p_titulo_nivel VARCHAR(255), 
    IN p_contenido TEXT,       
    IN p_costo DECIMAL(10, 2)  
)
BEGIN
    IF EXISTS (
        SELECT 1
        FROM Niveles
        WHERE id_nivel = p_id_nivel
    ) THEN
        UPDATE Niveles
        SET 
            titulo_nivel = p_titulo_nivel,
            contenido = p_contenido,
            costo = p_costo
        WHERE id_nivel = p_id_nivel;
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El nivel especificado no existe.';
    END IF;
END$$
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerNivelesPorCurso(
    IN p_idCurso INT
)
BEGIN
    SELECT * 
    FROM Niveles 
    WHERE id_curso = p_idCurso 
    ORDER BY numero_nivel;
END //
DELIMITER ;



-- -------COMENTARIOS ---------
DELIMITER //
CREATE PROCEDURE ObtenerComentario(
    IN p_id_curso INT,
    IN p_id_usuario INT
)
BEGIN
    SELECT comentario, calificacion, fecha_comentario
    FROM Comentarios
    WHERE id_curso = p_id_curso AND id_usuario = p_id_usuario AND eliminado = 0;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GuardarComentario(
    IN p_id_curso INT,
    IN p_id_usuario INT,
    IN p_comentario TEXT,
    IN p_calificacion INT
)
BEGIN
    INSERT INTO Comentarios (id_curso, id_usuario, comentario, calificacion)
    VALUES (p_id_curso, p_id_usuario, p_comentario, p_calificacion);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerComentariosPorCurso(
    IN p_idCurso INT
)
BEGIN
    SELECT c.id_comentario, c.comentario, c.calificacion, c.fecha_comentario, c.id_usuario, c.eliminado,
           u.nombre AS nombre_usuario, u.foto_avatar 
    FROM Comentarios AS c
    JOIN Usuarios AS u ON c.id_usuario = u.idUsuario
    WHERE c.id_curso = p_idCurso
    ORDER BY c.fecha_comentario DESC;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE EliminarComentarioPorId(
    IN p_idComentario INT,
    IN p_motivoEliminacion VARCHAR(255)
)
BEGIN
    UPDATE Comentarios
    SET eliminado = TRUE, motivo_eliminacion = p_motivoEliminacion
    WHERE id_comentario = p_idComentario;
END //
DELIMITER ;


-- -------INSCRIPCIONES ---------
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

DELIMITER //
CREATE PROCEDURE VerificarCompraCursoPorUsuario(
    IN p_idCurso INT,
    IN p_idUsuario INT,
    OUT p_resultado INT
)
BEGIN
    SELECT COUNT(*)
    INTO p_resultado
    FROM Inscripciones
    WHERE id_curso = p_idCurso AND id_usuario = p_idUsuario;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ActualizarProgresoCurso(
    IN p_idCurso INT,
    IN p_idUsuario INT,
    IN p_nuevoProgreso DECIMAL(5,2)
)
BEGIN
    UPDATE Inscripciones
    SET progreso = p_nuevoProgreso, fecha_ultimo_acceso = NOW()
    WHERE id_curso = p_idCurso AND id_usuario = p_idUsuario;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerProgresoPorCursoYUsuario(
    IN p_idCurso INT,
    IN p_idUsuario INT,
    OUT p_progreso DECIMAL(5,2)
)
BEGIN
    SELECT progreso
    INTO p_progreso
    FROM Inscripciones
    WHERE id_curso = p_idCurso AND id_usuario = p_idUsuario;
    
    IF p_progreso IS NULL THEN
        SET p_progreso = 0;
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE VerificarInscripcion(
    IN p_idCurso INT,
    IN p_idUsuario INT,
    OUT p_existe INT
)
BEGIN
    SELECT COUNT(*) INTO p_existe
    FROM Inscripciones
    WHERE id_curso = p_idCurso AND id_usuario = p_idUsuario;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerDatosCertificado(
    IN p_idCurso INT,
    IN p_idUsuario INT
)
BEGIN
    SELECT 
        u.nombre AS nombre_estudiante,
        c.titulo AS nombre_curso,
        i.fecha_terminacion,
        instructor.nombre AS nombre_instructor
    FROM Inscripciones i
    JOIN Usuarios u ON i.id_usuario = u.idUsuario
    JOIN Cursos c ON i.id_curso = c.id_curso
    JOIN Usuarios instructor ON c.id_instructor = instructor.idUsuario
    WHERE i.id_curso = p_idCurso 
    AND i.id_usuario = p_idUsuario 
    AND i.completado = 1;
END //
DELIMITER ;





-- -------VENTAS ---------
DELIMITER //
CREATE PROCEDURE RegistrarVentaCurso(
    IN p_idCurso INT,
    IN p_idUsuario INT,
    IN p_precioPagado DECIMAL(10,2),
    IN p_formaPago VARCHAR(255)
)
BEGIN
    INSERT INTO Ventas (id_curso, id_usuario, precio_pagado, forma_pago)
    VALUES (p_idCurso, p_idUsuario, p_precioPagado, p_formaPago);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GetCursosVentas(IN userId INT)
BEGIN
    SELECT c.id_curso, c.titulo, c.activo,
           COUNT(i.id_usuario) AS alumnos_inscritos, 
           AVG(i.progreso) AS nivel_promedio, 
           SUM(v.precio_pagado) AS ingresos_totales
    FROM Cursos c
    LEFT JOIN Inscripciones i ON c.id_curso = i.id_curso
    LEFT JOIN Ventas v ON c.id_curso = v.id_curso
    WHERE c.id_instructor = userId
    GROUP BY c.id_curso;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GetTotalesPorPago(IN userId INT)
BEGIN
    SELECT v.forma_pago, SUM(v.precio_pagado) AS total_ingresos
    FROM Ventas v
    JOIN Cursos c ON v.id_curso = c.id_curso
    WHERE c.id_instructor = userId
    GROUP BY v.forma_pago;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GetDetallesCurso(IN idCurso INT)
BEGIN
    SELECT u.nombre AS alumno, 
           i.fecha_inscripcion, 
           i.progreso, 
           v.precio_pagado, 
           v.forma_pago, 
           c.titulo AS titulo
    FROM Inscripciones i
    JOIN Usuarios u ON i.id_usuario = u.idUsuario
    JOIN Ventas v ON i.id_curso = v.id_curso AND i.id_usuario = v.id_usuario
    JOIN Cursos c ON i.id_curso = c.id_curso
    WHERE i.id_curso = idCurso;
END//
DELIMITER ;

-- -------MENSAJES ---------
DELIMITER //
CREATE PROCEDURE ObtenerInstructoresConMensajes(IN id_emisor INT)
BEGIN
    SELECT DISTINCT u.idUsuario, u.nombre, u.foto_avatar
    FROM Usuarios u
    JOIN Mensajes m 
        ON (u.idUsuario = m.id_receptor AND m.id_emisor = id_emisor)
        OR (u.idUsuario = m.id_emisor AND m.id_receptor = id_emisor);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerMensajesEntreUsuarios(IN id_emisor INT, IN id_receptor INT)
BEGIN
    SELECT m.*, u.foto_avatar, u.nombre
    FROM Mensajes m
    JOIN Usuarios u ON u.idUsuario = m.id_emisor
    WHERE (m.id_emisor = id_emisor AND m.id_receptor = id_receptor) 
       OR (m.id_emisor = id_receptor AND m.id_receptor = id_emisor)
    ORDER BY m.fecha_hora ASC;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE IniciarChatSiNoExiste(IN id_emisor INT, IN id_receptor INT)
BEGIN
    -- Verifica si ya existe un chat entre los usuarios
    IF NOT EXISTS (
        SELECT 1 
        FROM Mensajes 
        WHERE (id_emisor = id_emisor AND id_receptor = id_receptor)
           OR (id_emisor = id_receptor AND id_receptor = id_emisor)
    ) THEN
        -- Si no existe, inserta un mensaje de bienvenida
        INSERT INTO Mensajes (id_emisor, id_receptor, mensaje) 
        VALUES (id_emisor, id_receptor, 'Hola, este es el inicio de nuestra conversación');
    END IF;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE EnviarMensaje(IN id_emisor INT, IN id_receptor INT, IN mensaje TEXT)
BEGIN
    INSERT INTO Mensajes (id_emisor, id_receptor, mensaje) 
    VALUES (id_emisor, id_receptor, mensaje);
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
    -- Solo agrega el idUsuario a la tabla temporal si el usuario ha sido activado y no está en la tabla ya
    IF NEW.activo = TRUE AND OLD.activo = FALSE THEN
        -- Verificar si el idUsuario ya existe en la tabla temporal
        IF NOT EXISTS (SELECT 1 FROM TempUsuariosActivados WHERE idUsuario = NEW.idUsuario) THEN
            INSERT INTO TempUsuariosActivados (idUsuario) VALUES (NEW.idUsuario);
        END IF;
    END IF;
END //
DELIMITER ;

DROP TRIGGER IF EXISTS reset_intentos_fallidos;

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



