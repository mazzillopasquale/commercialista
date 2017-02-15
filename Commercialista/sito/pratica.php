<?php
class PraticaClass
{
    //dichiarazione delle variabili
    private $codice="";
    private $stato="";
    private $data_pratica="";
    private $codice_cliente="";
    private $testo="";
    private $database="";
    
    //funzione che seleziona la clarre MySql
    public function settaDB()
    {
        // inclusione del file della classe
        include "MySqlClass.php";
        // istanza della classe
        $this->database = new MysqlClass();
    }

    
    //funzione che cerca la pratica nel database e inizializza le variabili in base ai valori del database
    function settaPratica($cod)
    {   
        //setta la variabile contenente il database
        $data=$this->database;
        // chiamata alla funzione di connessione
        $data->connetti();
        // interrogazione della tabella
        $auth = $data->query("SELECT * FROM pratica WHERE codice_pratica='$cod'");


        // controllo sul risultato dell'interrogazione
        if(mysql_num_rows($auth)==0)
        {
            //errore avviso non esiste   
            //disconnetto la connessione al database
            $data->disconnetti();
        }
        else
        {
            //recupero i valori del risultato della query
            $iteratore=mysql_fetch_array($auth);
            //imposto i valori delle variabili in base ai valori memorizzati  nel database
            $this->codice=$iteratore[0];
            $this->data_pratica=$iteratore[1];
            $this->stato=$iteratore[2];
            $this->codice_cliente=$iteratore[3];
            $this->testo=$iteratore[4];
            //disconnetto la connessione al database
            $data->disconnetti();
        }
    
    }
  
    //funzione che aggiunge una pratica nel database
    function aggiungiPratica($data,$stato,$codice_cliente,$testo)
    {
        //setta la variabile contenente il database
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        //nome della tabella
        $t = "pratica";  
        //valori da inserire
        $v = array ("$stato","$data","$codice_cliente","$testo");  
        //campi da popolare
        $r =  "stato, data,codice_cliente, testo"; 
        // chiamata alla funzione per l’inserimento dei dati
        $database->inserisci($t,$v,$r);     
        // chiusura della connessione a MySQL
        $database->disconnetti();   
    }
    
    //funzione che elenca tutti le pratiche di un cliente
    public function elencaPraticheCliente($codice_cliente)
    {
        //setta la variabile contenente il database
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        // interrogazione della tabella
        $auth = $database->query("SELECT codice_pratica FROM pratica WHERE codice_cliente='$codice_cliente'");
        //controlla se il risultato della query è vuoto
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
    
     //funzione che elenca tutti le pratiche presenti nel database
    public function elencaPratiche()
    {
        //setta la variabile contenente il database
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        // interrogazione della tabella
        $auth = $database->query("SELECT codice_pratica FROM pratica");
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
    
    //funzione che elimina una pratica dal database
    public function eliminaPratica($cod)
    {
        //setta la variabile contenente il database
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        // interrogazione della tabella
        $auth = $database->query("DELETE FROM `database`.`pratica` WHERE `codice_pratica`='$cod'");
        //disconnetto la connessione al database
        $database->disconnetti();
    }
    //funzione che controlla se l'utente con il codice fiscale passato come parametro esiste nel database
    public function esisteUtente($cf)
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
    
    // funzione per la restituzione del codice della pratica
    public function getCodicePratica()
    {
        return $this->codice;
    }

    // funzione per la restituzione dello stato della pratica 
    public function getStato()
    {
        return  $this->stato;
    }
    
    // funzione per la restituzione del codice del cliente della pratica
    public function getCodiceCliente()
    {
        return  $this->codice_cliente;
    }
    
    // funzione per la restituzione del testo della pratica
    public function getTesto()
    {
        return  $this->testo;
    }
    
    // funzione per la restituzione della data della pratica
    public function getDataPratica()
    {
        return  $this->data_pratica;
    }
    
   
    
}
?>