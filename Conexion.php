<?php
class Conexion {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "evento_itech"; // 👈 Cambia al nombre de TU BD

    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        // Para tildes y ñ
        $this->conn->set_charset("utf8mb4");
    }

    public function getConexion() {
        return $this->conn;
    }
}
?>
