<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Obtener todos los estudiantes

$app->get('/api/estudiantes', function(Request $request, Response $response){
	//echo "Estudiantes";
	$sql = "select * from estudiante";

	try{
		// Obtener el objeto DB 
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiantes);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{nocontrol}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('nocontrol');

    $sql = "SELECT * FROM estudiante WHERE nocontrol = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('nocontrol');
    $nombre = $request->getParam('nombre');
    $apellidop = $request->getParam('apellidop');
    $apellidom = $request->getParam('apellidom');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "INSERT INTO estudiante (nocontrol, nombre_estudiante, apellido_p_estudiante, apellido_m_estudiante, semestre, carrera_clave) VALUES (:nocontrol, :nombre, :apellidop, :apellidom, :semestre, :carrera_clave)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nocontrol',      $nocontrol);
        $stmt->bindParam(':nombre',         $nombre);
        $stmt->bindParam(':apellidop',      $apellidop);
        $stmt->bindParam(':apellidom',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar estudiante
$app->put('/api/estudiantes/update/{nocontrol}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('nocontrol');
    $nombre = $request->getParam('nombre');
    $apellidop = $request->getParam('apellidop');
    $apellidom = $request->getParam('apellidom');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "UPDATE estudiante SET
                nocontrol               = :nocontrol,
                nombre_estudiante       = :nombre,
                apellido_p_estudiante   = :apellidop,
                apellido_m_estudiante   = :apellidom,
                semestre                = :semestre,
                carrera_clave           = :carrera_clave
            WHERE nocontrol = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nocontrol',      $nocontrol);
        $stmt->bindParam(':nombre',         $nombre);
        $stmt->bindParam(':apellidop',      $apellidop);
        $stmt->bindParam(':apellidom',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar estudiante
$app->delete('/api/estudiantes/delete/{nocontrol}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('nocontrol');

    $sql = "DELETE FROM estudiante WHERE nocontrol = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});