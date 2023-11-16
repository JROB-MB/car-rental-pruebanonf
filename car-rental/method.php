<?php
require "config/Conexion.php";

  //print_r($_SERVER['REQUEST_METHOD']);
  switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      // Consulta SQL para seleccionar datos de la tabla
      $sql = "SELECT id_fleet, image_fleet, passegengers, luggages, doors, transmission, carName, priceFleet, description FROM fleet";

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

$conexion->close();
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
      case 'PATCH':
        if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
          parse_str(file_get_contents("php://input"), $datos);
      
          $id_mae = $datos['id_mae'];
          $apodo = $datos['apodo'];
          $foto = $datos['foto'];
          $tel = $datos['tel'];
      
          if ($_SERVER['REQUEST_METHOD'] === 'PATCH') { // Método PATCH
              $actualizaciones = array();
              if (!empty($apodo)) {
                  $actualizaciones[] = "apodo = '$apodo'";
              }
              if (!empty($foto)) {
                  $actualizaciones[] = "foto = '$foto'";
              }
              if (!empty($tel)) {
                  $actualizaciones[] = "tel = '$tel'";
              }
      
              $actualizaciones_str = implode(', ', $actualizaciones);
              $sql = "UPDATE maestro SET $actualizaciones_str WHERE id_mae = $id_mae";
          }
      
          if ($conexion->query($sql) === TRUE) {
              echo "Registro actualizado con éxito.";
          } else {
              echo "Error al actualizar registro: " . $conexion->error;
          }
      } else {
          echo "Método de solicitud no válido.";
      }
      
      $conexion->close();
       break;

       case 'PUT':
    
      if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Leer los datos enviados en el cuerpo de la solicitud
        parse_str(file_get_contents("php://input"), $datos);
    
        // Obtener el id del registro a actualizar
        $id = $datos['id'];
        $pickup_location = $datos['pickup_location'];
        $return_location = $datos['return_location'];
        $full_name = $datos['full_name'];
        $email = $datos['email'];
        $phone = $datos['phone'];
    
        // Actualizar los datos en la tabla
        $sql = "UPDATE book SET pickup_location = '$pickup_location', return_location = '$return_location', full_name = '$full_name', email = '$email',  phone = '$phone' WHERE id = '$id'"; // Reemplaza con el nombre de tu tabla
    
        if ($conexion->query($sql) === TRUE) {
            echo "Datos actualizados con éxito.";
        } else {
          echo "Error al actualizar datos: " . $conexion->error;
    }
      } else {
          echo "Esta API solo admite solicitudes PUT.";
}

    // case 'PUT':
    //   if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
    //     parse_str(file_get_contents("php://input"), $datos);
    
    //     $id = $datos['id'];
    //     $pickup_location = $datos['pickup_location'];
    //     $return_location = $datos['return_location'];
    //     $full_name = $datos['full_name'];
    //     $email = $datos['email'];
    //     $phone = $datos['phone'];
    //     $img = $datos['img'];
    
    //     if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    //         $sql = "UPDATE book SET pickup_location = '$pickup_location', return_location = '$return_location', full_name = '$full_name', email = '$email',  phone = '$phone' WHERE id = $id";
    //     } else { // Método PATCH
    //         $actualizaciones = array();
    //         if (!empty($pickup_location)) {
    //             $actualizaciones[] = "pickup_location = '$pickup_location'";
    //         }
    //         if (!empty($return_location)) {
    //             $actualizaciones[] = "return_location = '$return_location'";
    //         }
    //         if (!empty($full_name)) {
    //             $actualizaciones[] = "full_name = '$full_name'";
    //         }
    //         if (!empty($email)) {
    //             $actualizaciones[] = "email = '$email'";
    //         }
    //         if (!empty($phone)) {
    //             $actualizaciones[] = "phone = '$phone'";
    //         }
    
    //         $actualizaciones_str = implode(', ', $actualizaciones);
    //         $sql = "UPDATE book SET $actualizaciones_str WHERE id = $id";
    //     }
    
    //     if ($conexion->query($sql) === TRUE) {
    //         echo "Registro actualizado con éxito.";
    //     } else {
    //         echo "Error al actualizar registro: " . $conexion->error;
    //     }
    // } else {
    //     echo "Método de solicitud no válido.";
    // }
    
    $conexion->close();

      break;
  
      
    case 'DELETE':
      if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Procesar solicitud DELETE
        $id = $_GET['id'];
        $sql = "DELETE FROM book WHERE id = $id";
    
        if ($conexion->query($sql) === TRUE) {
            echo "Registro eliminado con éxito.";
        } else {
            echo "Error al eliminar registro: " . $conexion->error;
        }
    } else {
        echo "Método de solicitud no válido.";
    }
    $conexion->close();
      break;

      case 'OPTIONS':
     // Habilitar CORS para cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir métodos HTTP específicos
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE, HEAD, TRACE, PATCH");

// Permitir encabezados personalizados
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Permitir credenciales
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Responder a la solicitud OPTIONS sin procesar nada más
    http_response_code(200);
    exit;
}

        
        break;
case 'HEAD':
  if ($_SERVER['REQUEST_METHOD'] === 'HEAD') {
    // Establecer encabezados de respuesta
    header('Content-Type: application/json');
    header('Custom-Header: PHP 8, HTML ');

    // Puedes establecer otros encabezados necesarios aquí

    // No es necesario enviar un cuerpo en una solicitud HEAD, por lo que no se imprime nada aquí.
} else {
    http_response_code(405); // Método no permitido
    echo 'Método de solicitud no válido';
}
  break;

  case 'TRACE':
    header("Access-Control-Allow-Origin: *");
    if ($_SERVER['REQUEST_METHOD'] === 'TRACE') {
      $response = "Solicitud TRACE recibida. Estado: 200 OK";
  } else {
      $response = "Método de solicitud no válido. Estado: 405 Método no permitido";
  }
  
  echo $response;
    break;

    case'LINK':
      $apiUrl = 'https://ejemplo.com/tu_endpoint'; // Reemplaza con la URL de tu API
      $resourceUri = '/ruta/a/tu/recurso'; // Reemplaza con la ruta de tu recurso
      $linkHeader = '<' . $resourceUri . '>; rel="link-type"'; // Define el encabezado Link
      
      $options = [
          'http' => [
              'method' => 'LINK',
              'header' => 'Link: ' . $linkHeader,
          ],
      ];
      
      $context = stream_context_create($options);
      $response = file_get_contents($apiUrl, false, $context);
      
      if ($response === false) {
          echo "Error al enviar la solicitud LINK.";
      } else {
          echo "Solicitud LINK exitosa. Respuesta del servidor: " . $response;
      }
      break;
case 'UNLINK':
    $apiUrl = 'https://ejemplo.com/tu_endpoint'; // Reemplaza con la URL de tu API
    $resourceUri = '/ruta/a/tu/recurso'; // Reemplaza con la ruta de tu recurso
    $linkHeader = '<' . $resourceUri . '>; rel="unlink"'; // Define el encabezado Link
    
    $options = [
        'http' => [
            'method' => 'UNLINK',
            'header' => 'Link: ' . $linkHeader,
        ],
    ];
    
    $context = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);
    
    if ($response === false) {
        echo "Error al enviar la solicitud UNLINK.";
    } else {
        echo "Solicitud UNLINK exitosa. Respuesta del servidor: " . $response;
    }
    break;

     default:
       echo 'undefined request type!';
  }
?>