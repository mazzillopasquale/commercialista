<?php
//inizio una sessione
session_start();
//recupero i valori delle variabili salvate nella sessione
$codFis=$_SESSION['codice_fiscale'];
@$pagina=$_SESSION['pagina'];
if($pagina==null)
    $pagina=2;
// inclusione del file della classe
include "utente.php";
// istanza della classe
$utente = new UtenteClass();
//seleziono il database
$utente->settaDB();
// richiamo la funzione che imposta l'utente che ha come codice fiscale la variabile recuperata in precedenza
$utente->settaUtente($codFis);
// recupero dei valori nome e cognome
$nome = $utente->getNome();
$cognome = $utente->getCognome();
?>
<HTML>
	<HEAD>
		<TITLE>
		Commercialista
                  

		</TITLE>
        <SCRIPT type='text/javascript' src='funzioni.js'></SCRIPT>	
        <LINK rel='stylesheet' href='stile_utenti.css'>
             <link rel="stylesheet" type="text/css" href="bootstrap.css">
	</HEAD>
	<BODY>
	<DIV class='padre_sopra'>
	<DIV class='sinistra_sopra_u' ALIGN=left> 
	<H2>  Commercialista Ferrara</H2>
	</DIV>
	<DIV class='destra_sopra_u' title='esci' ALIGN=right > <P>
	<FORM ACTION='autenticazione.php' METHOD='POST'>
        <?php 
        //stampo il nome e il cognome dell'utente
        echo "Utente: $nome  $cognome "; 
        ?>
	<INPUT TYPE='submit' name='button' value='Esci' > </INPUT>
	</FORM> 
	</DIV> </DIV>
         <SCRIPT>
            //come pagina iniziale imposto la pagina recuperata in precedenza dalla sessione
            createTableRis(<?php echo($pagina);?>,2); 
        </SCRIPT>

	<DIV class='padre_sotto'>
	
	<DIV class='sinistra_sotto'  ALIGN=left>
        
        <FORM name='barra_utente' METHOD='GET' >
	        <INPUT TYPE='button' id='button' name='button_utente_newsletter' value='Newsletter' onclick='createTableRis(1,2)'> </INPUT> <BR><BR>
            <INPUT TYPE='button' id='button' name='button_utente_avvisi' value='Avvisi' onClick='createTableRis(2,2)'> </INPUT> <BR><BR>
            <INPUT TYPE='button' id='button' name='button_utente_pratica' value='Pratiche' onClick='createTableRis(4,2)'> </INPUT> <BR> <BR>
            <INPUT TYPE='button' id='button' name='button_utente_modifica' value='<?php echo("$nome"); ?>' onClick='createTableRis(3,2)'> </INPUT> <BR><BR>
	</FORM> 
        
	</DIV>
	
	
	<DIV class='destra_sotto' ALIGN=right id='risposte' >
       
        
	
	</DIV>
	</DIV>
	

	</BODY>
</HTML>