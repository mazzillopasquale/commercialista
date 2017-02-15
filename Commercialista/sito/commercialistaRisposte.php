<?php
//recupero il valore della variabile tipo
$tipo=$_GET['tipo'];
//controllo il valore della variabile tipo e eseguo una funzione in base al suo valore
if($tipo==1)
    creaNews();     
if($tipo==2)
    creaAvvisi();   
if($tipo==3)
    creaModificaDati();
if($tipo==4)
   creaPratiche();
if($tipo==5)
    modAvviso();
if($tipo==6)
    modNews();
if($tipo==7)
    creaClienti();

//funzione che crea nel form la parte riguardante le newsletter
function creaNews()
{
    // inclusione del file della classe
    include "newsletter.php";
    // istanza della classe
    $news = new NewsletterClass();
    //seleziono il database
    $news->settaDB();
    //inizio una sessione
    session_start();
    //imposto come variabile della sessione pagina il valore 1, che indica che stiamo nella pagina relativa alle newsletter
    $_SESSION['pagina']=1;
    //imposto la variabile stato con il valore contenuto nella variabile della sessione
    @$stato=$_SESSION['stato'];
    //stampo il codice html relativo all'aggiunta di una newsletter
    echo("  <H4 ALIGN='center'> $stato </H4>
            <fieldset> 
            <DIV class='aggiungi' ALIGN='center'>
            <H3 ALIGN='center'> Aggiungi newsletter </H3>   
            <DIV class='aggiungi_sinistra' ALIGN='right'> 
            <FORM id='aggiungi_news' METHOD='POST' ACTION='operazioni.php'><BR>
            Aggiungi titolo newsletter: <INPUT TYPE='text' name='titolo_news' required> </INPUT> <BR> <BR>
            Aggiungi codice cliente: <INPUT TYPE='text' name='cod_utente_news' required> </INPUT> <BR>  <BR>     
            Aggiungi data: <INPUT TYPE='date' name='data_news' required> </INPUT> <BR>    </DIV>
            <DIV class='aggiungi_destra' ALIGN='center'>    
            Scrivi qui il testo della newsletter <textarea name='testo_news' form='aggiungi_news' rows='5' cols='60' required></textarea> <BR>
            <BR> <INPUT TYPE='submit' name='button' value='Aggiungi Newsletter' ></INPUT>&nbsp &nbsp &nbsp &nbsp &nbsp 
            <INPUT TYPE='reset' value=' Ripristina '> </INPUT> </DIV> </FORM>   </DIV></fieldset> <BR><BR>   ");

    // interrogazione della tabella
    $auth = $news->elencaNews();
    //controllo se il risultato della query è vuoto
    if($auth==null)
        echo("<H3 ALIGN='center'>Non è presente nessuna newsletter</H3><BR><BR>");
    else
        echo("<H3 ALIGN='center'>Elenco newsletter </H3><BR><BR>");
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
            //imposto le variabili delle newsletter con le funzioni della classe newsletter
            $news->settaNews($codice);
            $titolo = $news->getTitolo();
            $data=$news->getDataNews();
            $testo=$news->getTesto();
            $cod_ut=$news->getCodiceUtente();
            //stampo il cdice html relativo alla visualizzazione della newlsetter
            echo("<fieldset><DIV class='visualizza_padre' ALIGN='center'> 
            <DIV class='visualizza_sin' ALIGN='center'>
            <H4> $data $titolo $cod_ut</H4><H5>$testo</H5></DIV>
            <DIV class='visualizza_des' ALIGN='center'>
            <FORM METHOD='POST' ACTION='operazioni.php'>
            <INPUT TYPE='hidden' name='codice_news' value=$codice></INPUT>
            <INPUT TYPE='submit' name='button' value='Elimina Newsletter'></INPUT></FORM>
            <FORM METHOD='POST' ACTION='operazioni.php'>  
             <INPUT TYPE='hidden' name='codice_news' value=$codice></INPUT>
             <INPUT TYPE='submit' name='button' value='Modifica Newsletter'>  </INPUT></FORM></DIV></DIV></fieldset> <BR>");
        }
        //se il valore della variabile contenente il risultato della query imposto la variabile flag vera
        else
            $flag=true;
	}
    
        //inizializzo la variabile stato della sessione
        $_SESSION['stato']="";
}

//funzione che crea nel form la parte riguardante la modifica delle newsletter
function modNews()
{
    //inizio una sessione
    session_start();
    //imposto la variabile cod con il valore della variabile codice_news della sessione
    $cod=$_SESSION['codice_news'];
    //imposto la variabile pagina della sessione uguale a 6 che indica la modifica di una newsletter
    $_SESSION['pagina']=6;
     //imposto la variabile stato con il valore della variabile stato della sessione
    @$stato=$_SESSION['stato'];
    // inclusione del file della classe
    include "newsletter.php";
    // istanza della classe
    $news = new NewsletterClass();
    //funzione della classe newsletter che selezione il database
    $news->settaDB();
    //funzione che seleziona la newsletter con il codice $cod
    $news->settaNews($cod);
    //setto le variabili con i valori della newsletter selezionata in precedenza
    $codice=$news->getCodice();
    $titolo=$news->getTitolo();
    $data=$news->getDataNews();
    $testo=$news->getTesto();
    $cod_ut=$news->getCodiceUtente();    
    //stampo il codice html relativo alla visualizzazione nel form della modifica della newsletter
    echo("<HTML><HEAD></HEAD><BODY>
              <H4 ALIGN='center'> $stato </H4>
            <DIV class='aggiungi'>
            <H3 ALIGN='center'>Modifica Newsletter $titolo a: $cod_ut</H3>
            <DIV class='aggiungi_sinistra' ALIGN='right'>    
            <fieldset> 
                <FORM id='aggiungi_news' METHOD='POST'  ACTION='operazioni.php'>
            <BR> modifica titolo news: <INPUT TYPE='text' name='titolo_news' value='$titolo' required> </INPUT> <BR> <BR>
            modifica data: <INPUT TYPE='date' name='data_news' value='$data' required></INPUT> <BR>    </DIV>
            <DIV class='aggiungi_destra' ALIGN='center'>    
            Scrivi qui il testo della news <textarea name='testo_news' form='aggiungi_news' rows='5' cols='60' value='$testo' required></textarea> <BR>
            <INPUT TYPE='hidden' name='codice_news' value=$codice></INPUT>
            <BR> <INPUT TYPE='submit' name='button' value='Modifica newsletter' ></INPUT>&nbsp &nbsp &nbsp &nbsp &nbsp 
            <INPUT TYPE='reset' value=' Ripristina '></INPUT></FORM><BR> </DIV>  </fieldset>  </DIV><BR><BR>      </BODY></HTML>");
}

//funzione che crea nel form la parte riguardante le newsletter
function creaAvvisi()
{
    // inclusione del file della classe
    include "avviso.php";
    // istanza della classe
    $avviso = new AvvisoClass();
    //funzione che seleziona il database
    $avviso->settaDB();
    //inizio una sessione
    session_start();
    //imposto come variabile della sessione pagina il valore 2, che indica che stiamo nella pagina relativa agli avvisi
    $_SESSION['pagina']=2;
    //imposto la variabile stato con il valore contenuto nella variabile della sessione
    @$stato=$_SESSION['stato'];
    //stampo il codice html relativo all'aggiunta di un nuovo avviso
    echo("<HTML><HEAD></HEAD><BODY>
             <H4 ALIGN='center'> $stato </H4>
            <DIV class='aggiungi'>
            <H3 ALIGN='center'>Aggiungi avviso </H3>
            <DIV class='aggiungi_sinistra' ALIGN='right'>    
            <fieldset> 
                <FORM id='aggiungi_avviso' METHOD='POST'  ACTION='operazioni.php'>
            <BR> Aggiungi titolo avviso: <INPUT TYPE='text' name='titolo_avviso' required> </INPUT> <BR> <BR>
                Chi puo' visualizzare l'avviso: 
            <select name='visibilita_avviso' required>
                <option SELECTED value='tutti' >Tutti</option>
                <option value='utenti'>Iscritti al sito</option> </select><BR> <BR>
            Aggiungi data: <INPUT TYPE='date' name='data_avviso' required></INPUT> <BR>    </DIV>
            <DIV class='aggiungi_destra' ALIGN='center'>    
            Scrivi qui il testo dell'avviso <textarea name='testo_avviso' form='aggiungi_avviso' rows='5' cols='60' required></textarea> <BR>
            <BR> <INPUT TYPE='submit' name='button' value='Aggiungi Avviso' ></INPUT>&nbsp &nbsp &nbsp &nbsp &nbsp 
            <INPUT TYPE='reset' value=' Ripristina '></INPUT></FORM><BR> </DIV>  </fieldset>  </DIV><BR><BR>      </BODY></HTML>");
    // interrogazione della tabella
    $auth = $avviso->elencaAvvisi();
    //controllo se il risultato della query è vuoto
    if($auth==null)
        echo("<H3 ALIGN='center'>Non è presente nessun avviso<BR></H3><BR>");
    else
        echo("<H3 ALIGN='center'>Elenco avvisi <BR></H3><BR>");
    //imposto una variabile booleana utile ad uscire dal ciclo che elenca gli avvisi
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
            //imposto le variabili dell'avviso con le funzioni della classe avviso
            $avviso->settaAvviso($codice);
            $titolo = $avviso->getTitolo();
            $data=$avviso->getDataAvviso();
            $testo=$avviso->getTesto();
            //stampo il cdice html relativo alla visualizzazione dell'avviso
            echo("<fieldset><DIV class='visualizza_padre' ALIGN='center'> 
            <DIV class='visualizza_sin' ALIGN='center'>
            <H4> $data $titolo</H4><H5>$testo</H5></DIV>
            <DIV class='visualizza_des' ALIGN='center'>
            <FORM METHOD='POST' ACTION='operazioni.php'>
            <INPUT TYPE='hidden' name='codice_avviso' value=$codice></INPUT>
            <INPUT TYPE='submit' name='button' value='Elimina Avviso'></INPUT></FORM>
            <FORM METHOD='POST' ACTION='operazioni.php'>  
             <INPUT TYPE='hidden' name='codice_avviso' value=$codice></INPUT>
             <INPUT TYPE='submit' name='button' value='Modifica Avviso'>  </INPUT></FORM></DIV></DIV></fieldset> <BR>");
        }
        //se il valore della variabile contenente il risultato della query imposto la variabile flag vera
        else
            $flag=true;
	}
        //inizializzo la variabile stato della sessione
        $_SESSION['stato']="";
}

//funzione che crea nel form la parte riguardante la modifica delle newsletter
function modAvviso()
{
    //inizio una sessione
    session_start();
    //imposto la variabile cod con il valore della variabile codice_avviso della sessione
    $cod=$_SESSION['codice_avviso'];
    //imposto la variabile pagina della sessione uguale a 5 che indica la modifica di un avviso
    $_SESSION['pagina']=5;
    //imposto la variabile stato con il valore della variabile stato della sessione
    @$stato=$_SESSION['stato'];
    // inclusione del file della classe
    include "avviso.php";
    // istanza della classe
    $avviso = new AvvisoClass();
    //funzione della classe avviso che selezione il database
    $avviso->settaDB();
    //funzione che seleziona l'avviso con il codice $cod
    $avviso->settaAvviso($cod);
    //setto le variabili con i valori dell'avviso selezionata in precedenza
    $codice=$avviso->getCodice();
    $titolo=$avviso->getTitolo();
    $data=$avviso->getDataAvviso();
    $testo=$avviso->getTesto();
    //stampo il codice html relativo alla visualizzazione nel form della modifica della newsletter
    echo("<HTML><HEAD></HEAD><BODY>
             <H4 ALIGN='center'> $stato </H4>
            <DIV class='aggiungi'>
            <H3 ALIGN='center'>Modifica Avviso $titolo</H3>
            <DIV class='aggiungi_sinistra' ALIGN='right'>    
            <fieldset> 
                <FORM id='aggiungi_avviso' METHOD='POST'  ACTION='operazioni.php'>
            <BR> Aggiungi titolo avviso: <INPUT TYPE='text' name='titolo_avviso' value='$titolo' required> </INPUT> <BR> <BR>
                Chi puo' visualizzare l'avviso: 
            <select name='visibilita_avviso' required>
                <option SELECTED > seleziona visibilità</option>
                <option value='tutti' >Tutti</option>
                <option value='utenti'>Iscritti al sito</option> </select><BR> <BR>
            Aggiungi data: <INPUT TYPE='date' name='data_avviso' value='$data' required></INPUT> <BR>    </DIV>
            <DIV class='aggiungi_destra' ALIGN='center'>    
            Scrivi qui il testo dell'avviso <textarea name='testo_avviso' form='aggiungi_avviso' rows='5' cols='60' value='$testo' required></textarea> <BR>
            <INPUT TYPE='hidden' name='codice_avviso' value=$codice></INPUT>
            <BR> <INPUT TYPE='submit' name='button' value='Modifica avviso' ></INPUT>&nbsp &nbsp &nbsp &nbsp &nbsp 
            <INPUT TYPE='reset' value=' Ripristina '></INPUT></FORM><BR> </DIV>  </fieldset>  </DIV><BR><BR>      </BODY></HTML>");
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
    //imposto la variabile stato con il valore contenuto nella variabile della sessione
    @$stato=$_SESSION['stato'];
    //stampo il codice html relativo all'aggiunta di una pratica
    echo("<HTML><HEAD></HEAD><BODY>
            <H4 ALIGN='center'> $stato </H4>
            <DIV class='aggiungi'>
            <H3 ALIGN='center'>Aggiungi pratica </H3>
            <DIV class='aggiungi_sinistra' ALIGN='right'>    
            <fieldset> 
                <FORM id='aggiungi_pratica' METHOD='POST'  ACTION='operazioni.php'>
            <BR> Seleziona stato pratica: 
            <select name='stato_pratica' required>
                <option SELECTED value='conclusa' >conclusa</option>
                <option value='in corso'>in corso</option> </select><BR> <BR>
            Aggiungi codice cliente: <INPUT TYPE='text' name='codice_utente_pratica' required></INPUT> <BR>  <BR>     
            Aggiungi data: <INPUT TYPE='date' name='data_pratica' required></INPUT> <BR>    </DIV>
            <DIV class='aggiungi_destra' ALIGN='center'>    
            Scrivi qui il testo della pratica <textarea name='testo_pratica' form='aggiungi_pratica' rows='5' cols='60' required></textarea> <BR>
            <BR> <INPUT TYPE='submit' name='button' value='Aggiungi Pratica' ></INPUT>&nbsp &nbsp &nbsp &nbsp &nbsp 
            <INPUT TYPE='reset' value=' Ripristina '></INPUT></FORM><BR> </DIV>  </fieldset>  </DIV><BR><BR>      </BODY></HTML>");
    // interrogazione della tabella
    $auth = $pratica->elencaPratiche();
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
            <H4> $data $stato cliente: $cliente </H4> <H5> $testo </H5> </DIV>
            <DIV class='visualizza_des' ALIGN='center'>
            <FORM METHOD='POST' ACTION='operazioni.php'>
            <INPUT TYPE='hidden' name='codice_pratica' value=$codice> </INPUT>
            <INPUT TYPE='submit' name='button' value='Elimina Pratica'> </INPUT> </FORM> </DIV> </DIV> </fieldset> <BR>");
        }
        //se il valore della variabile contenente il risultato della query imposto la variabile flag vera
        else
            $flag=true;
	}
    
        //inizializzo la variabile stato della sessione
        $_SESSION['stato']="";
}
//funzione che crea nel form la parte riguardante i dati del commercialista
function creaModificaDati()
{
    // inclusione del file della classe
    include "commercialista.php";
    // istanza della classe
    $comm = new CommercialistaClass();
    //seleziono il database
    $comm->settaDB();
    //inizio una sessione
    session_start();
    //imposto come variabile della sessione pagina il valore 3, che indica che stiamo nella pagina relativa ai dati del commercialista
    $_SESSION['pagina']=3;
    //imposto la variabile stato con il valore contenuto nella variabile della sessione
    @$stato=$_SESSION['stato'];  
    //recupero il codice fiscale del commercialista dalla sessione
    $cf=$_SESSION['codice_fiscale'];
    //imposto il commercialista con il codice fiscale recuperato dalla sessione
    $comm->settaCommercialista($cf);
    //imposto le variabili del commercialista con le funzioni della classe commercialista
    $nome = $comm->getNome();
    $cognome = $comm->getCognome();
    $data_nascita = $comm->getDataDiNascita();
    $email = $comm->getEmail();
    $password = $comm->getPassword();
    $cf=$comm->getCodiceFiscale();
    //stampo il codice html relativo alla modifica dei dati del commercialista
    echo("<BR><fieldset><H3 ALIGN='center'>In questa sezione puoi visualizzare e modificre i tuoi dati personali</H3></fieldset><BR>");
    echo("<fieldset> <DIV align='center'> <BR> <FORM name='modifica' METHOD='POST' ACTION='operazioni.php'> 
        Modifica Codice fiscale:  <INPUT TYPE='text' name='codice_fiscale_modifica' value='$cf' required></INPUT> <BR> <BR> 
        Modifica Nome:  <INPUT TYPE='text' name='nome_modifica' value='$nome' required></INPUT> <BR> <BR> 
        Modifica Cognome:  <INPUT TYPE='text' name='cognome_modifica' value='$cognome' required></INPUT> <BR> <BR> 
        Modifica Data di nascita:  <INPUT TYPE='date' name='data_nascita_modifica' value='$data_nascita' required></INPUT> <BR> <BR> 
        Modifica E-mail:  <INPUT TYPE='text' name='email_modifica' value='$email' required></INPUT> <BR> <BR> 
        Inserisci la nuova password:  <INPUT TYPE='password' name='password_modifica' value='$password' required> </INPUT> <BR> <BR>
        <INPUT TYPE='submit' name='button' value='Modifica Dati' ></INPUT>&nbsp &nbsp &nbsp &nbsp &nbsp 
        <INPUT TYPE='reset' value=' Ripristina '></INPUT> <BR><BR>
        <H3> $stato </H3>
        </FORM> </DIV> </fieldset> <BR>");
    //inizializzo la variabile stato della sessione
    $_SESSION['stato']="";
}
//funzione che crea nel form la parte riguardante i clienti del commercialista
function creaClienti()
{
    // inclusione del file della classe
    include "utente.php";
    // istanza della classe
    $utente = new UtenteClass();
    //funzione che seleziona il database
    $utente->settaDB();
    //inizio una sessione
    session_start();
    //imposto come variabile della sessione pagina il valore 2, che indica che stiamo nella pagina relativa agli avvisi
    $_SESSION['pagina']=7;
    //imposto la variabile stato con il valore contenuto nella variabile della sessione
    @$stato=$_SESSION['stato'];
    // interrogazione della tabella
    $auth = $utente->elencaUtenti();
    //controllo se il risultato della query è vuoto
    echo("$stato");
    if($auth==null)
        echo("<H3 ALIGN='center'>Non è presente nessun Cliente<BR></H3><BR>");
    else
        echo("<H3 ALIGN='center'>Elenco Clienti <BR></H3><BR>");
    //imposto una variabile booleana utile ad uscire dal ciclo che elenca gli avvisi
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
            //imposto le variabili dell'avviso con le funzioni della classe avviso
            $utente->settaUtente($codice);
            $nome = $utente->getNome();
            $cognome = $utente->getCognome();
            $data=$utente->getDataDiNascita();
            $email=$utente->getEmail();
            $prof=$utente->getProfessione();
            $cf=$utente->getCodiceFiscale();
            //stampo il cdice html relativo alla visualizzazione dell'avviso
            echo("<fieldset><DIV class='visualizza_padre' ALIGN='center'> 
            <DIV class='visualizza_sin' ALIGN='center'>
            <H4> $nome $cognome codice fiscale: $cf</H4><H5>nato il $data, professione: $prof <BR> email: $email</H5></DIV>
            <DIV class='visualizza_des' ALIGN='center'>
            <FORM METHOD='POST' ACTION='operazioni.php'><BR>
            <INPUT TYPE='hidden' name='codice_cliente' value=$cf></INPUT>
            <INPUT TYPE='submit' name='button' value='Elimina Cliente'></INPUT></FORM></DIV></DIV></fieldset> <BR>");
        }
        //se il valore della variabile contenente il risultato della query imposto la variabile flag vera
        else
            $flag=true;
	}
        //inizializzo la variabile stato della sessione
        $_SESSION['stato']="";
}

?>