
<?php
require(__DIR__ . '/../config/Conexion.php');

  //print_r($_SERVER['REQUEST_METHOD']);
  switch($_SERVER['REQUEST_METHOD']) {
    // case 'GET':
    //     $query = "SELECT * FROM fleet";

    //     $result = mysqli_query($conexion, $query);
        
        
    //     if ($result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             $id_fleet = $row["id_fleet"];
    //             $image_fleet = $row["image_fleet"];
    //             $passegengers = $row["passegengers"];
    //             $luggages = $row["luggages"];
    //             $doors = $row["doors"];
    //             $transmission = $row["transmission"];
    //             $carName = $row["carName"];
    //             $priceFleet = $row["priceFleet"];
    //             $description = $row["description"];
    //         }
    //     } else {
    //         echo "No se encontraron datos en la base de datos.";
    //     };
    case 'GET':
      // Consulta SQL para seleccionar datos de la tabla
$sql = "SELECT id_fleet, image_fleet, passegengers, luggages,doors, transmission,carName,priceFleet,description,  FROM maestro";

$query = $conexion->query($sql);

if ($query->num_rows > 0) {
    $data = array();
    while ($row = $query->fetch_assoc()) {
        $data[] = $row;
    }
    // Devolver los resultados en formato JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "No se encontraron registros en la tabla.";
}

        
      break;
      case 'POST':
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Recopila los datos del formulario
          $pickupLocation = $_POST["pickup_location"];
          $returnLocation = $_POST["return_location"];
          $pickupDatetime = $_POST["pickup_datetime"];
          $returnDatetime = $_POST["return_datetime"];
          $fullName = $_POST["full_name"];
          $email = $_POST["email"];
          $phone = $_POST["phone"];
      
          // Realiza la inserción en la tabla "book" con las columnas correspondientes
          $query = "INSERT INTO book (pickup_location, return_location, pickup_datetime, return_datetime, full_name, email, phone)
                    VALUES ('$pickupLocation', '$returnLocation', '$pickupDatetime', '$returnDatetime', '$fullName', '$email', '$phone')";
      
          // Ejecuta la consulta de inserción en la base de datos
          // Asegúrate de que la conexión a la base de datos esté configurada correctamente antes de esta parte
      
          if (mysqli_query($conexion, $query)) {
              // La inserción fue exitosa, puedes redirigir al usuario a una página de confirmación o hacer lo que desees.
               echo "solicitud exitosa";
              //header("Location: fleet.php");
              exit;
          } else {
              // Si hubo un error en la inserción, puedes manejarlo aquí
              echo "Error en la inserción: " . mysqli_error($conexion);
          }
      }
    
      case 'PUT':
        // Recopila los datos del formulario (nuevos valores)
        $newPickupLocation = $_POST["new_pickup_location"];
        $newReturnLocation = $_POST["new_return_location"];
        $newFullname = $_POST["new_full_name"];
        $newEmail = $_POST["new_email"];
        $newPhone = $_POST["new_phone"];
        $newID = $_POST["new_ID"]; // Asegúrate de tener un campo oculto para el ID del cliente que deseas actualizar
    
        // Realiza la actualización en la tabla "fleet" con las columnas correspondientes
        $updateQuery = "UPDATE fleet SET 
                        pickup_location = '$newPickupLocation', 
                        return_location = '$newReturnLocation', 
                        full_name = '$newFullname', 
                        email = '$newEmail', 
                        phone = '$newPhone'
                        WHERE id = $newID";
    
        // Ejecuta la consulta de actualización en la base de datos
        // Asegúrate de que la conexión a la base de datos esté configurada correctamente antes de esta parte
    
        if (mysqli_query($conexion, $updateQuery)) {
            // La actualización fue exitosa, puedes redirigir al usuario a una página de confirmación o hacer lo que desees.
            echo "Actualización exitosa";
            //header("Location: fleet.php");
            exit;
        } else {
            // Si hubo un error en la actualización, puedes manejarlo aquí
            echo "Error en la actualización: " . mysqli_error($conexion);
        }
        break;

        
    case 'DELETE':
      echo 'DELETE'; // do anything
      break;
     default:
       echo 'undefined request type!';
  }
?>