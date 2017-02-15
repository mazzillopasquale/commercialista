<?php
//classe dell'oggetto Mysql
class MysqlClass
{
    // variabili per la connessione al database
	private $nomehost = "localhost";     
    private $nomeuser = "root";          
    private $password = "shakethat";
    private $nomedb = "database";
    // controllo sulle connessioni attive
	private $attiva = false;
    // funzione per la connessione a MySQL
    public function connetti()
    {
        //controllo se la variabile attiva è false
        if(!$this->attiva)
        {
            //effettuo una nuova connessione al database con le variabili impostate in precedenza e controllo se la connessione è riuscita
            if($connessione = mysql_connect($this->nomehost,$this->nomeuser,$this->password) or die (mysql_error()))
		    {
                //se la connessione è riuscita seleziono il database se esiste
		        $selezione = mysql_select_db($this->nomedb,$connessione) or die (mysql_error());
		    }
        }else{
            //restituisco vero
            return true;
        }
    }

//funzione per l'esecuzione delle query 
public function query($sql)
{
    //controllo se è già stata effettuata una connessione
    if(isset($this->attiva))
  {
  $sql = mysql_query($sql) or die (mysql_error());
  return $sql; 
  }else{
  return false; 
  }
 }
 
//funzione per l'inserimento dei dati in tabella
public function inserisci($t,$v,$r = null)
    {
         if(isset($this->attiva))
          {
			$istruzione = 'INSERT INTO '.$t;
            if($r != null)
            {
                $istruzione .= ' ('.$r.')';
            }

            for($i = 0; $i < count($v); $i++)
            {
                if(is_string($v[$i]))
                    $v[$i] = '"'.$v[$i].'"';
            }
            $v = implode(',',$v);
            $istruzione .= ' VALUES ('.$v.')';

            $query = mysql_query($istruzione) or die (mysql_error());

            }else{
                return false;
            }
        }
    
//funzione per l'estrazione dei record 
public function estrai($risultato)
 {
  if(isset($this->attiva))
  {
  $r = mysql_fetch_object($risultato);
  return $r;
  }else{
  return false; 
  }
 }


// funzione per la chiusura della connessione
public function disconnetti()
{
	if($this->attiva)
	{
		if(mysql_close())
		{
         $this->attiva = false; 
	     return true; 
		}else{
			return false; 
		}
	}
 }
	
}
?>