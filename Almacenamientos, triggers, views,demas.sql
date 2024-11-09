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
    WHERE id_curso = idCurso AND eliminado = 0;

    RETURN IFNULL(promedio, 0);
END //
DELIMITER ;


-- No Implementadas --
-- triggers
DELIMITER //
CREATE TRIGGER IncrementarIntentosFallidos
AFTER UPDATE ON Usuarios
FOR EACH ROW
BEGIN
    -- Solo incrementar si la contraseña fue incorrecta
    IF NEW.activo = TRUE AND NEW.intentos_fallidos < 3 THEN
        UPDATE Usuarios SET intentos_fallidos = intentos_fallidos + 1 WHERE idUsuario = NEW.idUsuario;
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER BloquearUsuarioDespuesDeTresIntentos
AFTER UPDATE ON Usuarios
FOR EACH ROW
BEGIN
    -- Si los intentos fallidos alcanzan 3, bloquear al usuario
    IF NEW.intentos_fallidos >= 3 THEN
        UPDATE Usuarios SET activo = FALSE WHERE idUsuario = NEW.idUsuario;
    END IF;
END //
DELIMITER ;

-- trigger reestablecer intentos fallidos luego de un inicio de sesion exitoso
DELIMITER //
CREATE TRIGGER RestablecerIntentosFallidos
AFTER UPDATE ON Usuarios
FOR EACH ROW
BEGIN
    -- Si el usuario se activa, restablecer los intentos fallidos a 0
    IF NEW.activo = TRUE AND OLD.activo = FALSE THEN
        UPDATE Usuarios SET intentos_fallidos = 0 WHERE idUsuario = NEW.idUsuario;
    END IF;
END //
DELIMITER ;

-- trigger para manejar inscripciones de cursos
DELIMITER //
CREATE TRIGGER RegistrarFechaUltimoAcceso
AFTER INSERT ON inscripciones
FOR EACH ROW
BEGIN
    -- Actualizar la fecha del último acceso a la fecha de inscripción
    UPDATE inscripciones
    SET fecha_ultimo_acceso = NOW()
    WHERE id_inscripcion = NEW.id_inscripcion;
END //

-- actualizacion de progreso
DELIMITER //
CREATE TRIGGER ActualizarEstadoKardex
AFTER UPDATE ON kardex
FOR EACH ROW
BEGIN
    -- Verificar si el progreso es mayor a 0 pero menor a 100, actualizar estado a 'en curso'
    IF NEW.progreso > 0 AND NEW.progreso < 100 THEN
        UPDATE kardex
        SET estado = 'en curso'
        WHERE id_kardex = NEW.id_kardex;
    END IF;

    -- Verificar si el progreso es igual a 100, actualizar estado a 'completado' y fecha_terminacion
    IF NEW.progreso = 100 THEN
        UPDATE kardex
        SET estado = 'completado',
            fecha_terminacion = NOW()
        WHERE id_kardex = NEW.id_kardex;
    END IF;
END;
//
DELIMITER ;

-- actualizar progreso curso
DELIMITER //

CREATE TRIGGER ActualizarProgreso
AFTER UPDATE ON Inscripciones
FOR EACH ROW
BEGIN
    -- Verificar si el progreso está entre 0 y 100, y actualizar la tabla kardex
    IF NEW.progreso >= 0 AND NEW.progreso <= 100 THEN
        UPDATE kardex
        SET progreso = NEW.progreso
        WHERE idUsuario = NEW.idUsuario AND id_curso = NEW.id_curso;
    END IF;
END //

DELIMITER ;




-- Views
-- cursos más vendidos
CREATE VIEW CursosMasVendidos AS
SELECT c.id_curso, c.titulo, COUNT(v.id_venta) AS total_ventas
FROM cursos c
JOIN ventas v ON c.id_curso = v.id_curso
GROUP BY c.id_curso, c.titulo
ORDER BY total_ventas DESC;

-- cursos recientes
CREATE VIEW CursosRecientes AS
SELECT c.id_curso, c.titulo, cat.fecha_creacion
FROM cursos c
JOIN categorias cat ON c.id_categoria = cat.id_categoria
ORDER BY cat.fecha_creacion DESC
LIMIT 10;

-- cursos mejor calificados
CREATE VIEW CursosMejorCalificados AS
SELECT c.id_curso, c.titulo, AVG(k.calificaciones) AS promedio_calificacion
FROM cursos c
JOIN kardex k ON c.id_curso = k.id_curso
GROUP BY c.id_curso, c.titulo
ORDER BY promedio_calificacion DESC;

-- vista de cursos activos
CREATE VIEW CursosActivos AS
SELECT id_curso, titulo, activo
FROM cursos
WHERE activo = TRUE;

-- vista de categorias activas
CREATE VIEW CategoriasActivas AS
SELECT DISTINCT cat.id_categoria, cat.nombre_categoria
FROM categorias cat
JOIN cursos c ON cat.id_categoria = c.id_categoria
WHERE c.activo = TRUE;

-- vista de instructores
CREATE VIEW Instructores AS
SELECT u.idUsuario, u.nombre, u.correo
FROM usuarios u
JOIN roles r ON u.id_rol = r.id_rol
WHERE r.rol_nombre = 'Instructor';

-- Vista de reporte de usuario estudiante
CREATE VIEW ReporteUsuarioEstudiante AS
SELECT 
    u.idUsuario,
    u.nombre AS nombre_estudiante,
    u.correo,
    k.id_curso,
    c.titulo AS titulo_curso,  -- Se trae el título del curso desde la tabla 'cursos'
    k.progreso,
    k.calificaciones,
    k.fecha_inscripcion,
    k.fecha_terminacion
FROM kardex k
JOIN usuarios u ON k.idUsuario = u.idUsuario
JOIN cursos c ON k.id_curso = c.id_curso
WHERE u.id_rol = 3; -- Asumiendo que el rol 3 es el de 'Estudiante'

-- Vista de reporte de usuario instructor
CREATE VIEW ReporteUsuarioInstructor AS
SELECT 
    u.idUsuario,
    u.nombre AS nombre_instructor,
    u.correo,
    COUNT(c.id_curso) AS cursos_creados  -- Cuenta la cantidad de cursos creados por cada instructor
FROM usuarios u
JOIN cursos c ON u.idUsuario = c.id_instructor  -- Relaciona la tabla usuarios con cursos a través del id_instructor
WHERE u.id_rol = 2  -- Asumiendo que el rol 2 es el de 'Instructor'
GROUP BY u.idUsuario, u.nombre, u.correo;


-- Funciones y procedimientos almacenados para filtros de búsqueda
-- Procedimiento para buscar cursos por título:
DELIMITER //
CREATE PROCEDURE BuscarCursosPorTitulo(IN p_titulo VARCHAR(255))
BEGIN
    SELECT id_curso, titulo, descripcion, costo
    FROM cursos
    WHERE titulo LIKE CONCAT('%', p_titulo, '%');
END //
DELIMITER ;

-- Procedimiento para buscar cursos por categoría:
DELIMITER //
CREATE PROCEDURE BuscarCursosPorCategoria(IN p_idCategoria INT)
BEGIN
    SELECT id_curso, titulo, descripcion, costo
    FROM cursos
    WHERE id_categoria = p_idCategoria;
END //
DELIMITER ;

-- Procedimiento para filtrar cursos por rango de precios
DELIMITER //
CREATE PROCEDURE BuscarCursosPorRangoPrecio(
    IN p_precio_min DECIMAL(10, 2),
    IN p_precio_max DECIMAL(10, 2)
)
BEGIN
    SELECT id_curso, titulo, descripcion, costo
    FROM cursos
    WHERE costo BETWEEN p_precio_min AND p_precio_max;
END //
DELIMITER ;


