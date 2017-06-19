<?php

  $code = $_POST['ncode'];
  $P1 = $_POST['p1'];
  $P2 = $_POST['p2'];


  $code2 = "load am7ll .
            red >> 'OrAddR1 < " . $code ."> < ".$P1." ; ".$P2." > .";

  
 $tmpfname = tempnam("/var/www/wordpress/Prover-Maude/RL", 'MAUDE');


  $arquivo = fopen($tmpfname, 'w'); 
  fwrite($arquivo, $code2);
  fclose($arquivo);

   exec("maude -no-banner ".$tmpfname, $output);

   $posicao = strpos($output[3], "String");
    if(strpos($output[3], '"') > 0){
      $posAspas = strpos($output[3], '"');
      $codigo =  substr($output[3], $posAspas+1, strlen($output[3])-$posAspas-2);
    }
    else{
      $codigo = substr($output[3], $posicao+8, strlen($output[3]));
    } 

unlink($tmpfname); 
 ?>