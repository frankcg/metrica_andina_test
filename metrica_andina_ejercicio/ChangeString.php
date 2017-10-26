<?php
class ChangeString{

    public function build($cadena) {

      $l=1;
      $array = array();
      $len = mb_strlen($cadena, "UTF-8");

      for ($i=0; $i < $len; $i++) {
          $array[] = mb_substr($cadena, $i, $l, "UTF-8");
      }

      foreach ($array as $key => $value):
        if($value=='Ñ'){
            $abecedario=79;
            $abecedario=chr($abecedario);
            $abecedario='<font color="red"><strong>'.$abecedario.'</strong></font>';
        } else if($value=='ñ'){
            $abecedario=111;
            $abecedario=chr($abecedario);
            $abecedario='<font color="red"><strong>'.$abecedario.'</strong></font>';
        } else {
          $ascii=ord($value); // devuelve el valor ASCII de un caracter

          if(($ascii>=97 && $ascii<=122) || ($ascii>=65 && $ascii<=90)){
    				$abecedario=$ascii+1; // LETRA SIGUIENTE

      			if($ascii==122){
      					$abecedario=97;
      			}else if($ascii==90){
      					$abecedario=65;
      			}    				
            $abecedario='<font color="red"><strong>'.chr($abecedario).'</strong></font>';    			
          }else{
    				$abecedario=chr($ascii);
    			}
        }        
        $salida.=$abecedario; // ALMACENANDO SALIDA
      endforeach;

      echo $salida; // IMPRIMIENDO RESPUESTA
    }
}

 echo ChangeString::build('123 abcd*3');

?>
