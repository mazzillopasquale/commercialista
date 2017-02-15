<?php
class AvvisoClass
{
    //dichiarazione delle variabili
    private $codice="";
    private $titolo="";
    private $data_avviso="";
    private $visibilita="";
    private $testo="";
    private $database="";
    
    //funzione che imposta il database selezionando la classe MySql
    public function settaDB()
    {
        // inclusione del file della classe
        include "MySqlClass.php";
        // istanza della classe
        $this->database = new MysqlClass();
    }

    
    //funzione che cerca l'avviso nel database e inizializza le variabili in base ai valori del database
    function settaAvviso($cod)
    {
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $data=$this->database;
        // chiamata alla funzione di connessione
        $data->connetti();
        // interrogazione della tabella
        $auth = $data->query("SELECT * FROM avvisi WHERE codice_avvisi='$cod'");
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
            $this->titolo=$iteratore[1];
            $this->data_avviso=$iteratore[2];
            $this->visibilita=$iteratore[3];
            $this->testo=$iteratore[4];
            //disconnetto la connessione al database
            $data->disconnetti();
        }
    
    }
  
    //funzione che aggiunge un avviso nel database
    function aggiungiAvviso($titolo,$data,$visibilita,$testo)
    {
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        //nome della tabella
        $t = "avvisi";  
        //valori da inserire
        $v = array ("$titolo","$data","$visibilita","$testo");  
        //campi da popolare
        $r =  "titolo, data, visibilita, testo"; 
        // chiamata alla funzione per l’inserimento dei dati
        $database->inserisci($t,$v,$r);
        // chiusura della connessione a MySQL
        $database->disconnetti();   
        
    }
    
    //funzione che elenca tutti gli avvisi
    public function elencaAvvisi()
    {
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        // interrogazione della tabella
        $auth = $database->query("SELECT codice_avvisi FROM avvisi");
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
    
    //funzione che elimina un avviso dal database
    public function eliminaAvviso($cod)
    {
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $database=$this->database;
        // chiamata alla funzione di connessione
        $database->connetti();
        // interrogazione della tabella
        $auth = $database->query("DELETE FROM `database`.`avvisi` WHERE `codice_avvisi`='$cod'");
        //disconnetto la connessione al database
        $database->disconnetti();
        
    }
    
    //funzione che modifica un avviso
    public function modificaAvviso($codice,$titolo,$data_avviso,$vis,$testo)
    {    
        //elimino l'avviso che ha come codice $codice
        $this->eliminaAvviso($codice);
        //aggiungo un nuovo avviso
        $this->aggiungiAvviso($titolo,$data_avviso,$vis,$testo);
    }
    
    // funzione per la restituzione del codice
    public function getCodice()
    {
        return $this->codice;
    }

    // funzione per la restituzione del titolo
    public function getTitolo()
    {
        return  $this->titolo;
    }
    
    // funzione per la restituzione della visibilità
    public function getVisibilita()
    {
        return  $this->visibilita;
    }
    
    // funzione per la restituzione del testo
    public function getTesto()
    {
        return  $this->testo;
    }
    
    // funzione per la restituzione della data
    public function getDataAvviso()
    {
        return  $this->data_avviso;
    }    
}
?>