<?php
class NewsletterClass
{
    //dichiarazione delle variabili
    private $codice="";
    private $titolo="";
    private $data_news="";
    private $cod_utente="";
    private $testo="";
    private $database="";
    
    public function settaDB()
    {
        // inclusione del file della classe
        include "MySqlClass.php";
        // istanza della classe
        $this->database = new MysqlClass();
    }

    
    //funzione che cerca la news nel database e inizializza le variabili in base ai valori del database
    function settaNews($cod)
    {
        $this->codice = $cod;
      
        $data=$this->database;
        // chiamata alla funzione di connessione
        $data->connetti();
        // interrogazione della tabella
        $auth = $data->query("SELECT * FROM newsletter WHERE codice_news='$this->codice'");


        // controllo sul risultato dell'interrogazione
        if(mysql_num_rows($auth)==0)
        {
            //errore newsletter non esiste   
            //disconnetto la connessione al database
            $data->disconnetti();
        }
        else
        {
            //recupero i valori del risultato della query
            $iteratore=mysql_fetch_array($auth);
            //imposto i valori delle variabili in base ai valori memorizzati  nel database
            $this->codice=$iteratore[0];
            $this->titolo=$iteratore[1];
            $this->cod_utente=$iteratore[2];
            $this->data_news=$iteratore[3];
            $this->testo=$iteratore[4];
            //disconnetto la connessione al database
            $data->disconnetti();
        }
    
    }
  
    //funzione che aggiunge una newsletter nel database
    function aggiungiNews($titolo,$cod_ut,$data,$testo)
    {
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        //nome della tabella
        $t = "newsletter";  
        //valori da inserire
        $v = array ("$titolo","$cod_ut","$data","$testo");  
        //campi da popolare
        $r =  "titolo,codice_utente, data, testo"; 
        // chiamata alla funzione per l’inserimento dei dati
        $database->inserisci($t,$v,$r);
                
        // chiusura della connessione a MySQL
        $database->disconnetti();   
        
    }
    
    //funzione che elenca tutte le newsletter
    public function elencaNews()
    {
       
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        // interrogazione della tabella
        $auth = $database->query("SELECT codice_news FROM newsletter");
        if(mysql_num_rows($auth)==0)
        {
            return null;
            //disconnetto la connessione al database
            $database->disconnetti();
        }
        else
        {
            return $auth;  
            //disconnetto la connessione al database
            $database->disconnetti();
        }
    }
    //funzione che elenca tutte le newsletter del cliente
    public function elencaNewsUtente($cf)
    {
       
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        // interrogazione della tabella
        $auth = $database->query("SELECT codice_news FROM newsletter WHERE codice_utente='$cf'");
        if(mysql_num_rows($auth)==0)
        {
            return null;
            //disconnetto la connessione al database
            $database->disconnetti();
        }
        else
        {
            return $auth;  
            //disconnetto la connessione al database
            $database->disconnetti();
        }
    }
    
    //funzione che elimina una newsletter dal database
    public function eliminaNews($cod)
    {
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        // interrogazione della tabella
        $auth = $database->query("DELETE FROM `database`.`newsletter` WHERE `codice_news`='$cod'");
        
        $database->disconnetti();
        
    }
    //funzione che modifica una newsletter 
    public function modificaNews($codice,$titolo,$data_news,$testo)
    {        
        $this->settaNews($codice);
        $this->eliminaNews($codice);
        $cod_ut=$this->getCodiceUtente();
        $this->aggiungiNews($titolo,$cod_ut,$data_news,$testo);
    }
    //funzione che controlla se l'utente con il codice fiscale passato come parametro esiste nel database
    public function esisteUtente($cf)
    {
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $data=$this->database;
        // chiamata alla funzione di connessione
        $data->connetti();
        // interrogazione della tabella
        $auth = $data->query("SELECT nome FROM utente WHERE codice_fiscale='$cf'");

        // controllo sul risultato dell'interrogazione
        if(mysql_num_rows($auth)==0)
        {
            //utente non esiste  
            return false;
            //disconnetto la connessione al database
            $data->disconnetti();
        }
        else
        {
            //l'utente esiste
            return true;
            //disconnetto la connessione al database
            $data->disconnetti();
        }
    }
    
    // funzione per la restituzione del codice della newsletter
    public function getCodice()
    {
        return $this->codice;
    }

    // funzione per la restituzione del titolo della newsletter
    public function getTitolo()
    {
        return  $this->titolo;
    }
    
    // funzione per la restituzione della visibilità della newsletter
    public function getCodiceUtente()
    {
        return  $this->cod_utente;
    }
    
    // funzione per la restituzione del testo della newsletter
    public function getTesto()
    {
        return  $this->testo;
    }
    
    // funzione per la restituzione della data della newsletter
    public function getDataNews()
    {
        return  $this->data_news;
    }
    
   
    
}
?>