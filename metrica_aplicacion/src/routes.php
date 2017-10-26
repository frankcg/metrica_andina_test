<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/employee', function (Request $request, Response $response, array $args) {

    $json = file_get_contents(__DIR__ . '/../bd/employees.json');
    $data = json_decode($json, true);
    $json_email = $request->getQueryParam('correo');
    $grid = array();
    ($json_email=='')? $grid = $data : $grid = [];

    if ($json_email!='') {
    	foreach ($data as $value) {
    		if (strpos($value['email'], $json_email) !== false) {
			    $grid[] = $value;
			  }
    	}
    }
    return $this->renderer->render($response, 'employees.phtml', array('empleado' => $grid,'correo' => $json_email));
});



$app->get('/salary', function ($request, $response, $args) {

	$json = file_get_contents(__DIR__ . '/../bd/employees.json');	
    $data = json_decode($json, true);

    $minimo = $request->getQueryParam('minimo');
    $maximo = $request->getQueryParam('maximo');

	($minimo=='' && $maximo=='')?$valor = $data: $valor = [];

    if ($minimo && $maximo) {
	    foreach ($data as $contenido) {
	    	$sueldo = str_replace(',', '', $contenido['salary']); //LIMPIANDO SALARIO
	    	$sueldo = str_replace('$', '', $sueldo); //LIMPIANDO SALARIO
	    	$sueldo = floatval($sueldo);
	    	//echo $sueldo; exit();
	    	if ($sueldo >= $minimo && $sueldo <= $maximo ) {
	    		$array_valor[] = $contenido;
	    	}
	    }
    }

    // ARMANDO EL XML
	$doc = new DomDocument('1.0');
	$element = $doc->createElement('element');
	$element = $doc->appendChild($element);

	foreach ($array_valor as $elemento=>$data):

	    $occ = $doc->createElement('employee');
	    $occ = $element->appendChild($occ);

	    foreach ($data as $key=>$dato):

	        $child = $doc->createElement($key);
	        $child = $occ->appendChild($child);

			if (is_array($dato) || is_object($dato)){

				foreach($dato as $val):
					$value = $doc->createElement('skill');
					$value = $child->appendChild($value);
					$values = $doc->createTextNode($val['skill']);
			        $values = $value->appendChild($values);
				endforeach;

			}else{
				$value = $doc->createTextNode($dato);
		        $value = $child->appendChild($value);
			}

	    endforeach;

	endforeach;

	$xml = $doc->saveXML() ;
	echo $xml; // IMPRIMIR XML
});