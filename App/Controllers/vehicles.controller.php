
<?php
// Aqui las carpetas ajenas a esta, la cual usaremos sus archivos.
require_once './App/Models/vehicles.model.php';
require_once './App/Views/json.view.php';



class VehiclesController {
    private $model;
    private $view;
    private $producerModel;


    public function __construct() {
        // Instancio el modelo de películas
        $this->model = new VehiclesModel();

        // Instancio la vista de películas 
        $this->view =new JSONview();

    }
    
    public function showVehicles($req, $res) {// Obtener los vehiculos
        $vehicles = $this->model->getVehicles();
    
        return $this->view->response($vehicles); 
    }
    
    public function showVehicleDetails($req, $res) {
        $id_vehicle = $req->params->id;
        // Obtengo la película específica por ID
        $vehicle = $this->model->getVehicleById($id_vehicle);
        
        // Muestra la vista con los detalles de la película y la lista de otras películas
        $this->view->response($vehicle);
    }

    public function addVehicle($req, $res) {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
       $body=$req->body;

        // Validación de campos obligatorios
        if (empty($body['car_brand	'])) {
            return $this->view->response('Falta completar el marca del vehiculo', 404);
        }
        if (empty($body['version'])) {
            return $this->view->response('Falta completar la version del vehiculo',404);
        }
        if (empty($body['year'])) {
            return $this->view->response('Falta completar el año del vehiculo',404);
        }
        if (empty($body['mileage'])) {
            return $this->view->response('Falta completar el klometraje del vehiculo',404);
        }
        if (empty($body['description'])) {
            return $this->view->response('Falta completar la descripcion del vehiculo',404);
        }
        if (empty($body['price'])) {
            return $this->view->response('Falta completar el precio del vehiculo',404);
        }
      
            // Obtengo los datos del formulario
          $name=$body['car_brand'];
          $model =$body['version'];
          $year =$body['year'];
          $mileage=$body['mileage'];
          $description = $body['description'];
          $price =$body['price'];

         
          // Insento la pelicula
          $id_vehicle = $this->model->insertVehicle($car_brand, $version,$year,$mileage, $description, $price);
  
      
          // Verificar si la inserción fue exitosa
          if ($id_vehicle) {
              // Redirigir al home
             return $this->view->response("se agrego con exito el vehiculo con el id=$id_vehicle.", 201);
             
          } else {
              return $this->view->response('Error al agregar el vehicle. Por favor, inténtelo de nuevo.');
          }
    }
    public function deleteVehicle($req, $res) {
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        $id_vehicle = $req->params->id;
        
        // Obtener la película específica por su ID
        $vehicle = $this->model->getVehicleById($id_vehicle);
    
        if (!$vehicle) {
            return $this->view->response("No existe el vehiculo con el id = $id_vehicle");
        }
    
        // Eliminar la película
        $this->model->cleanVehicle($id_vehicle);
    
        return $this->view->response("Se borró con éxito el vehiculo con el id = $id_vehicle");
    }
    public function editVehicle($req, $res){
        
        if (!$res->user) {
            return $this->view->response("No autorizado", 401);
        }
        $body=$req->body;
        $id_vehicle = $req->params->id;
        // Obtengo la película específica por id
        $vehicle = $this->model->getVehicleById($id_vehicle); // Usa getFilmById para obtener un vehiculo
    
        if (!$vehicle) {
            return $this->view->response("No existe el vehiculo con el id = $id_vehicle");
        }
    
            // Validación de los campos del formulario
            if (empty($body['car_brand	'])) {
                return $this->view->response('Falta completar el marca del vehiculo', 404);
            }
            if (empty($body['version'])) {
                return $this->view->response('Falta completar la version del vehiculo',404);
            }
            if (empty($body['year'])) {
                return $this->view->response('Falta completar el año del vehiculo',404);
            }
            if (empty($body['mileage'])) {
                return $this->view->response('Falta completar el kilometraje del vehiculo',404);
            }
            if (empty($body['description'])) {
                return $this->view->response('Falta completar la descripcion del vehiculo',404);
            }
            if (empty($body['price'])) {
                return $this->view->response('Falta completar el precio del vehiculo',404);
            }
          
           
         // Obtengo los datos del formulario
          $name =$body['car_brand'];
          $model =$body['version'];
          $year =$body['year'];
          $mileage=$body['mileage'];
          $description = $body['description'];
          $price =$body['price'];

         
            // Llamo al modelo para actualizar los datos
            $this->model->updateVehicle($id_vehicle, $car_brand	, $version, $year,$mileage, $description, $price);
            $vehicle= $this->model->getVehicleById($id_vehicle);
            return $this->view->response($vehicle); 
           
        
    
    }
    

}