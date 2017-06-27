<?php

  $code = $_POST['ncode'];
  $P1 = $_POST['p1'];
  $P2 = $_POST['p2'];


  $code2 = "load am7ll .
            red >> 'OrAddR1 < " . $code ."> < ".$P1." ; ".$P2." > .";

  
  $tmpfname = tempnam("/var/www/html/Prover/RL", 'MAUDE');


  $arquivo = fopen($tmpfname, 'w'); 
  fwrite($arquivo, $code2);
  fclose($arquivo);

   exec("maude -no-banner ".$tmpfname, $output);


    for($i = 0; $i < count($output); $i++){

      if(strpos($output[$i], "String") > 0){
            $posicao = strpos($output[$i], "String");
            if(strpos($output[$i], '"') > 0){
              $posAspas = strpos($output[$i], '"');
              $codigo =  substr($output[$i], $posAspas+1, strlen($output[$i])-$posAspas-2);
            }
            else{
              $codigo = substr($output[$i], $posicao+8, strlen($output[$i]));
            }
            break; 
       }
       else{
           $codigo = " 'Result String' não encontrado na string. ";
       }
    }

    echo $codigo;

  unlink($tmpfname); 
 ?>