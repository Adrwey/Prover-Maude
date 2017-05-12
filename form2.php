<html>
<head>

</head>
<body>

<?php
//Código recebido
	$code = $_POST['ncode'];
	$code2 = "load am7ll . 
	 ". $code;

	$tmpfname = tempnam("/var/www/html/Prover", 'MAUDE');
	$arquivo = fopen($tmpfname, 'w');
	fwrite($arquivo, $code2);
	fclose($arquivo);

	exec("maude -no-banner ".$tmpfname, $output);
	echo $ue;
	for($i = 0; $i <= count($output); $i++){
	          
	          echo $output[$i];
	 }
	unlink($tmpfname);
 // echo $output[0];
?>
</body>
</html>








