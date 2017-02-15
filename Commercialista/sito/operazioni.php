<?php
//recupero il nome del bottone cliccato
$tipoOperazione=$_POST['button'];
//in base al nome del bottone cliccato eseguo una funzione
if($tipoOperazione=='Aggiungi Avviso')
    aggAvviso();

if($tipoOperazione=='Elimina Avviso')
    elAvviso();

if($tipoOperazione=='Modifica Avviso')
    modAvvisoForm();

if($tipoOperazione=='Modifica avviso')
    modAvviso();

if($tipoOperazione=='Aggiungi Newsletter')
    aggNews();

if($tipoOperazione=='Elimina Newsletter')
    elNews();

if($tipoOperazione=='Modifica Newsletter')
    modNewsForm();

if($tipoOperazione=='Modifica newsletter')
    modNews();

if($tipoOperazione=='Aggiungi Pratica')
    aggPratica();

if($tipoOperazione=='Elimina Pratica')
    elPratica();

if($tipoOperazione=='Modifica Dati')
    modDatiComm();

if($tipoOperazione=='Modifica dati')
    modDatiUtente();

if($tipoOperazione=='Elimina Cliente')
    elCliente();

//funzione che permette di aggiungere un nuovo avviso
function aggAvviso()
{
    include "avviso.php";
    // istanza della classe
    $avviso = new AvvisoClass();
    $avviso->settaDB();
    $titolo=$_POST['titolo_avviso'];
    $data=$_POST['data_avviso'];
    $vis=$_POST['visibilita_avviso'];
    $testo=$_POST['testo_avviso'];
    $avviso->aggiungiAvviso($titolo,$data,$vis,$testo);
    session_start();
    $_SESSION['pagina']=2;
    $_SESSION['stato']=" Avviso $titolo aggiunto con successo";
    header("location:commercialistaForm.php");
}
//funzione che permette di eliminare un avviso
function elAvviso()
{
    include "avviso.php";
    // istanza della classe
    $avviso = new AvvisoClass();
    $avviso->settaDB();
    $codice=$_POST['codice_avviso'];
    $avviso->eliminaAvviso($codice);
    session_start();
    $_SESSION['pagina']=2;
    $_SESSION['stato']=" Avviso eliminato con successo";
    header("location:commercialistaForm.php");
}

function modAvvisoForm()
{
    $codice=$_POST['codice_avviso'];
    session_start();
    $_SESSION['pagina']=5;
    $_SESSION['codice_avviso']=$codice;
    header("location:commercialistaForm.php");
}

function modAvviso()
{
    include "avviso.php";
    // istanza della classe
    $avviso = new AvvisoClass();
    $avviso->settaDB();
    $codice=$_POST['codice_avviso'];
    echo("$codice   ");
    $titolo=$_POST['titolo_avviso'];
    $data=$_POST['data_avviso'];
    $vis=$_POST['visibilita_avviso'];
    $testo=$_POST['testo_avviso'];
    $avviso->modificaAvviso($codice,$titolo,$data,$vis,$testo);
    session_start();
    $_SESSION['pagina']=2;
    $_SESSION['stato']=" Avviso $titolo modificato con successo";
    header("location:commercialistaForm.php");
}

function aggNews()
{
    include "newsletter.php";
    // istanza della classe
    $news = new NewsletterClass();
    $news->settaDB();
    $titolo=$_POST['titolo_news'];
    $data=$_POST['data_news'];
    $cod_ut=$_POST['cod_utente_news'];
    $testo=$_POST['testo_news'];
    if($news->esisteUtente($cod_ut)==true)
    {
        $news->aggiungiNews($titolo,$cod_ut,$data,$testo);
        session_start();
        $_SESSION['pagina']=1;
        $_SESSION['stato']=" Newsletter $titolo aggiunta con successo";
        header("location:commercialistaForm.php");
    }
    else
    {
        session_start();
        $_SESSION['pagina']=1;
        $_SESSION['stato']="Il codice fiscale dell'utente non è presente nel database";
        header("location:commercialistaForm.php");
    }
}

function elNews()
{
    include "newsletter.php";
    // istanza della classe
    $news = new NewsletterClass();
    $news->settaDB();
    $codice=$_POST['codice_news'];
    $news->eliminaNews($codice);
    session_start();
    $_SESSION['pagina']=1;
    $_SESSION['stato']=" Newsletter eliminato con successo";
    header("location:commercialistaForm.php");
}

function modNewsForm()
{
    $codice=$_POST['codice_news'];
    session_start();
    $_SESSION['pagina']=6;
    $_SESSION['codice_news']=$codice;
    header("location:commercialistaForm.php");
}

function modNews()
{
    include "newsletter.php";
    // istanza della classe
    $news = new NewsletterClass();
    $news->settaDB();
    $codice=$_POST['codice_news'];
    $titolo=$_POST['titolo_news'];
    $data=$_POST['data_news'];
    $testo=$_POST['testo_news'];
    $news->modificaNews($codice,$titolo,$data,$testo);
    session_start();
    $_SESSION['pagina']=1;
    $_SESSION['stato']=" Newsletter $titolo modificata con successo";
    header("location:commercialistaForm.php");
}

//funzione che permette di aggiungere una nuova pratica
function aggPratica()
{
    include "pratica.php";
    //istanza della classe
    $pratica = new PraticaClass();
    $pratica->settaDB();
    $stato=$_POST['stato_pratica'];
    $data=$_POST['data_pratica'];
    $cod_cli=$_POST['codice_utente_pratica'];
    $testo=$_POST['testo_pratica'];
    if($pratica->esisteUtente($cod_cli)==true)
    {
        $pratica->aggiungiPratica($data,$stato,$cod_cli,$testo);
        session_start();
        $_SESSION['pagina']=4;
        $_SESSION['stato']=" Pratica $titolo aggiunta con successo";
        header("location:commercialistaForm.php");
    }
    else
    {
        session_start();
        $_SESSION['pagina']=4;
        $_SESSION['stato']="Il codice fiscale dell'utente non è presente nel database";
        header("location:commercialistaForm.php");
    }
    
}
//funzione che permette di eliminare una pratica
function elPratica()
{
    include "pratica.php";
    //istanza della classe
    $pratica = new PraticaClass();
    $pratica->settaDB();
    $codice=$_POST['codice_pratica'];
    $pratica->eliminaPratica($codice);
    session_start();
    $_SESSION['pagina']=4;
    $_SESSION['stato']=" Prarica eliminata con successo";
    header("location:commercialistaForm.php");
}

function modDatiComm()
{
    include "commercialista.php";
    // istanza della classe
    $comm = new CommercialistaClass();
    $comm->settaDB();
    $cf=$_POST['codice_fiscale_modifica'];
    $nome=$_POST['nome_modifica'];
    $cognome=$_POST['cognome_modifica'];
    $data_nas=$_POST['data_nascita_modifica'];
    $email=$_POST['email_modifica'];
    $password=$_POST['password_modifica'];
    session_start();
    $cf_vecchio=$_SESSION['codice_fiscale'];
    
    //controllo se il codice fiscale inserito è di 16 caratteri
    if(strlen($password)<8)
    {
        //imposto la varibile stato =2
        $_SESSION['stato']="La password deve contenere almeno 8 caratteri";
        // redirect alla home page in caso di insuccesso
        header("Location: commercialistaForm.php");
    }
    else if(strlen($cf) != 16 )
    {
        //imposto la varibile stato =2
        $_SESSION['stato']="Il codice fiscale deve contenere 16 caratteri";
        // redirect alla home page in caso di insuccesso
        header("Location: commercialistaForm.php");
    }
    else
    {
        $comm->modificaCommercialista($cf_vecchio,$cf,$nome,$cognome,$data_nas,$email,$password);
        $_SESSION['pagina']=3;
        $_SESSION['stato']=" Dati personali modificati con successo";
        $_SESSION['codice_fiscale']=$cf;
        header("location:commercialistaForm.php");
    }
}

function modDatiUtente()
{
    include "utente.php";
    // istanza della classe
    $utente = new UtenteClass();
    $utente->settaDB();
    $cf=$_POST['codice_fiscale_modifica'];
    $nome=$_POST['nome_modifica'];
    $prof=$_POST['professione_modifica'];
    $cognome=$_POST['cognome_modifica'];
    $data_nas=$_POST['data_nascita_modifica'];
    $email=$_POST['email_modifica'];
    $password=$_POST['password_modifica'];
    session_start();
    $cf_vecchio=$_SESSION['codice_fiscale'];
    
    //controllo se il codice fiscale inserito è di 16 caratteri
    if(strlen($password)<8)
    {
        //imposto la varibile stato =2
        $_SESSION['stato']="La password deve contenere almeno 8 caratteri";
        // redirect alla home page in caso di insuccesso
        header("Location: utenteForm.php");
    }
    else if(strlen($cf) != 16 )
    {
        //imposto la varibile stato =2
        $_SESSION['stato']="Il codice fiscale deve contenere 16 caratteri";
        // redirect alla home page in caso di insuccesso
        header("Location: utenteForm.php");
    }
    else
    {
        $utente->modificaUtente($cf_vecchio,$cf,$nome,$cognome,$data_nas,$prof,$email,$password);
        $_SESSION['pagina']=3;
        $_SESSION['stato']=" Dati personali modificati con successo";
        $_SESSION['codice_fiscale']=$cf;
        header("location:utenteForm.php");
    }
}
function elCliente()
{
    include "utente.php";
    // istanza della classe
    $utente = new UtenteClass();
    $utente->settaDB();
    $codice=$_POST['codice_cliente'];
    $utente->eliminaUtente($codice);
    session_start();
    $_SESSION['pagina']=7;
    $_SESSION['stato']=" Utente eliminato con successo";
    header("location:commercialistaForm.php");
}


?>