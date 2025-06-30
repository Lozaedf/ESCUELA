<?php
require_once 'User.php';

class Student extends User {
    private $grades_table = "notas";
    private $materials_table = "materias";

    public function __construct($db) {
        parent::__construct($db);
        $this->type = 'alumno';
    }

    public function getGrades() {
        $query = "SELECT m.nombre AS materia, n.trimestre, n.nota
                  FROM " . $this->grades_table . " n
                  JOIN " . $this->materials_table . " m ON n.id_materia = m.id
                  WHERE n.id_alumno = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->related_id);
        $stmt->execute();
        
        return $stmt->get_result();
    }
}
?>