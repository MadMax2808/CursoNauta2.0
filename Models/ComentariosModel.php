<?php
class ComentariosModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function obtenerComentario($id_curso, $id_usuario)
    {
        $sql = "CALL ObtenerComentario(:id_curso, :id_usuario)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardarComentario($id_curso, $id_usuario, $comentario, $calificacion)
    {
        $sql = "CALL GuardarComentario(:id_curso, :id_usuario, :comentario, :calificacion)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
        $stmt->bindParam(':calificacion', $calificacion, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
