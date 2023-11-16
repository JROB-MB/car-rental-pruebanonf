<?php
session_start();


// Verifica si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    

    if ($data && isset($data->user)) {
        $user = $data->user;
        $_SESSION['user_id'] = $user->uid;
       
    }
}


if (isset($_SESSION['user_id'])) {
   
 } else {
     header("Location: index.php"); // Redirect to your login page
     exit();
 }

?>

<?php
require "back/hiddenb.php";
include_once 'header.php';

?>

    <section>
        <div class="container">
            <div class="text-center">
                <h1>Fleet</h1>
                <br>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo, alias.</p>
            </div>
        </div>
    </section>
    <section class="section-background">
        <div class="container">
            <div class="row">
                

                

               
                <section class="section-background">
    <div class="container">
        <div class="row">
            <?php foreach($result as $row) { ?>
                <div class="container mt-4">
                    <h1>Detalles del Cliente</h1>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>ID:</strong> <?php echo $row['id']; ?></li>
                        <li class="list-group-item"><strong>Pick-up Location:</strong> <?php echo $row['pickup_location']; ?></li>
                        <li class="list-group-item"><strong>Return Location:</strong> <?php echo $row['return_location']; ?></li>
                        <li class="list-group-item"><strong>Pick-up Date/Time:</strong> <?php echo $row['pickup_datetime']; ?></li>
                        <li class="list-group-item"><strong>Return Date/Time:</strong> <?php echo $row['return_datetime']; ?></li>
                        <li class="list-group-item"><strong>Full Name:</strong> <?php echo $row['full_name']; ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?php echo $row['email']; ?></li>
                        <li class="list-group-item"><strong>phone:</strong> <?php echo $row['phone']; ?></li>
                    </ul>

                   


                    
<div id="response"></div>


                </div>
            <?php } ?>
        </div>
    </div>
</section>


<form id="deleteForm">
        <label for="id">ID del Registro a Eliminar:</label>
        <input type="text" id="id" name="id" required>
        <button type="button" id="deleteButton">Eliminar</button>
        <div id="response"></div>
    </form>

    <script>
        // Agregar un evento al botón para enviar la solicitud DELETE
        document.getElementById('deleteButton').addEventListener('click', function () {
            var id = document.getElementById('id').value;

            fetch('method.php?id=' + id, {
                method: 'DELETE'
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(data) {
                document.getElementById('response').textContent = data;
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
        });
    </script>



<form id="updateForm">
<label for="id">ID del registro a actualizar:</label>
                                <input type="number" id="id" name="id" ><br><br>

    <!-- Campos para actualizar los valores -->
    <label for="pickup_location">Nuevo Pick-up Location:</label>
    <input type="text" id="pickup_location" name="pickup_location">

    <label for="return_location">Nuevo Return Location:</label>
    <input type="text" id="return_location" name="return_location">

    <label for="full_name">Nuevo Full Name:</label>
    <input type="text" id="full_name" name="full_name">

    <label for="email">Nuevo Email:</label>
    <input type="text" id="email" name="email">

    <label for="phone">Nuevo phone:</label>
    <input type="text" id="phone" name="phone">

    <input type="submit" value="Enviar">


</form>
<div id="result"></div>

<script>
     const formulario1 = document.getElementById('updateForm');
     const resultadoDiv = document.getElementById('result');

     formulario1.addEventListener('submit', function (event) {
         event.preventDefault();

         const id = formulario1.elements.id.value;
         const pickup_location = formulario1.elements.pickup_location.value;
         const return_location = formulario1.elements.return_location.value;
         const full_name = formulario1.elements.full_name.value;
         const email = formulario1.elements.email.value;
         const phone = formulario1.elements.phone.value;
         

         fetch(`method.php?id=${id}`, {
    method: 'PUT',
    body: `id=${id}&pickup_location=${pickup_location}&return_location=${return_location}&full_name=${full_name}&email=${email}&phone=${phone}`,
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    }
})

         .then(response => response.text())
         .then(data => {
             resultadoDiv.textContent = data;
             formulario1.reset();
         })
         .catch(error => console.error('Error:', error));
     });
 </script> 










<!-- <script>
document.getElementById('putButton').addEventListener('click', function () {
    actualizarRegistro('PUT');
});

function actualizarRegistro(metodo) {
    var id = document.querySelector('input[name="id"]').value;
    var pickup_location = document.querySelector('input[name="pickup_location"]').value;
    var return_location = document.querySelector('input[name="return_location"]').value;
    var full_name = document.querySelector('input[name="full_name"]').value;
    var email = document.querySelector('input[name="email"]').value;
    var phone = document.querySelector('input[name="phone"]').value;

    var data = {
        id: id,
        pickup_location: pickup_location,
        return_location: return_location,
        full_name: full_name,
        email: email,
        phone: phone
    };

    fetch('hiddenb.php', {
        method: metodo,
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(function(response) {
        if (response.ok) {
            return response.text();
        } else {
            throw new Error('Error en la solicitud: ' + response.statusText);
        }
    })
    .then(function(data) {
        document.getElementById('response').textContent = data;
    })
    .catch(function(error) {
        console.error('Error:', error);
    });
}



</script> -->




               


<!-- <script>
        document.getElementById('putButton').addEventListener('click', function () {
    actualizarRegistro('PUT');
});

document.getElementById('patchButton').addEventListener('click', function () {
    actualizarRegistro('PATCH');
});

function actualizarRegistro(metodo) {
    var id = document.getElementById('id').value;
    var pickup_location = document.getElementById('pickup_location').value;
    var return_location = document.getElementById('return_location').value;
    var full_name = document.getElementById('full_name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;

    var result = new URLSearchParams();
    result.append('id', id);
    result.append('pickup_location', pickup_location);
    result.append('return_location', return_location);
    result.append('full_name', full_name);
    result.append('email', email);
    result.append('phone', phone);

    fetch('hiddenb.php', {
        method: metodo,
        body: result
    })
    .then(function(response) {
        return response.text();
    })
    .then(function(data) {
        document.getElementById('response').textContent = result;
    })
    .catch(function(error) {
        console.error('Error:', error);
    });
}

    </script> -->
            </div>
        </div>
    </section>
    
    
    

     
    <?php
    include_once 'footer.php';
    ?>
</body>
</html>
