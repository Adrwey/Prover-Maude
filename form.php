<html>
<head>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

  

</head>
<body>
<?php
//Código recebido
$code = $_POST['ncode'];

  $code2 = "load am7ll .
            red MetaReduce " . $code ." in 'am7ll .";


  $tmpfname = tempnam("/var/www/html/Prover", 'MAUDE');


  $arquivo = fopen($tmpfname, 'w'); 
  fwrite($arquivo, $code2);
  fclose($arquivo);



exec("maude -no-banner ".$tmpfname, $output);

for($i = 0; $i <= count($output); $i++){
          if(strpos($output[$i], "Sequente:") > 0){

          
          echo " <div id='div1'>  </div>";
          $codigo = substr($output[$i], 17, strlen($output[$i]));
          //echo "<button id='button1'>AA</button>";
          //$posicao = strstr($output[$i], "Sequente:");
          
          //echo "<b id='codigo'>".$codigo."</b>";
          echo "<br><br>";
          }
          //echo "<b>".$output[$i]."</b> <br> <br>";
          
        }

unlink($tmpfname);


//applying 'OrAddR1
?>

<script type="text/javascript">
    var verdadeiro, valValor;
    var varVari = false, ee = false;
    
    function ee1(){
      
       $.ajax({
              method: 'post',
              url: 'RL/AndAddL1.php',
              data: {ncode: verdadeiro },
              success: function(retorno){
                adicionar1(retorno, true);
              }
            }); 
    }

    function ee2(){
       $.ajax({
              method: 'post',
              url: 'RL/AndAddL2.php',
              data: {ncode: verdadeiro },
              success: function(retorno){
                adicionar1(retorno, true);
              }
            }); 
    }

    function do_something(){
        alert("AAAAAAAAAA");
      }
      function soma1(){  
            $.ajax({
              method: 'post',
              url: 'RL/OrAddR1.php',
              data: {ncode: verdadeiro },
              success: function(retorno){
                //$('#div1').html(retorno);
                //$('#div1').prepend(retorno+"<br>__________________________________________________________<br>");
                adicionar1(retorno, true);

              }
            });     
      }
      function soma2(){
       $.ajax({
              method: 'post',
              url: 'RL/OrAddR2.php',
              data: {ncode: verdadeiro },
              success: function(retorno){
                //$('#div1').html(retorno);   [C',G] ; {empty} |-- [D'] ; {F}
                //$('#div1').prepend(retorno+"<br>__________________________________________________________<br>");
                adicionar1(retorno, true);
              }
            });     
        }
      function adicionar1(valValor, varVari){
            var cont = 0;
            var vseq = valValor.split("||");

            for(var i = 0; i < vseq.length; i++){
              //alert(vseq[i]);
               var partes = vseq[i].split("|--");
               if(partes == vseq[i]) {
                //alert("Estou entrando no IF!!!");
                 $("#div1").prepend(valValor+"<br> __________________________________________________<br><br>");
                break;
              }
               var antes = partes[0];

               var depois = partes[1];

               // LEFT
               var contextosL = antes.split(";");
               var classicoL = contextosL[0];
               var linearL = contextosL[1];
               var formulaL = linearL.slice(2, linearL.length-2);
               var sublinearL = formulaL.split(",");
               
               //RIGHT
               var contextos = depois.split(";");
               var classico = contextos[0];// contexto classico [... ]
               var linear = contextos[1]; // contexto linear {... }
               var formula = linear.slice(2,linear.length-2);
               var sublinear = formula.split(",");
                 //alert(sublinear);
               
                 
                   for (var i = 0; i < sublinearL.length; i++) { 


                       if(sublinearL[i].match(/\D?\D?\D?\D?\D?\D?&\D?\D?\D?\D?\D?\D?\D?/ig)) {
                         ee = true;
                         
                          var PosOp = sublinearL[i].indexOf("&");
                          var Operador = sublinearL[i].slice(PosOp, PosOp+1);
                          var PriOP = sublinearL[i].slice(0, PosOp);
                          var SegOP = sublinearL[i].slice(PosOp+1, sublinearL[i].length);
                          
                          var palavra2 = valValor.replace(sublinearL[i], "<button class='e1' >"+PriOP+"</button>"+Operador+"<button class='e2'>"+SegOP+"</button>");
                           //$("#button1").click(function(){
                              //$("#div1").append(palavra1);
                              var comOp1 = palavra2.indexOf("<button");
                              var fimOp1 = palavra2.indexOf("/button>")+8;
                              var comOp2 = palavra2.lastIndexOf("<button");
                              var fimOp2 = palavra2.lastIndexOf("/button>")+8;
                              var parte1 = "<br>"+palavra2.slice(0,comOp1);
                              var Op1 = palavra2.slice(comOp1,fimOp1);
                              

                              
                              const newBtn3 = $(Op1);
                              newBtn3.click(ee1);
                              var Op = palavra2.slice(fimOp1,comOp2);
                              var Op2 = palavra2.slice(comOp2,fimOp2);


                              const newBtn4 = $(Op2);
                              newBtn4.click(ee2);
                              var parte2 = palavra2.slice(fimOp2, palavra2.length)+"<br> ___________________________________________<br>"; 
                              $("#div1").prepend(parte1, newBtn3, Op, newBtn4, parte2);

                      }
                   }

              

                 for (var i = 0; i <= sublinear.length; i++) {
                  
                  if(sublinear[i].match(/~\D?\(\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\)/ig)){
                    //alert(sublinear[i]);
                    //alert(palavra.lastIndexOf(sublinear[i]));
                    var chapeu = sublinear[i].indexOf("~");
                    var parens = sublinear[i].indexOf("(");
                    
                    var corte1 = sublinear[i].slice(chapeu,parens+1);
                    var corte2 = sublinear[i].slice(parens, sublinear[i].length);
                    
                    

                    palavra1 = valValor.replace(sublinear[i], "<button class='negacao' >"+corte1+"</button>"+corte2);

                    //alert(palavra1);
                     //$("#button1").click(function(){
                        //$("#div1").append(palavra1);
                        var comeco = palavra1.indexOf("<button");
                        var fim = palavra1.indexOf("/button>");
                        var cut1 = palavra1.slice(0,comeco);
                        var Op = palavra1.slice(comeco,fim+7);
                        const newBtn = $(Op);
                        newBtn.click(do_something);

                        var cut3 = palavra1.slice(fim+8, palavra1.length);
                        $("#div1").append(cut1);
                        $("#div1").append(newBtn);
                        $("#div1").append(cut3);
                        alert("estou no ~");

                       // });
                        
                      break;
                  }
                  else if(sublinear[i].match(/\(\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\D?\)/ig)){
                    alert("AINDA EM CONSTRUCAO!");

                    
                  }
                  else if(sublinear[i].match(/\D?\D?\D?\+\D?\D?\D?\D?/ig)){
                    
                    var PosOp = sublinear[i].indexOf("+");
                    var Operador = sublinear[i].slice(PosOp, PosOp+1);
                    var PriOP = sublinear[i].slice(0, PosOp);
                    var SegOP = sublinear[i].slice(PosOp+1, sublinear[i].length);
                    
                    palavra2 = valValor.replace(sublinear[i], "<button class='soma1' >"+PriOP+"</button>"+Operador+"<button class='soma2'>"+SegOP+"</button>");
                     //$("#button1").click(function(){
                        //$("#div1").append(palavra1);
                        var comOp1 = palavra2.indexOf("<button");
                        var fimOp1 = palavra2.indexOf("/button>")+8;
                        var comOp2 = palavra2.lastIndexOf("<button");
                        var fimOp2 = palavra2.lastIndexOf("/button>")+8;
                        var parte1 = "<br>"+palavra2.slice(0,comOp1);
                        var Op1 = palavra2.slice(comOp1,fimOp1);
                        const newBtn1 = $(Op1);
                        newBtn1.click(soma1);
                        var Op = palavra2.slice(fimOp1,comOp2);
                        var Op2 = palavra2.slice(comOp2,fimOp2);


                        const newBtn2 = $(Op2);
                        newBtn2.click(soma2);
                        var parte2 = palavra2.slice(fimOp2, palavra2.length);
                        
                        $("#div1").prepend(parte1, newBtn1, Op, newBtn2, parte2);
            
                  }
                  else{
                    if(ee == true) {
                      ee = false;
                      break;
                    }
                    if(varVari == true){
                      varVari = false;
                      cont = 0;
                    }
                    cont = cont + 1; 
                    if(cont == 2) {
                      
                        $("#div1").prepend(valValor+"<br> __________________________________________________<br><br>");    
                      }

                    
                    }
                  

                 }
            }
          }



    $(document).ready(function(){
    
      /* Seu código aqui */
        
        var palavra = "<?php echo $codigo; ?>";
        
        verdadeiro = palavra;
        adicionar1(palavra);
        
        
         
    });
  </script>

</body>
</html>








