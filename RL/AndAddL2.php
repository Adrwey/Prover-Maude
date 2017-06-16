<?php

  $code = $_POST['ncode'];
  $P1 = $_POST['p1'];
  $P2 = $_POST['p2'];


  $code2 = "load am7ll .
            red >> 'AndAddL2 < " . $code ."> < ".$P1." & ".$P2." > .";


  $tmpfname = tempnam("/var/www/html/Prover/RL", 'MAUDE');


  $arquivo = fopen($tmpfname, 'w'); 
  fwrite($arquivo, $code2);
  fclose($arquivo);

   exec("maude -no-banner ".$tmpfname, $output);

    for($i = 0; $i < count($output); $i++){
          if(strpos($output[$i], "Sequente:") > 0){

            $codigo = substr($output[$i], 17, strlen($output[$i]));
            echo "<b id='codigo'>".$codigo."</b>";
            
          }
          
          
        }

unlink($tmpfname); 
 ?>