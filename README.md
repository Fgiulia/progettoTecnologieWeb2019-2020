# progettoTecnologieWeb2019-2020
Progetto didattico per il corso di Tecnologie Web a.a. 2019/2020 - Università degli Studi di Padova

File con le considerazioni generali in merito alla scelta iniziale dei linguaggi e della codifica

*****************************************************************************************************************************************************
*** XHTML ***

XHTML è migliore di HTML perchè:
	-> XHTML è HTML riformulato come XML quindi è più coerente e aiuta lo sviluppo di codice valido (questo elimina parte dei problemi di presentazione di HTML)
	-> essendo un linguaggio XML è interoperabile
	-> elimina il problema del code forking perché supportato da diversi tipi di dispositivi (browser, browser per dispositivi mobili, screen reader, vecchi browser (lo supportano abbastanza bene))
	-> inoltre l’uso degli standard Web porta i seguenti vantaggi: compatibilità con i browser, compatibilità con le future tecnologie, controllo centralizzato della presentazione, indipendenza dal dispositivo, migliore posizionamento nei motori di ricerca, pagine leggere, accessibilità, migliore posizionamento sul mercato come sviluppatore web

XHTML 1.0 Strict è la forma più pura che aiuta a produrre codice in cui struttura e presentazione sono fortemente separati
	-> svantaggi: non sempre supportato bene dai vecchi browser

prologo XML [<?xml version=“1.0” encoding=“ISO-8859-1”?>] SI o NO ??
	-> il W3C raccomanda di usare il prologo XML (opzionale) per specificare la versione XML e il tipo di codifica dei caratteri, purtroppo però molti browser non lo gestiscono correttamente, causando visualizzazioni scorrette o crash

*****************************************************************************************************************************************************
*** CHARSET UTF-8 ***

esistono diversi formati di conversione Unicode, i cosiddetti "UTF", che riproducono gli 1.114.112 punti di codice possibili
i formati che hanno prevalso sono tre: UTF-8, UTF-16 e UTF-32 (anche altre codifiche come UTF-7 o SCSU hanno i loro vantaggi, ma non si sono mai affermate)

UTF-8 è costituito da un massimo di quattro sequenze di bit, ciascuna delle quali è composta da 8 bit e per le lingue con alfabeto latino, questo formato
	-> garantisce un utilizzo più efficiente dello spazio di archiviazione (ciascun carattere proveniente dall'alfabeto latino è coperto da un byte)
	-> è progettato per consentire la coesistenza semplice e la copertura di diversi sistemi di scrittura
	-> permette la visualizzazione simultanea e sensata all'interno di un campo di testo senza problemi di compatibilità

*****************************************************************************************************************************************************
*** PROGETTAZIONE ***

Fasi della progettazione:
	Individuazione degli utenti e delle loro esigenze (analisi dei requisiti)
	Progettazione della base informativa (dati e informazioni)
	Progettazione delle funzionalità (applicazioni e servizi)
	Progettazione dell’organizzazione (accessibilità e usabilità)
	Progettazione grafica (interfaccia e stile)
	Progettazione fisica (strumenti e manutenzione)

La progettazione di un sito web è un’attività molto complessa, che tiene conto di diversi settori disciplinari -> il team di sviluppo comprende persone di diversa estrazione: Project Manager, Information Designer, Web Designer, Gruppo di esperti Informatici (reti, standard web, database, grafica), Responsabile Editoriale, Esperto in Marketing, Esperto in usabilità

*****************************************************************************************************************************************************

