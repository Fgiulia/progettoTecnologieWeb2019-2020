<?php
$beansMaps = (Object) [
	/* questa assegnazione iniziale serve per inizializzare la mappa in modo che
	non lanci warning quando successivamente verranno inseriti i bean */
	//"BaseBean" => => null,
	"UtenteBean" => null,
	"BigliettoBean" => null,
	"EventoBean" => null,
	"BigliettoUtenteBean" => null,
	"EventoUtenteBean" => null,
	"AnimaleBean" => null,
	
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
$beansMaps->UtenteBean = (Object) [
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
		,"DataNascita" => (Object) [
			"name" => "DataNascita"
			,"options" => (Object) [
				"type" => "date"
			]
		]
		,"FlAdmin" => (Object) [
			"name" => "FlAdmin"
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
];

# BigliettoBean
$beansMaps->BigliettoBean = (Object) [
	"dbh" => $dbh
	,"sqlTableName" => "Biglietti"
	,"sqlFieldsMap" => (Object) [
		"Tipo" => (Object) [
			"name" => "Tipo"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Prezzo" => (Object) [
			"name" => "Prezzo"
			,"options" => (Object) [
				"type" => null
			]
		]
	]
	,"pksMap" => [
		"Tipo" => (Object) [
			"options" => (Object) [
				"autoincrement" => false
			]
		]
	]
];

# EventoBean
$beansMaps->EventoBean = (Object) [
	"dbh" => $dbh
	,"sqlTableName" => "Eventi"
	,"sqlFieldsMap" => (Object) [
		"ID" => (Object) [
			"name" => "ID"
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
		,"Prezzo" => (Object) [
			"name" => "Prezzo"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Data" => (Object) [
			"name" => "Data"
			,"options" => (Object) [
				"type" => "date"
			]
		]
		,"Giorno" => (Object) [
			"name" => "Giorno"
			,"options" => (Object) [
				"type" => null
			]
		]
	]
	,"pksMap" => [
		"ID" => (Object) [
			"options" => (Object) [
				"autoincrement" => true
			]
		]
	]
];

# BigliettoUtenteBean
$beansMaps->BigliettoUtenteBean = (Object) [
	"dbh" => $dbh
	,"sqlTableName" => "BigliettiUtenti"
	,"sqlFieldsMap" => (Object) [
		"NumeroOrdine" => (Object) [
			"name" => "NumeroOrdine"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Utente" => (Object) [
			"name" => "Utente"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"NumGratis" => (Object) [
			"name" => "NumGratis"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"NumRidotti" => (Object) [
			"name" => "NumRidotti"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"NumInteri" => (Object) [
			"name" => "NumInteri"
			,"options" => (Object) [
				"type" => null
			]
		]
	]
	,"pksMap" => [
		"NumeroOrdine" => (Object) [
			"options" => (Object) [
				"autoincrement" => true
			]
		]
	]
];

# EventoUtenteBean
$beansMaps->EventoUtenteBean = (Object) [
	"dbh" => $dbh
	,"sqlTableName" => "EventiUtenti"
	,"sqlFieldsMap" => (Object) [
		"NumeroPrenotazione" => (Object) [
			"name" => "NumeroPrenotazione"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Utente" => (Object) [
			"name" => "Utente"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"NumeroPersone" => (Object) [
			"name" => "NumeroPersone"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"IDEvento" => (Object) [
			"name" => "IDEvento"
			,"options" => (Object) [
				"type" => null
			]
		]
	]
	,"pksMap" => [
		"NumeroPrenotazione" => (Object) [
			"options" => (Object) [
				"autoincrement" => true
			]
		]
	]
];

# AnimaleBean
$beansMaps->AnimaleBean = (Object) [
	"dbh" => $dbh
	,"sqlTableName" => "Animali"
	,"sqlFieldsMap" => (Object) [
		"NomeComune" => (Object) [
			"name" => "NomeComune"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"NomeProprio" => (Object) [
			"name" => "NomeProprio"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"NomeScientifico" => (Object) [
			"name" => "NomeScientifico"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Famiglia" => (Object) [
			"name" => "Famiglia"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"SezioneParco" => (Object) [
			"name" => "SezioneParco"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Descrizione" => (Object) [
			"name" => "Descrizione"
			,"options" => (Object) [
				"type" => null
			]
		]
		,"Ritratto" => (Object) [
			"name" => "Ritratto"
			,"options" => (Object) [
				"type" => null
			]
		]
	]
	,"pksMap" => [
		"NomeComune" => (Object) [
			"options" => (Object) [
				"autoincrement" => false
			]
		]
	]
];
?>
