
<?php
require(__DIR__ . '/../config/Conexion.php');


  //print_r($_SERVER['REQUEST_METHOD']);
  switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $query = "SELECT * FROM book";

        $result = mysqli_query($conexion, $query);
        
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $pickup_location = $row["pickup_location"];
                $return_location = $row["return_location"];
                $pickup_datetime = $row["pickup_datetime"];
                $return_datetime = $row["return_datetime"];
                $full_name = $row["full_name"];
                $email = $row["email"];
                $phone = $row["phone"];
            }
        } else {
            echo "No se encontraron datos en la base de datos.";
        };
        

        
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
      //   if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
      //     parse_str(file_get_contents("php://input"), $result);
      //     $id = $result['id'];

      //     $pickup_location = $result['pickup_location'];
      //     $return_location = $result['return_location'];
      //     $full_name = $result['full_name'];
      //     $email = $result['email'];
      //     $phone = $result['phone'];

      
      //     if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
      //         $sql = "UPDATE book SET pickup_location = '$pickup_location', return_location = '$return_location', full_name = '$full_name', email = '$email', phone = '$phone' WHERE id = $id";
      //     } else { // Método PATCH
      //         $actualizaciones = array();
      //         if (!empty($pickup_location)) {
      //             $actualizaciones[] = "pickup_location = '$pickup_location'";
      //         }
      //         if (!empty($return_location)) {
      //             $actualizaciones[] = "return_location = '$return_location'";
      //         }
      //         if (!empty($tel)) {
      //             $actualizaciones[] = "full_name = '$full_name'";
      //         }
      //         if (!empty($email)) {
      //           $actualizaciones[] = "email = '$email'";
      //       }
      //       if (!empty($phone)) {
      //         $actualizaciones[] = "phone = '$phone'";
      //     }
      
      //         $actualizaciones_str = implode(', ', $actualizaciones);
      //         $sql = "UPDATE maestro SET $actualizaciones_str WHERE id_mae = $id_mae";
      //     }
      
      //     if ($conexion->query($sql) === TRUE) {
      //         echo "Registro actualizado con éxito.";
      //     } else {
      //         echo "Error al actualizar registro: " . $conexion->error;
      //     }
      // } else {
      //     echo "Método de solicitud no válido.";
      // }
      
      // $conexion->close();
       break;
      case 'PUT':
        if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
          parse_str(file_get_contents("php://input"), $result);
          $id = $result['id'];

          $pickup_location = $result['pickup_location'];
          $return_location = $result['return_location'];
          $full_name = $result['full_name'];
          $email = $result['email'];
          $phone = $result['phone'];

      
          if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
              $sql = "UPDATE book SET pickup_location = '$pickup_location', return_location = '$return_location', full_name = '$full_name', email = '$email', phone = '$phone' WHERE id = $id";
          } else { // Método PATCH
              $actualizaciones = array();
              if (!empty($pickup_location)) {
                  $actualizaciones[] = "pickup_location = '$pickup_location'";
              }
              if (!empty($return_location)) {
                  $actualizaciones[] = "return_location = '$return_location'";
              }
              if (!empty($tel)) {
                  $actualizaciones[] = "full_name = '$full_name'";
              }
              if (!empty($email)) {
                $actualizaciones[] = "email = '$email'";
            }
            if (!empty($phone)) {
              $actualizaciones[] = "phone = '$phone'";
          }
      
              $actualizaciones_str = implode(', ', $actualizaciones);
              $sql = "UPDATE book SET $actualizaciones_str WHERE id = $id";
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
      // case 'PUT':
      //   // Recopila los datos del formulario
      //   parse_str(file_get_contents("php://input"), $_PUT);
      //   $id = $_PUT["id"];
      //   $pickupLocation = $_PUT["pickup_location"];
      //   $returnLocation = $_PUT["return_location"];
      //   $fullName = $_PUT["full_name"];
      //   $email = $_PUT["email"];
      //   $phone = $_PUT["phone"];
    
      //   // Realiza la actualización en la tabla "book"
      //   $query = "UPDATE book
      //             SET pickup_location = '$pickupLocation',
      //                 return_location = '$returnLocation',
      //                 full_name = '$fullName',
      //                 email = '$email',
      //                 phone = '$phone'
      //             WHERE id = $id";
    
      //   // Ejecuta la consulta de actualización en la base de datos
      //   // Asegúrate de que la conexión a la base de datos esté configurada correctamente antes de esta parte
    
      //   if (mysqli_query($conexion, $query)) {
      //       // La actualización fue exitosa
      //       echo "Actualización exitosa";
      //   } else {
      //       // Si hubo un error en la actualización, puedes manejarlo aquí
      //       echo "Error en la actualización: " . mysqli_error($conexion);
      //   }
      //   break;
    
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
  
     default:
       echo 'undefined request type!';
  }
?>