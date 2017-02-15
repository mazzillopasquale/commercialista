<?php
//In questa classe ci sono tutti i metodi dell'oggetto commercialista
class UtenteClass
{
    //dichiarazione delle variabili
    private $cod_fisc="";
    private $nome="";
    private $cognome="";
    private $data_nascita="";
    private $email="";
    private $professione="";
    private $password="";
    
     //funzione che imposta il database selezionando la classe MySql
    public function settaDB()
    {
        // inclusione del file della classe
        include "MySqlClass.php";
        // istanza della classe
        $this->database = new MysqlClass();
    }
    
    //funzione che cerca l'utente nel database e inizializza le variabili in base ai valori del database
    function settaUtente($cf)
    {
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $data=$this->database;
        // chiamata alla funzione di connessione
        $data->connetti();
        // interrogazione della tabella
        $auth = $data->query("SELECT * FROM utente WHERE codice_fiscale='$cf'");


        // controllo sul risultato dell'interrogazione
        if(mysql_num_rows($auth)==0)
        {
             //errore commercialista non esiste  
            //disconnetto la connessione al database
            $data->disconnetti();
        }
        else
        {
            //recupero i valori del risultato della query
            $iteratore=mysql_fetch_array($auth);
            //imposto i valori delle variabili in base ai valori memorizzati  nel database
            $this->cod_fisc=$iteratore[0];
            $this->nome=$iteratore[1];
            $this->cognome=$iteratore[2];
            $this->data_nascita=$iteratore[3];
            $this->professione=$iteratore[4];
            $this->email=$iteratore[5];
            $this->password=$iteratore[6];
            //disconnetto la connessione al database
            $data->disconnetti();
        }
    
    }
  
    //funzione che permette di effettuare il login ad un Utente
    public function loginUtente($email,$password,$data)
    {   
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $this->database = $data;
        // chiamata alla funzione di connessione
        $data->connetti();
        // interrogazione della tabella
        $auth1 = $data->query("SELECT codice_fiscale FROM utente WHERE email='$email' AND password='$password'");
            
        // controllo sul risultato dell'interrogazione
        if(mysql_num_rows($auth1)==0)
        {
            // chiusura della connessione a MySQL
            $data->disconnetti();
            // imposto la variabile stato uguale a 1
            $_SESSION['stato_login']=1;
            //redirect alla pagina homr in caso di insuccesso
            header("Location: home.php");
              
        }
          else
          {
              $row=mysql_fetch_array($auth1);
              $cf = $row[0];
              //imposto le variabili di sessione
              $_SESSION['codice_fiscale']=$cf;
              // chiusura della connessione a MySQL
              $data->disconnetti();
              // redirect alla pagina di Utente in caso di successo
              header("Location: utenteForm.php");
          }
    }
    
    //funzione per aggiungere un utente nel database
    public function aggiungiUtente($cod,$nome,$cognome,$data_nascita,$prof,$email,$password)
    {
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $data=$this->database;
        // chiamata alla funzione di connessione
        $data->connetti();
        // interrogazione della tabella per verificare se esiste già un utente iscritto con questo codice fiscale
        $auth = $data->query("SELECT * FROM utente WHERE codice_fiscale='$codFis' OR email='$email'");
        // controllo sul risultato dell'interrogazione
        if(mysql_num_rows($auth)==0)
        {  
            $t = "utente"; # nome della tabella
            $v = array ("$cod","$nome","$cognome","$data_nascita","$prof","$email","$password"); # valori da inserire
            $r =  "codice_fiscale, nome,cognome, data_di_nascita, professione, email, password"; # campi da popolare
            
            // chiamata alla funzione per l’inserimento dei dati
            $data->inserisci($t,$v,$r);
            
            // chiusura della connessione a MySQL
            $data->disconnetti();
            //imposto la varibile stato
            $_SESSION['stato_registrazione']="Registrazione effettuata, accedi al servizio";
            // redirect alla pagina HOME in caso di successo
            header("Location: home.php");
            
        }
        else
        {
            // chiusura della connessione a MySQL
            $data->disconnetti();
            // redirect alla home page in caso di insuccesso
            $_SESSION['stato_registrazione']="Risulta già iscritto un utente con questo codice fiscale o con questa email, Riprova";
            header("Location: home.php");     
        }
    }
    
    //funzione che permette di modificare i dati dell'utente nel database
    public function modificaUtente($cf_vecchio,$cod,$nome,$cognome,$data_nascita,$prof,$email,$password)
    {
        //elimino il commercialista che ha come codice ficale $cod
        $this->eliminaUtente($cf_vecchio);
        //aggiungo un nuovo commercialista
        $this->aggiungiUtente($cod,$nome,$cognome,$data_nascita,$prof,$email,$password);
    }
    
    //funzione che elimina un utente
    public function eliminaUtente($codice_fiscale)
    {
       //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        // interrogazione della tabella
        $auth = $database->query("DELETE FROM `database`.`utente` WHERE `codice_fiscale`='$codice_fiscale'");
        
        $database->disconnetti();
        header("Location:home.php");
    }
    
    //funzione che elenca tutti gli utenti
    public function elencaUtenti()
    {
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        // interrogazione della tabella
        $auth = $database->query("SELECT codice_fiscale FROM utente");
        //controllo se il risultato della query è vuoto
        if(mysql_num_rows($auth)==0)
        {
            //restituisco null
            return null;
            //disconnetto la connessione al database
            $database->disconnetti();
        }
        else
        {
            //restituisco il risultato della query
            return $auth;  
            //disconnetto la connessione al database
            $database->disconnetti();
        }
    }
        
    // funzione per la restituzione del nome
    public function getNome()
    {
        return $this->nome;
    }

    // funzione per la restituzione del cognome
    public function getCognome()
    {
        return  $this->cognome;
    }
    
    // funzione per la restituzione della data di nascita
    public function getDataDiNascita()
    {
        return  $this->data_nascita;
    }
    
    // funzione per la restituzione dell'email
    public function getEmail()
    {
        return  $this->email;
    }
    
    // funzione per la restituzione della password
    public function getPassword()
    {
        return  $this->password;
    }
    
    // funzione per la restituzione della professione
    public function getProfessione()
    {
        return  $this->professione;
    }
    
    // funzione per la restituzione del codice fiscale
    public function getCodiceFiscale()
    {
        return  $this->cod_fisc;
    }
    
}
?>