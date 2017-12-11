<?php
//Criado por Douglas Segatto
//O código com o maior número de POGs já visto.
set_time_limit(false);
header('Content-type: text/html; charset=iso-8859-1');
$numero_paginas = 11;
$nome = array();
$telefone = array();
//Bypass número telefone: Captura os 2 últimos digitos transformados em img. (sem ocr, sux me)
$convert_a = array(
	"6F" => "0",
	"6E" => "1",
	"6D" => "2",
	"6C" => "3",
	"6B" => "4",
	"6A" => "5",
	"69" => "6",
	"68" => "7",
	"67" => "8",
	"66" => "9"
);
$convert_b = array(
	"7D" => "0",
	"7C" => "1",
	"7F" => "2",
	"7E" => "3",
	"79" => "4",
	"78" => "5",
	"7B" => "6",
	"7A" => "7",
	"75" => "8",
	"74" => "9"
);

for ($y = 0; $y < $numero_paginas; $y++)
{
	echo $y;
	$lista = curl_init();
	curl_setopt_array($lista, array(
		CURLOPT_URL => "https://www.telelistas.net/mg/belo+horizonte/dentistas?pagina={$y}&randsort=-1",
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36",
		CURLOPT_RETURNTRANSFER => 1
	));
	$saida = curl_exec($lista);
	preg_match_all('/<td.*class=\"nome_resultado_ag\">\n<a.*\">\n([^<]+)<\/a>/', $saida, $nomes);
	preg_match_all('/<td.*class=\"text_resultado_ib\">\nTel:\s\(31\)\s(\d{4}\-\d{2})<img.*\.ashx\?t=(.{2})(.{2})/', $saida, $numeros);
	$index_of = count($nomes[0]);
	for ($i = 0; $i < $index_of - 1; $i++)
	{
		$nome[] = $nomes[1][$i] . "<br />";

		// echo $nomes[1][$i]."<br />";

		$telefone[] = "(31) {$numeros[1][$i]}{$convert_a[$numeros[2][$i]]}{$convert_b[$numeros[3][$i]]} <br /> <br /> ";

		// echo "(31) {$numeros[1][$i]}{$convert_a[$numeros[2][$i]]}{$convert_b[$numeros[3][$i]]} <br /> <br /> ";

	}
}

array_unique($nome);
array_unique($telefone);
?>
