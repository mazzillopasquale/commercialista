<?php

$tipo=$_POST['button'];

if($tipo=='Accedi')
    login();

if($tipo=='Registrati')
    registrazione();
    
if($tipo=='Esci')
    logout();
function login()
{
     //recupero i valori delle variabili impostate nella form login attraverso il post
        $email=$_POST['email_login'];
        $password=$_POST['password_login'];
        // inizializzazione della sessione
        session_start();

        // inclusione del file della classe
        include "MySqlClass.php";
        // istanza della classe
        $data = new MysqlClass();
        // chiamata alla funzione di connessione
        $data->connetti();
        // interrogazione della tabella
        $auth = $data->query("SELECT codice_fiscale FROM utente WHERE email='$email' AND password='$password'");
        
        // controllo sul risultato dell'interrogazione
        if(mysql_num_rows($auth)==0)
        {
            // inclusione del file della classe
            include "commercialista.php";
            // istanza della classe
            $comm = new CommercialistaClass();
            $comm->loginCommercialista($email,$password,$data);
        }
          else
          {
            // inclusione del file della classe
            include "utente.php";
            // istanza della classe
            $utente = new UtenteClass();
            $utente->loginUtente($email,$password,$data);
         }
}

function registrazione()
{
    $email = $_POST['email_registrazione'];
    $password = $_POST['password_registrazione'];
    $nome = $_POST['nome_registrazione'];
    $cognome = $_POST['cognome_registrazione'];
    $data_nascita = $_POST['data_nascita_registrazione'];
    $prof = $_POST['professione_registrazione'];
    $codFis = $_POST['codice_fiscale_registrazione'];

    session_start();

    //controllo se il codice fiscale inserito è di 16 caratteri
    if(strlen($password)<8)
    {
        //imposto la varibile stato =2
        $_SESSION['stato_registrazione']="La password deve contenere almeno 8 caratteri";
        // redirect alla home page in caso di insuccesso
        header("Location: home.php");
    }
    else if(strlen($codFis) != 16 )
    {
        //imposto la varibile stato =2
        $_SESSION['stato_registrazione']="Il codice fiscale deve contenere 16 caratteri";
        // redirect alla home page in caso di insuccesso
        header("Location: home.php");
    }
    else
    {
        //trasformo il codice fiscale in caratteri maiuscoli
        $codFis=strtoupper($codFis);
        
        // inclusione del file della classe
        include "utente.php";
        // istanza della classe
        $utente = new UtenteClass();
        //seleziono il database
        $utente->settaDB();
        //aggiungo il nuovo utente nel database tramite il metodo aggiungi utente della classe utente
        $utente->aggiungiUtente($codFis,$nome,$cognome,$data_nascita,$prof,$email,$password);
    }
}

function logout()
{
    //inizializzo tutti i valori della sessione
    $_SESSION = array();
    $_SESSION['pagina']=2;
    //indirizzo l'utente nella pagina principale del sito
    header("location:home.php");
    //chiudo la sessione
    session_destroy();
}
?>