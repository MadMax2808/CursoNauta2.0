<?php
class MensajesModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function obtenerInstructoresConMensajes($id_emisor)
    {
        try {
            $query = "CALL ObtenerInstructoresConMensajes(:id_emisor)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_emisor", $id_emisor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener instructores con mensajes: " . $e->getMessage();
            return [];
        }
    }

    public function obtenerMensajesEntreUsuarios($id_emisor, $id_receptor)
    {
        try {
            $query = "CALL ObtenerMensajesEntreUsuarios(:id_emisor, :id_receptor)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_emisor", $id_emisor, PDO::PARAM_INT);
            $stmt->bindParam(":id_receptor", $id_receptor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los mensajes entre usuarios: " . $e->getMessage();
            return [];
        }
    }

    public function iniciarChatSiNoExiste($id_emisor, $id_receptor)
    {
        // Verificar si ya existe un chat entre el usuario y el instructor
        $query = "SELECT * FROM Mensajes WHERE (id_emisor = :id_emisor AND id_receptor = :id_receptor) OR (id_emisor = :id_receptor AND id_receptor = :id_emisor)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_emisor", $id_emisor);
        $stmt->bindParam(":id_receptor", $id_receptor);
        $stmt->execute();

        // Crear un mensaje de bienvenida si no existe un chat previo
        if ($stmt->rowCount() == 0) {
            $query = "INSERT INTO Mensajes (id_emisor, id_receptor, mensaje) VALUES (:id_emisor, :id_receptor, 'Hola, este es el inicio de nuestra conversación')";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_emisor", $id_emisor);
            $stmt->bindParam(":id_receptor", $id_receptor);
            $stmt->execute();
        }
    }

    public function enviarMensaje($id_emisor, $id_receptor, $mensaje)
    {
        try {
            $query = "CALL EnviarMensaje(:id_emisor, :id_receptor, :mensaje)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_emisor", $id_emisor, PDO::PARAM_INT);
            $stmt->bindParam(":id_receptor", $id_receptor, PDO::PARAM_INT);
            $stmt->bindParam(":mensaje", $mensaje, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al enviar el mensaje: " . $e->getMessage();
            return false;
        }
    }
}
