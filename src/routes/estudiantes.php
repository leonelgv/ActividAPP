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

// Get Single Customer
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
