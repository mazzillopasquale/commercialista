<?php
//inizio una sessione
session_start();
//recupero i valori delle variabili salvate nella sessione
@$codFis=$_SESSION['codice_fiscale'];
@$pagina=$_SESSION['pagina'];
if($pagina==null)
    $pagina=2;
// inclusione del file della classe
include "commercialista.php";
// istanza della classe
$comm = new CommercialistaClass();
//setto il database
$comm->settaDB();
// richiamo la funzione che imposta il commercialista che ha come codice fiscale la variabile recuperata in precedenza
$comm->settaCommercialista($codFis);
// recupero dei valori nome e cognome
$nome = $comm->getNome();
$cognome = $comm->getCognome();

?>
<HTML>
	<HEAD>
		<TITLE> Commercialista </TITLE>
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
        //stampo il nome e il cognome del commercialista
        echo "Commercialista: $nome  $cognome "; 
        ?>
        
	<INPUT TYPE='submit' name='button' id='button_esci' value='Esci' > </INPUT>
	</FORM> 
	</DIV> </DIV>
         <SCRIPT>
            //come pagina iniziale imposto la pagina recuperata in precedenza dalla sessione
            createTableRis(<?php echo($pagina);?>,1);
        </SCRIPT>

	<DIV class='padre_sotto'>
	
	<DIV class='sinistra_sotto_com'  ALIGN=left>
        
        <FORM name='barra_utente' METHOD='GET' >
	        <INPUT TYPE='button' id='button' name='button_commercialista_newsletter' value='Newsletter' onclick='createTableRis(1,1)'> </INPUT> <BR><BR>
            <INPUT TYPE='button' id='button' name='button_commercialista_avvisi' value='Avvisi' onClick='createTableRis(2,1)'> </INPUT> <BR><BR>
            <INPUT TYPE='button' id='button' name='button_commercialista_pratica' value='Pratiche' onClick='createTableRis(4,1)'> </INPUT> <BR> <BR>
            <INPUT TYPE='button' id='button' name='button_commercialista_clienti' value='Clienti' onClick='createTableRis(7,1)'> </INPUT> <BR> <BR>
            <INPUT TYPE='button' id='button' name='button_commercialista_modifica' value='<?php echo("$nome");?>' onClick='createTableRis(3,1)'> </INPUT> <BR><BR>
	</FORM>  
	</DIV>
	<DIV class='destra_sotto' ALIGN=right id='risposte' >
	</DIV>
	</DIV>
	

	</BODY>
</HTML>
            