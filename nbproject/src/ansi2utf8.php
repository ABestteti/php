<?php

if ($argc < 2) {
    print "PHP version: " . phpversion();
    exit('Quantidade de parametros insuficientes. Uso: ansi2utf8.php arquivo_origem arquivo_destino');
}

$inputFileName  = $argv[1];
$outputFileName = $argv[2];

if (file_exists($inputFileName)) {
    // Abre o arquivo de origem já o convertendo para UTF-8
    $inputXmlString = utf8_encode(file_get_contents($inputFileName));

    // Cria uma objeto XML a partir do conteúdo XML armanzenado na string
    // que armazena o XML lido do arquivo    
    $inputXml       = simplexml_load_string($inputXmlString);
} else {
    exit('Falha ao abrir o arquivo de origem ' . $inputFileName);
}

// Cria um objeto DOM a partir do XML
$dom_sxe = dom_import_simplexml($inputXml);

if (!$dom_sxe) {    
    exit('Não foi possível converter o arquivo lido ' . $inputFileName . ' para o formato DOM.');
}

// Cria o documento DOM que recebera como Node todo o XML armazenado na
// variavel $dom_sxe
$domDocument = new DOMDocument('1.0', 'utf-8');
$domDocument->formatOutput = true;

// Constroi todo o XML já no formato UTF-8
$dom_sxe = $domDocument->importNode($dom_sxe, true);
$dom_sxe = $domDocument->appendChild($dom_sxe);

// Salva o XML armazenado em memória no formato UTF-8
$domDocument->save($outputFileName);

?>