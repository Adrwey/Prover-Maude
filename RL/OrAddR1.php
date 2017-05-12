<?php

  $code = $_POST['ncode'];


  $code2 = "load am7ll .
            red MetaReduce " . $code ." in 'am7ll applying 'OrAddR1 .";


  $tmpfname = tempnam("/var/www/html/Prover/RL", 'MAUDE');


  $arquivo = fopen($tmpfname, 'w'); 
  fwrite($arquivo, $code2);
  fclose($arquivo);

   exec("maude -no-banner ".$tmpfname, $output);

    for($i = 0; $i <= count($output); $i++){
          if(strpos($output[$i], "Sequente:") > 0){

          
          //echo " <div id='div1'>  </div>";
          $codigo = substr($output[$i], 17, strlen($output[$i]));
          //echo "<button id='button1'>AA</button>";
          //$posicao = strstr($output[$i], "Sequente:");
          
          echo "<b id='codigo'>".$codigo."</b>";
          
          }
          
          
        }

unlink($tmpfname); 
 ?>