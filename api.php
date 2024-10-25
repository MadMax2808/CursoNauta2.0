<?php

include 'Models\Database.php';

$database = new Database();
$conn = $database->getConnection();

$response = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['idUsuario'])) {
            $idUsuario = $_GET['idUsuario'];
            $query = "SELECT * FROM usuarios WHERE idUsuario = :idUsuario";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM usuarios";
            $stmt = $conn->query($query);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        break;

    case 'POST':
        if (isset($_POST['accion']) && $_POST['accion'] === 'registro') {
            // Validar los datos del usuario
            if (!empty($_POST['full_name']) && !empty($_POST['correo']) && !empty($_POST['contrasena']) && !empty($_POST['role']) && !empty($_POST['gender']) && !empty($_POST['birthdate'])) {
                $nombre = $_POST['full_name'];
                $correo = $_POST['correo'];
                $password = $_POST['contrasena'];
                $genero = $_POST['gender'];
                $fecha_nacimiento = $_POST['birthdate'];
                $id_rol = ($_POST['role'] === 'instructor') ? 2 : 3;  // Asignar rol (Instructor = 2, Estudiante = 3)
        
                // Manejar la foto (subirla)
                if (!empty($_FILES['photo']['full_name'])) {
                    $foto_avatar = 'uploads/' . basename($_FILES['photo']['full_name']);
                    move_uploaded_file($_FILES['photo']['tmp_name'], $foto_avatar);
                } else {
                    $foto_avatar = null;  // En caso de que no suban una foto
                }
        
                // Verificar si el correo ya existe
                $query = "SELECT idUsuario FROM usuarios WHERE correo = :correo";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':correo', $correo);
                $stmt->execute();
        
                if ($stmt->rowCount() > 0) {
                    $response['error'] = "El correo ya está registrado. Por favor, usa otro.";
                } else {
                    // Insertar el nuevo usuario con los nuevos campos, sin incluir fecha_registro (se maneja automáticamente)
                    $query = "INSERT INTO usuarios (nombre, genero, fecha_nacimiento, foto_avatar, correo, contrasena, id_rol) 
                              VALUES (:nombre, :genero, :fecha_nacimiento, :foto_avatar, :correo, :contrasena, :id_rol)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':genero', $genero);
                    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
                    $stmt->bindParam(':foto_avatar', $foto_avatar);
                    $stmt->bindParam(':correo', $correo);
                    $stmt->bindParam(':contrasena', $password);  // Guardar la contraseña en texto plano
                    $stmt->bindParam(':id_rol', $id_rol);
        
                    if ($stmt->execute()) {
                        $response['message'] = "Usuario creado con éxito";
                        $response['user_id'] = $conn->lastInsertId();
                    } else {
                        $response['error'] = "Error al crear el usuario: " . $stmt->errorInfo()[2];
                    }
                }
            } else {
                $response['error'] = "Faltan datos. Por favor, completa todos los campos.";
            }
        }
        
         elseif (isset($_POST['accion']) && $_POST['accion'] === 'inicio_sesion') {
            $correo = $_POST['correo'];
            $password = $_POST['contrasena'];

            // Seleccionar el usuario por correo
            $query = "SELECT * FROM usuarios WHERE correo = :correo";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                // Si no existe el correo en la base de datos
                $response['error'] = "El correo no está registrado.";
            } elseif ($user && $password !== $user['contrasena']) {  // Comparar directamente sin password_verify
                // Si la contraseña es incorrecta
                $response['error'] = "Contraseña incorrecta.";
            } else {
                // Inicio de sesión exitoso
                $response['message'] = "Inicio de sesión exitoso";
                $response['user'] = $user;
            }
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        $idUsuario = $_PUT['idUsuario'];
        $nombre = $_PUT['nombre'];
        $correo = $_PUT['correo'];

        $query = "UPDATE usuarios SET nombre = :nombre, correo = :correo WHERE idUsuario = :idUsuario";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $response['message'] = "Usuario actualizado con éxito";
        } else {
            $response['error'] = "Error al actualizar el usuario";
        }
        break;

    case 'DELETE':
        $idUsuario = $_GET['idUsuario'];
        $query = "DELETE FROM usuarios WHERE idUsuario = :idUsuario";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $response['message'] = "Usuario eliminado con éxito";
        } else {
            $response['error'] = "Error al eliminar el usuario";
        }
        break;

    default:
        $response['error'] = "Método no permitido";
}

header('Content-Type: application/json');
echo json_encode($response);
