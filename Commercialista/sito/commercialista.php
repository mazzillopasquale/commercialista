<?php
//In questa classe ci sono tutti i metodi dell'oggetto commercialista
class CommercialistaClass
{
    //dichiarazione delle variabili
    private $cod_fisc="";
    private $nome="";
    private $cognome="";
    private $data_nascita="";
    private $email="";
    private $password="";
    private $database="";
    
    //funzione che imposta il database selezionando la classe MySql
    public function settaDB()
    {
        // inclusione del file della classe
        include "MySqlClass.php";
        // istanza della classe
        $this->database = new MysqlClass();
    }
    
    //funzione che cerca il commercialista nel database e inizializza le variabili in base ai valori del database
    function settaCommercialista($cf)
    {
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $data=$this->database;
        // chiamata alla funzione di connessione
        $data->connetti();
        // interrogazione della tabella
        $auth = $data->query("SELECT * FROM commercialista WHERE codice_fiscale='$cf'");
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
            $this->email=$iteratore[4];
            $this->password=$iteratore[5];
            //disconnetto la connessione al database
            $data->disconnetti();
        }
    
    }
  
    //funzione che permette di effettuare il login ad un commercialista
    public function loginCommercialista($email,$password,$database)
    {
            
            //inserisco nella variabile data il valore della variabile database impostato in precedenza
            $this->database = $database;
            // chiamata alla funzione di connessione
            $database->connetti();
            // interrogazione della tabella
            $auth1 = $database->query("SELECT codice_fiscale FROM commercialista WHERE email='$email' AND password='$password'");
            // controllo sul risultato dell'interrogazione
            if(mysql_num_rows($auth1)==0)
            {
                // chiusura della connessione a MySQL
                $database->disconnetti();
                // imposto la variabile stato uguale a 1
                $_SESSION['stato_login']=1;
                //redirect alla pagina homr in caso di insuccesso
                header("Location: home.php");
                  
            }
              else
              {
                  //salvo nella variabile row il risultato della query sottoforma di array
                  $row=mysql_fetch_array($auth1);
                  //imposto la variabile cf con il primo risultato della query
                  $cf = $row[0];
                  //imposto le variabili di sessione
                  $_SESSION['codice_fiscale']=$cf;
                  // chiusura della connessione a MySQL
                  $database->disconnetti();
                  // redirect alla pagina di commercialista in caso di successo
                  header("Location: commercialistaForm.php");
              }
        
    }
    //funzione che elimina un commercialista dal database
    public function eliminaCommercialista($cod)
    {
        
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $data=$this->database;
        // chiamata alla funzione di connessione
        $data->connetti();
        // interrogazione della tabella
        $auth = $data->query("DELETE FROM `database`.`commercialista` WHERE `codice_fiscale`='$cod'");
        //disconnetto la connessione al database
        $data->disconnetti();
        
    }
    
    //funzione che aggiunge un commercialista nel database
    function aggiungiCommercialista($cf,$nome,$cognome,$data_nascita,$email,$password)
    {
        //inserisco nella variabile data il valore della variabile database impostato in precedenza
        $data=$this->database;
        // chiamata alla funzione di connessione
        $data->connetti();
        //nome della tabella
        $t = "commercialista";  
        //valori da inserire
        $v = array ("$cf","$nome","$cognome","$data_nascita","$email","$password");  
        //campi da popolare
        $r =  "codice_fiscale, nome, cognome, data_di_nascita, email, password"; 
        // chiamata alla funzione per l’inserimento dei dati
        $data->inserisci($t,$v,$r);
        // chiusura della connessione a MySQL
        $data->disconnetti();       
    }
    
    //funzione che modifica un commercialista
    public function modificaCommercialista($cf_vecchio,$cf,$nome,$cognome,$data_nascita,$email,$password)
    {   
        //elimino il commercialista che ha come codice ficale $cod
        $this->eliminaCommercialista($cf_vecchio);
        //aggiungo un nuovo commercialista
        $this->aggiungiCommercialista($cf,$nome,$cognome,$data_nascita,$email,$password);
    }
    
    // funzione per la restituzione del nome del commercialista
    public function getNome()
    {
        return $this->nome;
    }

    // funzione per la restituzione del cognome del commercialista
    public function getCognome()
    {
        return  $this->cognome;
    }
    
    // funzione per la restituzione della data di nascita del commercialista
    public function getDataDiNascita()
    {
        return  $this->data_nascita;
    }
    
    // funzione per la restituzione dell'email del commercialista
    public function getEmail()
    {
        return  $this->email;
    }
    
    // funzione per la restituzione della password del commercialista
    public function getPassword()
    {
        return  $this->password;
    }
    
    // funzione per la restituzione del codice fiscale del commercialista
    public function getCodiceFiscale()
    {
        return  $this->cod_fisc;
    }
    
}
?>