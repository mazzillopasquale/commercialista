
<HTML>
	<HEAD>
		<TITLE>
		Commercialista
		</TITLE>
        
			<link rel="stylesheet" type="text/css" href="stile_principale.css">
            <link rel="stylesheet" type="text/css" href="bootstrap.css">
	</HEAD>
	<BODY>
	<DIV class='padre_sopra'>
	<DIV class='sinistra_sopra' ALIGN=left> 
	<h2>   Commercialista Ferrara</h2>
	</DIV>
	<DIV class='destra_sopra' title='accedi' ALIGN=right > <P>
	<FORM name='login' METHOD='POST' border='border-left' action="autenticazione.php">
	E-mail <INPUT TYPE='text' name='email_login' id='email_login' required> </INPUT>
	Password <INPUT TYPE='password' name='password_login' id='password_login' required> </INPUT>
	<INPUT class="btn btn-default" TYPE="submit" id='button_login' name='button' value='Accedi' > </INPUT><br>
	<?php
        //inizio una sessione
        session_start();    
        //recupero la variabile stato della sessione
        @$stato_log=$_SESSION['stato_login'];
        //controllo se la variabile stato vale 1, se contiene qualche valore lo stampo, altrimenti stampo una stringa vuota
        if($stato_log==1)
            echo(" E-mail o password sbagliate ");
        else
            echo(" Inserisci username e password, dopo clicca sul pulsante Accedi");
        $_SESSION['stato_login']="";
        
    ?>
        
        </FORM> </P>
	
        </DIV> </DIV>
	<DIV class='padre_sotto'>
	
	<DIV class='sinistra_sotto' ALIGN='center'>
        <H3> Orari studio </H3>
        
            <TABLE BORDER =2 ALIGN='center' WIDTH=80% HEIGHT=30%> 
                <TR ALIGN='center'> <TH> giorni </TH> <TD> lunedì </TD>  <TD> martedì </TD>   <TD> mercoledì </TD> <TD> giovedì </TD><TD> venerdì </TD> </TR>
                <TR ALIGN='center'> <TH> mattina </TH> <TD> 09:00-12:30 </TD>  <TD> 09:00-12:30 </TD><TD> 09:00-12:30 </TD><TD> 09:00-12:30 </TD><TD> 09:00-12:30 </TD>    </TR> 
                <TR ALIGN='center'>  <TH> pomeriggio </TH>  <TD> 17:00-20:00 </TD> <TD> 17:00-20:00 </TD><TD> 17:00-20:00 </TD><TD> 17:00-20:00 </TD><TD> chiuso </TD> </TR> 
            </TABLE>
        <br><br>
         <H4> Puoi rivolgerti a noi per l'amministrazione e la liquidazione di aziende, patrimoni e singoli beni,<BR>
              per perizie e consulenze tecniche;<BR>
              Per la verificazione e ogni altra indagine in merito alla attendibilità di bilanci, di conti, di scritture e di ogni altro documento contabile delle imprese ed enti pubblici e privati.<BR>
              
        </H4>
             
        <br>
        <H4> Recapiti: <BR>
             chiama: <a href="tel:+393338150808"> +393338150808</a> oppure <a href="mailto:pasquale.maz.94o@gmail.com">Scrivi una mail</a><BR>
             L'indirizzo dello studio commercialista di Ferrara Mauro è :
             via Loggia dei Pisani, 25
             80143 Napoli<BR>
             <a href="https://www.google.it/maps/place/Via+Loggia+dei+Pisani,+25,+80133+Napoli/@40.8428951,14.2523247,17z/data=!4m5!3m4!1s0x133b084583eb6bf1:0xcc61dd9780aebea9!8m2!3d40.8428911!4d14.2545134"> Google Maps </a></H4>
        </DIV>
	
	
	<DIV class='destra_sotto' ALIGN=right>
        <fieldset>
        <H3 ALIGN='CENTER'> Registrazione </H3>
	<FORM name='registrazione' METHOD='POST' ACTION='autenticazione.php'>
	Nome  <INPUT TYPE='text' name='nome_registrazione' id='nome_registrazione' required> </INPUT> <BR><BR>
	Cognome  <INPUT TYPE='text' name='cognome_registrazione' id='cognome_registrazione'  required> </INPUT> <BR><BR>
	Data di nascita  <INPUT TYPE='date' name='data_nascita_registrazione' id='data_nascita_registrazione' required>  </INPUT>&nbsp;&nbsp;&nbsp;&nbsp;<BR><BR>
	Professione  <INPUT TYPE='text' name='professione_registrazione' id='professione_registrazione' required>  </INPUT><BR><BR>
	Codice Fiscale  <INPUT TYPE='text' name='codice_fiscale_registrazione' id='codice_fiscale_registrazione'>  </INPUT><BR><BR>
	E-mail  <INPUT TYPE='text' name='email_registrazione' id='email_registrazione' required>  </INPUT><BR><BR>
	Password  <INPUT TYPE='password' name='password_registrazione' id='password_registrazione' required>  </INPUT><BR><BR>
    <INPUT class='btn btn-default' TYPE='submit' name='button' value='Registrati'></INPUT> 
    <INPUT class='btn btn-default' TYPE='reset' value=' Cancella '> </INPUT><BR><BR> 
         
        <?php
        @session_start();
        //recupero la variabile stato della sessione
        @$stato_reg=$_SESSION['stato_registrazione'];
        echo($stato_reg);
    
        
        $_SESSION['stato_registrazione']="";
    ?>
       
    </FORM>
       
	</fieldset>
	</DIV>
	</DIV>
	

	</BODY>
</HTML>

    