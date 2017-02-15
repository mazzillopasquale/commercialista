<?php
$tipo=$_GET['tipo'];

if($tipo==1)
    creaNews();     

if($tipo==2)
    creaAvvisi();
        
if($tipo==3)
     modificaDati();

if($tipo==4)
   creaPratiche();


function creaNews()
{
    // inclusione del file della classe
    include "newsletter.php";
    // istanza della classe
    $news = new NewsletterClass();
    $news->settaDB();
    
    session_start();
    $_SESSION['pagina']=1;
    @$stato=$_SESSION['stato'];
    
    $cf=$_SESSION['codice_fiscale'];

    // interrogazione della tabella
    $auth = $news->elencaNewsUtente($cf);
    if($auth==null)
        echo("<HTML><HEAD></HEAD><BODY><H3 ALIGN='center'>Non è presente nessuna newsletter<BR></H3><BR>");
    else
        echo("<HTML><HEAD></HEAD><BODY><H3 ALIGN='center'>Elenco newsletter <BR></H3><BR>");
   
    $flag=false;
	while($flag==false)
    {
        @$it= mysql_fetch_array($auth);
        if($it!=null)
        {  
            $codice=$it[0];
            $news->settaNews($codice);
            $titolo = $news->getTitolo();
            $data=$news->getDataNews();
            $testo=$news->getTesto();
            $cod_ut=$news->getCodiceUtente();

            echo("<fieldset><DIV class='visualizza_padre'> 
            <H4  ALIGN='center'> $data $titolo </H4><H5 ALIGN='center'>$testo</H5></DIV></fieldset> <BR>");
        }
        else
            $flag=true;
	}
    
    echo("</BODY></HTML>");
        $_SESSION['stato']="";
}



function creaAvvisi()
{
    
    // inclusione del file della classe
    include "avviso.php";
    // istanza della classe
    $avviso = new AvvisoClass();
    $avviso->settaDB();
    
    session_start();
    $_SESSION['pagina']=2;
   

    // interrogazione della tabella
    $auth = $avviso->elencaAvvisi();
    if($auth==null)
        echo("<HTML><HEAD></HEAD><BODY><H3 ALIGN='center'>Non è presente nessun avviso<BR></H3><BR>");
    else
        echo("<HTML><HEAD></HEAD><BODY><H3 ALIGN='center'>Elenco avvisi <BR></H3><BR>");
   
    $flag=false;
	while($flag==false)
    {
        @$it= mysql_fetch_array($auth);
        if($it!=null)
        {  
            $codice=$it[0];
            $avviso->settaAvviso($codice);
            $titolo = $avviso->getTitolo();
            $data=$avviso->getDataAvviso();
            $testo=$avviso->getTesto();

            echo("<fieldset><DIV class='visualizza_padre'> 
            <H4  ALIGN='center'> $data $titolo </H4><H5 ALIGN='center'>$testo</H5></DIV></fieldset> <BR>");
        }
        else
            $flag=true;
	}
    
    
        $_SESSION['stato']="";
}

//funzione che crea nel form la parte riguardante i dati del commercialista
function modificaDati()
{
    // inclusione del file della classe
    include "utente.php";
    // istanza della classe
    $utente = new UtenteClass();
    //seleziono il database
    $utente->settaDB();
    //inizio una sessione
    session_start();
    //imposto come variabile della sessione pagina il valore 3, che indica che stiamo nella pagina relativa ai dati del commercialista
    $_SESSION['pagina']=3;
    //imposto la variabile stato con il valore contenuto nella variabile della sessione
    @$stato=$_SESSION['stato'];  
    //recupero il codice fiscale del commercialista dalla sessione
    $cf=$_SESSION['codice_fiscale'];
    //imposto il commercialista con il codice fiscale recuperato dalla sessione
    $utente->settaUtente($cf);
    //imposto le variabili del commercialista con le funzioni della classe commercialista
    $nome = $utente->getNome();
    $cognome = $utente->getCognome();
    $data_nascita = $utente->getDataDiNascita();
    $email = $utente->getEmail();
    $password = $utente->getPassword();
    $professione=$utente->getProfessione();
    $cf=$utente->getCodiceFiscale();
    //stampo il codice html relativo alla modifica dei dati del commercialista
    echo("<BR><fieldset><H3 ALIGN='center'>In questa sezione puoi visualizzare e modificre i tuoi dati personali</H3></fieldset><BR>");
    echo("<fieldset> <DIV align='center'> <BR> <FORM name='modifica' METHOD='POST' ACTION='operazioni.php'> 
        Modifica Codice fiscale:  <INPUT TYPE='text' name='codice_fiscale_modifica' value='$cf' required></INPUT> <BR> <BR> 
        Modifica Nome:  <INPUT TYPE='text' name='nome_modifica' value='$nome' required></INPUT> <BR> <BR> 
        Modifica Cognome:  <INPUT TYPE='text' name='cognome_modifica' value='$cognome' required></INPUT> <BR> <BR> 
        Modifica Professione:  <INPUT TYPE='text' name='professione_modifica' value='$professione' required></INPUT> <BR> <BR> 
        Modifica Data di nascita:  <INPUT TYPE='date' name='data_nascita_modifica' value='$data_nascita' required></INPUT> <BR> <BR> 
        Modifica E-mail:  <INPUT TYPE='text' name='email_modifica' value='$email' required></INPUT> <BR> <BR> 
        Inserisci la nuova password:  <INPUT TYPE='password' name='password_modifica' value='$password' required> </INPUT> <BR> <BR>
        <INPUT TYPE='submit' name='button' value='Modifica dati' ></INPUT>&nbsp &nbsp &nbsp &nbsp &nbsp 
        <INPUT TYPE='reset' value=' Ripristina '></INPUT> <BR><BR>
        <H3> $stato </H3>
        </FORM> </DIV> </fieldset> <BR>");
    //inizializzo la variabile stato della sessione
    $_SESSION['stato']="";
}

//funzione che crea nel form la parte riguardante le pratiche
function creaPratiche()
{
    // inclusione del file della classe
    include "pratica.php";
    // istanza della classe
    $pratica = new PraticaClass();
    //seleziono il database
    $pratica->settaDB();
    //inizio una sessione
    session_start();
    //imposto come variabile della sessione pagina il valore 4, che indica che stiamo nella pagina relativa alle pratiche
    $_SESSION['pagina']=4;
    //recupero il codice fiscale dell'utente dalla sessione
    $cf=$_SESSION['codice_fiscale'];
    // interrogazione della tabella
    $auth = $pratica->elencaPraticheCliente($cf);
    //controllo se il risultato della query è vuoto
    if($auth==null)
        echo("<H3 ALIGN='center'>Non è presente nessuna pratica<BR></H3><BR>");
    else
        echo("<H3 ALIGN='center'>Elenco Pratiche <BR></H3><BR>");
    //imposto una variabile booleana utile ad uscire dal ciclo che elenca le news
    $flag=false;
    //ciclo fin quando la variabile flag non diventa vera
	while($flag==false)
    {
        //inizializzo la variabile it con il risultato della query in formato di array
        @$it= mysql_fetch_array($auth);
        //controllo se la variabile contenente il risultato della query non è vuota
        if($it!=null)
        {  
            //inizializzo la variabile codice con il risultato della query
            $codice=$it[0];
            //imposto le variabili della pratica con le funzioni della classe pratica
            $pratica->settaPratica($codice);
            $cliente = $pratica->getCodiceCliente();
            $data=$pratica->getDataPratica();
            $testo=$pratica->getTesto();
            $stato=$pratica->getStato();
            //stampo il cdice html relativo alla visualizzazione della pratica
            echo("<fieldset><DIV class='visualizza_padre' ALIGN='center'> 
            <DIV class='visualizza_sin' ALIGN='center'>
            <H4> $data $stato </H4> <H5> $testo </H5> </DIV>
            <DIV class='visualizza_des' ALIGN='center'>
            <FORM METHOD='POST' ACTION='operazioni.php'>
            <INPUT TYPE='hidden' name='codice_pratica' value=$codice> </INPUT></FORM> </DIV> </DIV> </fieldset> <BR>");
        }
        //se il valore della variabile contenente il risultato della query imposto la variabile flag vera
        else
            $flag=true;
	}
    
        //inizializzo la variabile stato della sessione
        $_SESSION['stato']="";
}


?>