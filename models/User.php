<?php
class User {
    protected $conn;
    protected $table_name = "usuarios";

    public $id;
    public $email;
    public $password;
    public $type;
    public $related_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->type = $row['tipo'];
                $this->related_id = $row['id_relacionado'];
                return true;
            }
        }
        return false;
    }
}
?>