<?php
$beansMaps = (Object) [
	/* questa assegnazione iniziale serve per inizializzare la mappa in modo che
	non lanci warning quando successivamente verranno inseriti i bean */
	//"BaseBean" => => null,
	"UtenteBean" => null
	
];
# BaseBean
/*
$beansMaps->BaseBean = (Object) [
	"dbh" => PDO
	,"sqlTableName" => "sqlTableName"
	,"sqlFieldsMap" => (Object) [
		"jsFiledName" => (Object) [
			"name" => "sqlFieldName"
			,"options" => (Object) [
				"type" => null | "date" | "base64"
			]
		]
	]
	,"pksMap" => [
		"sqlTableName" => (Object) [
			"name" => "jsFiledName"
			,"options" => (Object) [
				"autoincrement" => true | false
			]
		]
	]
]
*/

# UtenteBean
$beansMaps->BaseBean = (Object) [
	"dbh" => $dbh
	,"sqlTableName" => "Utenti"
	,"sqlFieldsMap" => (Object) [
		"Email" => (Object) [
			"name" => "Email"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Nome" => (Object) [
			"name" => "Nome"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Cognome" => (Object) [
			"name" => "Cognome"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Telefono" => (Object) [
			"name" => "Telefono"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Indirizzo" => (Object) [
			"name" => "Indirizzo"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Eta" => (Object) [
			"name" => "Eta"
			,"options" => (Object) [
				"type" => null
			]
		]
	]
	,"pksMap" => [
		"Email" => (Object) [
			"options" => (Object) [
				"autoincrement" => false
			]
		]
	]
]

?>