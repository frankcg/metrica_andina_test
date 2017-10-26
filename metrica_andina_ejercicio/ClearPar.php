<?php

class ClearPar{

    public function build($string) {
	  
      $out='';
      $cant=substr_count($string, '()'); //Cuenta el número de apariciones del substring

      for ($i=0; $i < $cant; $i++) {
          $out.= '()';
      }
      echo $out;

    }
}
	
 	echo ClearPar::build("()())()");

?>
