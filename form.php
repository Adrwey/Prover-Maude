<html>
<head>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script type="text/javascript">
  </script>
</head>
<body>
<?php
 
//Código recebido
$code = $_POST['ncode'];

  $code2 = "load am7ll .
  red > < " . $code ." > .";


  $tmpfname = tempnam("/var/www/html/Prover", 'MAUDE');


  $arquivo = fopen($tmpfname, 'w'); 
  fwrite($arquivo, $code2);
  fclose($arquivo);



exec("maude -no-banner ".$tmpfname, $output);

//$codigo = 'mm';
for($i = 0; $i < count($output); $i++){
           

          
          if(strpos($output[$i], "String") > 0){
            echo " <div id='div1'> </div>";
            $posicao = strpos($output[$i], "String");
            if(strpos($output[$i], '"') > 0){
              $posAspas = strpos($output[$i], '"');
              $codigo =  substr($output[$i], $posAspas+1, strlen($output[$i])-$posAspas-2);
            }
            else{
              $codigo = substr($output[$i], $posicao+8, strlen($output[$i]));
            } 
            echo "<br><br>";
            break;
          }
          else{
            echo " <div id='div1'>  </div>";
            $codigo = "<b>ERRO:</b> <br> 'Result String' não foi encontrado na saída de Maude <br>";
          }
                     //echo "<b>".$output[$i]."</b> <br> <br>";
          
        }

unlink($tmpfname);

?>

<script type="text/javascript">
    var verdadeiro, valValor;
    //var varVari = false, ee = false;
    var ParA, ParB, OpOp, identificacao, StringPura;




    //ESTA FUNÇÃO RECEBE UMA SÉRIE DE PARAMÊTROS QUE SÃO USADOS PARA ADICIONAR BOTÕES COM FUNÇÕES ESPECÍFICAS NOS SEQUENTES
    function criarBotao(ParA, ParB, OpOp, identificacao){
        
        var botoesFormula = '<button id="'+identificacao+'1" onclick="'+identificacao+'1( \''+ParA+' \',\''+ParB +'\' )" >'+ParA+'</button> '+ OpOp +' <button id="'+identificacao+'2" onclick="'+identificacao+'2(\''+ParA+'\',\''+ParB+'\')" >'+ParB+'</button>';

        return botoesFormula;
    }
    
    
    function ee1(ParA, ParB){

       $.ajax({
              method: 'post',
              url: 'RL/AndAddL1.php',
              data: {ncode: StringPura,
              p1: ParA,
              p2: ParB },
              success: function(retorno){
                adicionar1(retorno, true);
              }
            }); 
    }

    function ee2(ParA, ParB){
       $.ajax({
              method: 'post',
              url: 'RL/AndAddL2.php',
              data: {ncode: StringPura,
              p1: ParA,
              p2: ParB },
              success: function(retorno){
                adicionar1(retorno, true);
              }
            }); 
    }
   
      function soma1(ParA, ParB){  
            $.ajax({
              method: 'post',
              url: 'RL/OrAddR1.php',
              data: {ncode: StringPura,
              p1: ParA,
              p2: ParB },
              success: function(retorno){
                adicionar1(retorno, true);

              }
            });     
      }
      function soma2(ParA, ParB){
       $.ajax({
              method: 'post',
              url: 'RL/OrAddR2.php',
              data: {ncode: StringPura,
              p1: ParA,
              p2: ParB },
              success: function(retorno){
                adicionar1(retorno, true);
              }
            });     
        }

        function adicionar1(valValor){
            var parte2; 
            StringPura = valValor;
            executado = true;
            var vseq = valValor.split("||");
            for(var i = 0; i < vseq.length; i++){

              var partes = vseq[i].split("|--");
              
              if(partes == vseq[i]) {
                 $("#div1").prepend(valValor+"<br> _____________________________o____________________<br>");
                break;
              }

              var esquerda = partes[0];
              var direita = partes[1];


              //LEFT
              
              var contextosL = esquerda.split(";");
              var classicoL = contextosL[0];
              var linearL = contextosL[1];
              var formulaL = linearL.slice(2, linearL.length-2);
              var sublinearL = formulaL.split(",");

              for(var j = 0; j < sublinearL.length; j++){
                  

                  var pedacos = sublinearL[j].split('#');                
                  
                  if(pedacos[0].match(/WITH/)){
                    var Operador = ' & ';
                    var Par1 = pedacos[1];
                    
                    var Par2 = pedacos[2];

                    var FormulaL = Par1+Operador+Par2;
   
                    stringPura = valValor.replace(sublinearL[j], FormulaL);

                    var stringB1 = criarBotao(Par1, Par2, Operador, 'ee');
              
                    esquerda = esquerda.replace(sublinearL[j], stringB1);
                 
                    

                  }  
              }
              $("#div1").prepend(esquerda + ' |-- ');



              //RIGHT

              var contextos = direita.split(";");
              var classico = contextos[0];
              var linear = contextos[1];
              var formula = linear.slice(2, linear.length-2);
              var sublinear = formula.split(",");
              for(var j = 0; j < sublinear.length; j++){
                  var pedacos = sublinear[j].split('#');                
                  
                  if(pedacos[0].match(/PLUS/)){
                    var Operador = ' + ';
                    var Par1 = pedacos[1];
                    
                    var Par2 = pedacos[2];

                    var Formula = Par1+Operador+Par2;
   
                    stringPura = valValor.replace(sublinear[j], FormulaL);

                    var stringB1 = criarBotao(Par1, Par2, Operador, 'soma');
              
                    direita = direita.replace(sublinear[j], stringB1);
                 
                  } 
              }              
            
            $("#div1").append(direita+"<br>_________________________________________________<br>");


            }
        }








    $(document).ready(function(){
        var palavra;
        var executado = false;
        //Aqui recebemos uma string que recebeu diversas EQ até chegar nesse ponto, pode ser uma RL ou uma EQ final.
        palavra = "<?php echo $codigo; ?>";
        verdadeiro = palavra;  
        adicionar1(palavra);
        
        if((palavra.match(/ERRO/)) && (executado == true) ) {
           
           $('#div1').prepend(palavra);
        }
         
    });
  </script>

</body>
</html>











  