<?php

class CompleteRange{

    public function build($array) {

	    $array = array_filter($array, function ($a) { 
        return  $a > 0;
      });

      $max = max($array);
	    $min = min($array);

      $out=array();

		  for ($i=$min; $i <= $max; $i++){
          	$out[]=$i;
		  }

      echo json_encode($out);
    }
}

 $in=[55, 58, 60];
 echo CompleteRange::build($in);
?>
