<?php
class VehiclesModel {
    private $db;

    public function __construct() {
        $this->db = new PDO(
                              "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=utf8", 
                               MYSQL_USER, MYSQL_PASS
        );
    }
  
    
    public function getVehicles() {
        $sql = 'SELECT * FROM vehicle';
        $params = [];
        try {
            $query = $this->db->prepare($sql);
            $query->execute($params); // Paso los parámetros 
            $vehicle = $query->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            // Manejar la excepción
            throw new RuntimeException("Error en la consulta: " . $e->getMessage());
        }
    
        return $vehicle;
    }
    public function getVehicleById($id) {
        $query = $this->db->prepare('SELECT * FROM vehicle WHERE id_vehicle = ?');
        $query->execute([$id]);
        $vehicle = $query->fetch(PDO::FETCH_OBJ);


        return $vehicle;
    }
    public function insertVehicle($car_brand, $version, $year, $mileage, $description, $price) {
    
        $query = $this->db->prepare('INSERT INTO vehicle( car_brand	, version, year,mileage, description, price) VALUES (?, ?,?, ?, ?, ?)');
        $query->execute([$car_brand	, $version,$year,$mileage, $description,$price]);
    
        $id_vehicle = $this->db->lastInsertId();
        return $id_vehicle;
    }
    public function cleanVehicle($id){
        try {
            $query = $this->db->prepare("DELETE FROM vehicle WHERE id_vehicle = ?");
            $query->execute([$id]);
            return true; // Devuelve true si la eliminación fue exitosa
        } catch (PDOException $e) {
            // Si hay una violación de clave foránea, propagamos el error al controlador
            if ($e->getCode() == '23000') { 
                return 'foreign_key_error'; 
            } else {
                throw $e; 
            }
        }

    }
    public function updateVehicle($car_brand, $version, $year,$mileage, $description, $price $id) {
        // Obtener el productor existente para conservar la imagen actual si no se proporciona una nueva
        $vehicle = $this->getVehicleById($id);
    
        // Actualizar los datos de la productora en la base de datos
        $query = $this->db->prepare('UPDATE vehicle SET car_brand = ?, version= ?, year= ?, mileage= ?, description = ?, price= ?,WHERE id_vehicle = ?');
        $query->execute([$car_brand, $version,$year, $mileage, $description, $price,$id]);
    }
    
}