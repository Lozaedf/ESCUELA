<?php
require_once 'User.php';

class Teacher extends User {
    private $announcements_table = "anuncios";

    public function __construct($db) {
        parent::__construct($db);
        $this->type = 'profesor';
    }

    public function publishAnnouncement($title, $content) {
        $query = "INSERT INTO " . $this->announcements_table . " (titulo, contenido, fecha, id_profesor) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $date = date("Y-m-d");
        $stmt->bind_param("sssi", $title, $content, $date, $this->related_id);

        return $stmt->execute();
    }
    
    public function getGradesForStudent($student_id) {
        // A teacher might also need to see grades
        $query = "SELECT m.nombre AS materia, n.trimestre, n.nota
                  FROM notas n
                  JOIN materias m ON n.id_materia = m.id
                  WHERE n.id_alumno = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>