<?php
function isUser($cid,$login,$pwd) {
	$risultato= array("msg"=>"","status"=>"ok");

	if ($cid == null || $cid->connect_errno) {
		$risultato["status"]="ko";
		if (!is_null($cid))
		     $risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		else $risultato["msg"]="errore nella connessione al db ";
		return $risultato;
	}

   $sql = "SELECT * FROM utente where email = '$login' and password = '$pwd'";
   
   $res = $cid->query($sql);
   	if ($res==null) 
	{
	        $msg = "Si sono verificati i seguenti errori:<br/>" 
     		. $cid->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;			
	}elseif($res->num_rows==0 || $res->num_rows>1)
	{
			$msg = "Login o password sbagliate";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;		
	}elseif($res->num_rows==1)
	{
	    $msg = "Login effettuato con successo";
		$risultato["status"]="ok";
		$risultato["msg"]=$msg;		
	}
    return $risultato;
}
function verificaPwd($pwd) {
    // Definisce un pattern regex che corrisponda a una maiuscola, un numero e un carattere speciale
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/';

    // Verifica se la stringa soddisfa il pattern
    return (bool)preg_match($pattern, $pwd);
}

function isCity($cid,$citta,$provincia,$stato){
	

	$sql = "SELECT * FROM citta where 	nomeCittà = '$citta' and provincia = '$provincia' and stato = '$stato'";
	$res = $cid->query($sql);
   	if ($res==null) 
	{
	        return false; 		
	}elseif($res->num_rows==0 || $res->num_rows>1)
	{
			return false; 	
	}elseif($res->num_rows==1)
	{
		return true;	
	}


}

function inserisciUtente($cid,$email,$password,$confirmPwd,$nome,$cognome,$dataN,$cittaN,$provinciaN,$statoN,$cittaR,$provinciaR,$statoR) {	
	$risultato = array("status"=>"ok","tipoErrore"=>"", "contenuto"=>"");
	
	$errore=false;
	if($_SERVER["REQUEST_METHOD"] == "POST") {

	$nome = trim($nome);
    $cognome = trim($cognome);
	$cittaN = trim($cittaN);
	$provinciaN = trim($provinciaN);
	$statoN = trim($statoN);
	$cittaR = trim($cittaR);
	$provinciaR= trim($provinciaR);
	$statoR = trim($statoR);
	}
	$dati = array("email"=>$email,"pwd"=>$password,"confirmPwd"=>$confirmPwd,
			      "nome"=>$nome,"cognome"=>$cognome,"dataN"=>$dataN,
				  "cittaN"=>$cittaN,"provinciaN"=>$provinciaN,"statoN"=>$statoN,
				  "cittaR"=>$cittaR,"provinciaR"=>$provinciaR,"statoR"=>$statoR);

	$risultato["contenuto"]=$dati;

	$tipoErrore= array(
		"emptyFields",
		"passFormat","passNotSame", "validCittaN","validCittaR"
	);

    if ($cid == null || $cid->connect_errno) {
		$risultato["status"]="ko";
		if (!is_null($cid))
		     $risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		else $risultato["msg"]="errore nella connessione al db ";
		return $risultato;
	}

	if  (empty($email)|| empty($password) || empty($confirmPwd) || empty($nome) || empty($cognome) ||  empty($dataN) || empty($cittaN) || empty($provinciaN) || empty($statoN)|| empty($cittaR) || empty($provinciaR) || empty($statoR))
	{
		$errore = true;
	 	$tipoErrore["emptyFields"]="riempire tutti i campi";
	}
	
	if (strlen($password)<8 || !verificaPwd($password))
	{
		$errore = true;
		$tipoErrore["passFormat"]="La password deve essere di  almeno 8 caratteri, tra cui almeno una lettera maiuscola, un carattere speciale e un numero <br/>";

	}
	if ($password != $confirmPwd){
		$errore = true;
		$tipoErrore["passNotSame"] ="le due password non corrispondono";
	}
	if (!isCity($cid,$cittaN,$provinciaN,$statoN)){
		$tipoErrore["validCittaN"] = "inserire una città valida";
	}
	if (!isCity($cid,$cittaR,$provinciaR,$statoR)){
		$tipoErrore["validCittaR"] = "inserire una città valida";
	}
	$risultato["tipoErrore"]=$tipoErrore;
	if (!$errore)
	{
	   $sql = "INSERT INTO utente(email, password, nome,cognome,dataNascita,cittaN,provinciaN,statoN,cittaR,provinciaR,statoR) 
                    VALUES ('$email', '$password', '$nome','$cognome','$dataN','$cittaN','$provinciaN','$statoN','$cittaR','$provinciaR','$statoR');"; 
       $res=$cid->query($sql);
		// error_log("SQL Query: $sql", 3, "./sql_query.log");
	   if ($res==true){
			$risultato["status"] = "ok";

	   }
	   else
	   {
		   $risultato["status"]="ko";

	   }
	}
	else
	{
		$risultato["status"]="ko";
	}	
	return $risultato;
}

function inviaRichiestaAmicizia($cid, $mittente, $destinatario) {
    $risultato = array("status" => "ok", "tipoErrore" => "", "contenuto" => "");

    $errore = false;
    

    $dati = array(
    "mittente" => $mittente,
    "destinatario" => $destinatario );
    $risultato["contenuto"] = $dati;

    $tipoErrore = array(
        "emptyFields"
    );

    if ($cid == null || $cid->connect_errno) {
        $risultato["status"] = "ko";
        if (!is_null($cid))
            $risultato["msg"] = "Errore nella connessione al db " . $cid->connect_error;
        else $risultato["msg"] = "Errore nella connessione al db ";
        return $risultato;
    }
	
    if (empty($mittente) || empty($destinatario)) {
        $errore = true;
        $tipoErrore["emptyFields"] = "Qualcosa è andato storto";
    }

    $risultato["tipoErrore"] = $tipoErrore;

    if (!$errore) {
        $sql = "INSERT INTO richiestediamicizia(mittente, destinatario) 
                VALUES ('$mittente', '$destinatario');";

        $res = $cid->query($sql);
		//error_log("SQL Query: $sql", 3, "./log/sql_query_richiestediamicizia.log")
        if ($res == true) {
            $risultato["status"] = "ok";
            $risultato["msg"] = "Operazione di invio richiesta di amicizia conclusa con successo";
        } else {
            $risultato["status"] = "ko";
            $risultato["msg"] = "Operazione di invio richiesta di amicizia fallita";
        }
    }

    return $risultato;
}

function accettaRichiestaAmicizia($cid, $mittente, $destinatario) {
    $risultato = array("status" => "ok", "tipoErrore" => "", "contenuto" => "");

    $errore = false;
    

    $dati = array(
    "mittente" => $mittente,
    "destinatario" => $destinatario );
    $risultato["contenuto"] = $dati;

    $tipoErrore = array(
        "emptyFields"
    );

    if ($cid == null || $cid->connect_errno) {
        $risultato["status"] = "ko";
        if (!is_null($cid))
            $risultato["msg"] = "Errore nella connessione al db " . $cid->connect_error;
        else $risultato["msg"] = "Errore nella connessione al db ";
        return $risultato;
    }
	
    if (empty($mittente) || empty($destinatario)) {
        $errore = true;
        $tipoErrore["emptyFields"] = "Qualcosa è andato storto";
    }

    $risultato["tipoErrore"] = $tipoErrore;

    if (!$errore) {
        $sql = "UPDATE richiestediamicizia SET statoRichiesta = 'accettato' , timestampRisposta = NOW()
                WHERE mittente = '$destinatario' AND destinatario = '$mittente';";

        $res = $cid->query($sql);
		//error_log("SQL Query: $sql", 3, "./sql_query_richiestediamicizia.log");
        if ($res == true) {
            $risultato["status"] = "ok";
            $risultato["msg"] = "Operazione di accettazione richiesta di amicizia conclusa con successo";
        } else {
            $risultato["status"] = "ko";
            $risultato["msg"] = "Operazione di accettazione richiesta di amicizia fallita";
        }
    }

    return $risultato;
}

function rifiutaRichiestaAmicizia($cid, $mittente, $destinatario) {
    $risultato = array("status" => "ok", "tipoErrore" => "", "contenuto" => "");

    $errore = false;
    

    $dati = array(
    "mittente" => $mittente,
    "destinatario" => $destinatario );
    $risultato["contenuto"] = $dati;

    $tipoErrore = array(
        "emptyFields"
    );

    if ($cid == null || $cid->connect_errno) {
        $risultato["status"] = "ko";
        if (!is_null($cid))
            $risultato["msg"] = "Errore nella connessione al db " . $cid->connect_error;
        else $risultato["msg"] = "Errore nella connessione al db ";
        return $risultato;
    }
	
    if (empty($mittente) || empty($destinatario)) {
        $errore = true;
        $tipoErrore["emptyFields"] = "Qualcosa è andato storto";
    }

    $risultato["tipoErrore"] = $tipoErrore;

    if (!$errore) {
        $sql = "UPDATE richiestediamicizia SET statoRichiesta = 'rifiutato' , timestampRisposta = NOW()
                WHERE mittente = '$destinatario' AND destinatario = '$mittente';";

        $res = $cid->query($sql);
		//error_log("SQL Query: $sql", 3, "./log/sql_query_richiestediamicizia.log")
        if ($res == 1) {
            $risultato["status"] = "ok";
            $risultato["msg"] = "Operazione di rifiuto richiesta di amicizia conclusa con successo";
        } else {
            $risultato["status"] = "ko";
            $risultato["msg"] = "Operazione di rifiuto richiesta di amicizia fallita";
        }
    }

    return $risultato;
}

function inserisciPost($cid, $user, $testo, $citta, $prov, $stato, $nomeFile, $percorsoFile) {
    $risultato = array("msg" => "", "status" => "ok");

    if ($cid == null || $cid->connect_errno) {
        $risultato["status"] = "ko";
        if (!is_null($cid))
            $risultato["msg"] = "errore nella connessione al db " . $cid->connect_error;
        else $risultato["msg"] = "errore nella connessione al db ";
        return $risultato;
    }

    // Imposta il tipo a "immagine" se il percorso del file è presente
    if (!empty($nomeFile)) {
        $tipo = "immagine";
    } else {
        $tipo = "testo";
    }

    $percorsoFile = "../uploads/";

    // Costruisce la parte della query relativa a citta, prov, stato solo se i valori sono stati forniti
    $localizzazione = "";
	if (!empty($citta) && !empty($prov) && !empty($stato)) {
		$localizzazione = ", '$citta', '$prov', '$stato'";
		$sql = "INSERT INTO post(email, tipo, nomeFile, percorsoFile, testo, citta, provincia, stato) 
			VALUES ('$user', '$tipo', '$nomeFile', '$percorsoFile', '$testo'$localizzazione);";
	} else {
		$sql = "INSERT INTO post(email, tipo, nomeFile, percorsoFile, testo) 
			VALUES ('$user', '$tipo', '$nomeFile', '$percorsoFile', '$testo');";
	}

	
    //error_log("SQL Query: $sql", 3, "./sql_query_post.log");

    $res = $cid->query($sql);

    if ($res == null) {
        $msg = "Si sono verificati i seguenti errori:<br/>" . $cid->error;
        $risultato["status"] = "ko";
        $risultato["msg"] = $msg;
    } elseif ($res->num_rows == 0 || $res->num_rows > 1) {
        $msg = "caricamento non riuscito";
        $risultato["status"] = "ko";
        $risultato["msg"] = $msg;
    } elseif ($res->num_rows == 1) {
        $msg = "post caricato correttamente";
        $risultato["status"] = "ok";
        $risultato["msg"] = $msg;
    }

    return $risultato;
}

function inserisciCommento($cid, $timestamp, $email, $testoCommento, $autore){
	
   $sql =" INSERT INTO commento(timestampPublicazione, email, testo, autore) 
   VALUES ('$timestamp', '$email','$testoCommento', '$autore');";
   error_log("SQL Query: $sql", 3, "./sql_query_commento.log");
   $res = $cid->query($sql);
   	if ($res==null) 
	{
	        $msg = "Si sono verificati i seguenti errori:<br/>" 
     		. $cid->error;
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;			
	}elseif($res->num_rows==0 || $res->num_rows>1)
	{
			$msg = "caricamento non riuscito";
			$risultato["status"]="ko";
			$risultato["msg"]=$msg;		
	}elseif($res->num_rows==1)
	{
	    $msg = "commento caricato correttamente";
		$risultato["status"]="ok";
		$risultato["msg"]=$msg;		
	}
    return $risultato;

}


// indici di gradimento

function aumentaGradimentoPost($cid, $timestamp, $email){

	$sql ="UPDATE post
			SET indicediGradimento = indicediGradimento + 1
			WHERE timestampPubblicazione = '$timestamp' AND email = '$email';";
    $res = $cid->query($sql);
   	
	$nuovoIndice = ottieniNuovoIndiceDalDatabasePost($cid, $timestamp, $email);
	$risultato["nuovoIndice"] = $nuovoIndice; // Aggiungi il nuovo indice alla risposta
	return $risultato;

}
function diminuisciGradimentoPost($cid, $timestamp, $email){

	$sql ="UPDATE post
			SET indicediGradimento = indicediGradimento - 1
			WHERE timestampPubblicazione = '$timestamp' AND email = '$email';";
    //error_log("SQL Query: $sql", 3, "./sql_query_post-.log");
    $res = $cid->query($sql);
   	
	$nuovoIndice = ottieniNuovoIndiceDalDatabasePost($cid, $timestamp, $email);
	$risultato["nuovoIndice"] = $nuovoIndice; // Aggiungi il nuovo indice alla risposta
	return $risultato;

}
function ottieniNuovoIndiceDalDatabasePost($cid, $timestamp, $email) {
    $query = "SELECT indicediGradimento FROM post WHERE email = ? AND timestampPubblicazione = ?";
    //error_log("SQL Query: $query", 3, "./sql_query_trovaindice.log");

    $stmt = $cid->prepare($query);
    if (!$stmt) {
        //error_log("Errore nella preparazione della query: " . $cid->error, 3, "./sql_query_trovaindice.log");
        return null;
    }

    $stmt->bind_param("ss", $email, $timestamp);
    if (!$stmt->execute()) {
        error_log("Errore nell'esecuzione della query: " . $stmt->error, 3, "./sql_query_trovaindice.log");
        return null;
    }

    $stmt->bind_result($nuovoIndice);

    $stmt->fetch();
    
    $stmt->close();

    return $nuovoIndice;
}
function aumentaGradimentoCommento($cid, $timestamp, $email, $timestampC){

	$sql ="UPDATE commento
			SET indicediGradimento = indicediGradimento + 1
			WHERE timestampPublicazione = '$timestamp' AND email = '$email' AND timestampCommento='$timestampC';";
    //error_log("SQL Query: $sql", 3, "./sql_query_commento++.log");
    $res = $cid->query($sql);
    $nuovoIndice = ottieniNuovoIndiceDalDatabaseCommento($cid, $timestamp, $email, $timestampC);
	$risultato["nuovoIndice"] = $nuovoIndice;
	return $risultato;

}
function diminuisciGradimentoCommento($cid, $timestamp, $email, $timestampC){

	$sql ="UPDATE commento
			SET indicediGradimento = indicediGradimento - 1
			WHERE timestampPublicazione = '$timestamp' AND email = '$email' AND timestampCommento='$timestampC';";
    //error_log("SQL Query: $sql", 3, "./sql_query_commento--.log");
    $res = $cid->query($sql);
    $nuovoIndice = ottieniNuovoIndiceDalDatabaseCommento($cid, $timestamp, $email, $timestampC);
	$risultato["nuovoIndice"] = $nuovoIndice;
	return $risultato;
}

function ottieniNuovoIndiceDalDatabaseCommento($cid, $timestamp, $email, $timestampC) { 
    $query = "SELECT indicediGradimento, timestampPublicazione, email, timestampCommento FROM commento WHERE timestampPublicazione = ? AND email = ? AND timestampCommento = ?;";
    //error_log("SQL Query: $query", 3, "./ottieniNuovoIndiceDalDatabaseCommento.log");

    $stmt = $cid->prepare($query);
    if (!$stmt) {
        //error_log("Errore nella preparazione della query: " . $cid->error, 3, "./sql_query_trovaindice.log");
        return null;
    }

    $stmt->bind_param("sss", $timestamp, $email, $timestampC);
    if (!$stmt->execute()) {
        //error_log("Errore nell'esecuzione della query: " . $stmt->error, 3, "./sql_query_trovaindice.log");
        return null;
    }

    $stmt->bind_result($nuovoIndice, $timestamp, $email, $timestampC);

    // Fetch dei dati
    $stmt->fetch();
    
    $stmt->close();

    // Costruisce l'array in cui metto i dati
    $risultato = array(
        'nuovoIndice' => $nuovoIndice,
        'timestamp' => $timestamp,
        'email' => $email,
        'timestampC' => $timestampC
    );

    return json_encode($risultato);
}


function inserisciHobbyUtente($cid, $user, $hobby){

    $status = "ok";
    $msg = "";
	$ris = "";

    if ($cid == null || $cid->connect_errno) {
        $status = "ko";
        $msg = "Errore nella connessione al db " . ($cid ? $cid->connect_error : '');
        return compact('status', 'msg');
    }

    $sql = "INSERT INTO pratica (utente, hobby) VALUES (?, ?)";
    $stmt = $cid->prepare($sql);

    if (!$stmt) {
        $status = "ko";
        $msg = "Errore nella preparazione della query: " . $cid->error;
    } else {
        $stmt->bind_param("ss", $user, $hobby);
        $res = $stmt->execute();

        if (!$res) {
            $status = "ko";
            $msg = "Errore durante l'inserimento: " . $stmt->error;
        } else {
            $msg = "Hobby caricato correttamente";
        }

        $stmt->close();
    }

    return compact('status', 'msg');
}

function ottieniHobbyUtente($cid, $user) {

    $result = array("msg" => "", "status" => "ok", "hobby" => array());

    if ($cid == null || $cid->connect_errno) {
        $result['status'] = "ko";
        $result['msg'] = "Errore nella connessione al db " . ($cid ? $cid->connect_error : '');
        return $result;
    }

    $sql = "SELECT DISTINCT hobby FROM pratica WHERE utente = ?";
    $stmt = $cid->prepare($sql);

    if (!$stmt) {
        $result['status'] = "ko";
        $result['msg'] = "Errore nella preparazione della query: " . $cid->error;
    } else {
        $stmt->bind_param("s", $user);
        $res = $stmt->execute();

        if (!$res) {
            $result['status'] = "ko";
            $result['msg'] = "Errore durante l'esecuzione della query: " . $stmt->error;
        } else {
            $stmt->bind_result($hobby);

            while ($stmt->fetch()) {
                $result['hobby'][] = $hobby;
            }

            $result['msg'] = "Lista degli hobby ottenuta correttamente";
        }

        $stmt->close();
    }

    return $result;
}

function modificaUtente($cid, $utente, $email,$pwd,$confirmPwd,$nome,$cognome,$dataN,$cittaN,$provinciaN,$statoN,$cittaR,$provinciaR,$statoR,$orientamento)
{	
	$risultato = array("status"=>"ok","tipoErrore"=>"");
	
	$errore=false;
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	$oldemail = trim($utente);		
	$email=trim($email);
	$pwd=trim($pwd);
	$confirmPwd=trim($confirmPwd);
	$nome = trim($nome);
    $cognome = trim($cognome);
	$cittaN = trim($cittaN);
	$provinciaN = trim($provinciaN);
	$statoN = trim($statoN);
	$cittaR = trim($cittaR);
	$provinciaR= trim($provinciaR);
	$statoR = trim($statoR);
	$orientamento = trim($orientamento);
	}

	$tipoErrore= array(
		"passFormat","passNotSame", "validCittaN","validCittaR"
	);

    /* if ($cid == null || $cid->connect_errno) {
		$risultato["status"]="ko";
		if (!is_null($cid))
		     $risultato["msg"]="errore nella connessione al db " . $cid->connect_error;
		else $risultato["msg"]="errore nella connessione al db ";
		return $risultato;
	}
	
	if (strlen($pwd)<8 || !verificaPwd($pwd))
	{
		$errore = true;
		$tipoErrore["passFormat"]="La password deve essere di  almeno 8 caratteri, tra cui almeno una lettera maiuscola, un carattere speciale e un numero <br/>";

	}
	if ($password != $confirmPwd){
		$errore = true;
		$tipoErrore["passNotSame"] ="le due password non corrispondono";
	}
	if (!isCity($cid,$cittaN,$provinciaN,$statoN)){
		$tipoErrore["validCittaN"] = "inserire una città valida";
	}
	if (!isCity($cid,$cittaR,$provinciaR,$statoR)){
		$tipoErrore["validCittaR"] = "inserire una città valida";
	}
	$risultato["tipoErrore"]=$tipoErrore; */
	if (!$errore)
	{
	   $sql = "UPDATE utente 
			   SET email = '$email', password = '$pwd', nome = '$nome', cognome = '$cognome', dataNascita = '$dataN', cittaN = '$cittaN',
					provinciaN = '$provinciaN', statoN = '$statoN', cittaR = '$cittaR', provinciaR = '$provinciaR', statoR = '$statoR', orientamentoSessuale = '$orientamento'
				WHERE utente.email ='$oldemail'"; 
       $res=$cid->query($sql);
		 //error_log("SQL Query: $sql", 3, "./sql_query_modifica.log");
	   if ($res==true){
			$risultato["status"] = "ok";

	   }
	   else
	   {
		   $risultato["status"]="ko";

	   }
	}
	else
	{
		$risultato["status"]="ko";
	}	
	return $risultato;
}

function ottieniDatiUtente($cid, $user) {

    $result = array("msg" => "", "status" => "ok", "dati" => array());

    if ($cid == null || $cid->connect_errno) {
        $result['status'] = "ko";
        $result['msg'] = "Errore nella connessione al db " . ($cid ? $cid->connect_error : '');
        return $result;
    }

    $sql = "SELECT DISTINCT * FROM utente WHERE utente.email = ?";
    $stmt = $cid->prepare($sql);

    if (!$stmt) {
        $result['status'] = "ko";
        $result['msg'] = "Errore nella preparazione della query: " . $cid->error;
    } else {
        $stmt->bind_param("s", $user);
        $res = $stmt->execute();

        if (!$res) {
            $result['status'] = "ko";
            $result['msg'] = "Errore durante l'esecuzione della query: " . $stmt->error;
        } else {
            $stmt->bind_result($dati);

            while ($stmt->fetch()) {
                $result['dati'] = $dati;
            }

            $result['msg'] = "Lista dati utente ottenuta correttamente";
        }

        $stmt->close();
    }

    return $result;
}

function ottieniPassword($cid, $user) {

	$email = $user;
    $query = "SELECT password FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrae il valore della password e lo restituisce
        $row = $result->fetch_assoc();
        $value = $row['password'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}

function ottieniNome($cid, $user) {

	$email = $user;
    $query = "SELECT nome FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['nome'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}

function ottieniCognome($cid, $user) {

	$email = $user;
    $query = "SELECT cognome FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['cognome'];
        return $value;
    } else {
        return null;
    }

    // Chiudi lo statement
    $stmt->close();
}

function ottieniDataN($cid, $user) {

	$email = $user;
    $query = "SELECT dataNascita FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['dataNascita'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}

function ottieniOrientamento($cid, $user) {

	$email = $user;
    $query = "SELECT orientamentoSessuale FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['orientamentoSessuale'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}

function ottieniCittaR($cid, $user) {

	$email = $user;
    $query = "SELECT cittaR FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['cittaR'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}

function ottieniCittaN($cid, $user) {

	$email = $user;
    $query = "SELECT cittaN FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['cittaN'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}

function ottieniProvN($cid, $user) {

	$email = $user;
    $query = "SELECT provinciaN FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['provinciaN'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}

function ottieniProvR($cid, $user) {

	$email = $user;
    $query = "SELECT provinciaR FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['provinciaR'];
        return $value;
    } else {
        return null;
    }

    // Chiudi lo statement
    $stmt->close();
}

function ottieniStatoR($cid, $user) {

	$email = $user;
    $query = "SELECT statoR FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['statoR'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}

function ottieniStatoN($cid, $user) {

	$email = $user;
    $query = "SELECT statoN FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['statoN'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}


function ottieniPermessi($cid, $user) {

	$email = $user;
    $query = "SELECT permessi FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['permessi'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}

function eliminaUtente($cid, $utenteEliminato)
{
    //query per eliminare l'utente
    $query = "DELETE FROM utente WHERE email = ?;";

    $stmt = $cid->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $utenteEliminato);
        $stmt->execute();

        // Controlla se l'eliminazione ha avuto successo
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            $cid->close();
            return array('status' => 'ok', 'msg' => 'Eliminazione effettuata con successo.');
        } else {
            $stmt->close();
            $cid->close();
            return array('status' => 'ko', 'msg' => 'Eliminazione non riuscita');
        }
    } else {
        $cid->close();
        return array('status' => 'ko', 'msg' => 'Errore nella preparazione della query: ' . $cid->error);
    }
}
function isBlocked($cid,$user){
    $email = $user;
    $query = "SELECT bloccato FROM utente WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("s", $email);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    // Controlla se ci sono risultati
    if ($result->num_rows > 0) {
        // Estrai il valore della password e restituiscilo
        $row = $result->fetch_assoc();
        $value = $row['bloccato'];
        return $value;
    } else {
        return null;
    }

    $stmt->close();
}
function bloccaUtente($cid, $user) {
    $email = $user;
    $si = "si";

    $query = "UPDATE utente SET bloccato = ? WHERE email = ?";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("ss", $si, $email);
    
    $stmt->execute();

    $stmt->close();

    return "Operazione avvenuta con successo.";
}



function numeroPostPerGiorno($cid, $user,$start,$end) {
    // Ottenere la data di una settimana fa
    
    // Query per ottenere le statistiche dei post
    $query = "SELECT COUNT(*) AS numero_post
    FROM post
    WHERE email = ?
      AND timestampPubblicazione >=  ? -- Inizio intervallo
      AND timestampPubblicazione <= ?; -- Fine intervallo";
    
    $stmt = $cid->prepare($query);
    $stmt->bind_param("sss", $user, $start,$end);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $numeroPost = $row['numero_post'];

    $stmt->close();

    return $numeroPost;
}

function mean($array){
    print_r($array);
    $sum = 0;
    for ($i=1; $i <= count($array)  ; $i++) { 
         $sum = $sum + $array[$i];
    }
    return $sum / count($array);
}

function calcolaStatistichePost($cid,$user){
    $PostPerGiorno = array();
    // Itera sui giorni degli ultimi 7 giorni
    for ($i = 1; $i < 8; $i++) {

        $dataCorrente = new DateTime("-$i days"); // Genera la data corrente meno $i giorni
        $inizioGiorno = $dataCorrente->format('Y-m-d 00:00:00');
        $fineGiorno = $dataCorrente->format('Y-m-d 23:59:59');

        $PostPerGiorno[$i] = numeroPostPerGiorno($cid,$user,$inizioGiorno,$fineGiorno);
       
    }

    $min = min($PostPerGiorno);
    $max = max($PostPerGiorno);
    $mean = mean($PostPerGiorno);
    $statistichePost = array("min"=>$min,"max"=>$max,"mean"=>$mean);

    return $statistichePost;
}

function calcolatop5utenti($cid) {
    
    // Query per la top 5 utenti 
    $query = "SELECT email AS Utente, 
                COUNT(*) AS NumeroCommenti,
                SUM(indicediGradimento) AS GradimentoTotale
                FROM commento
                GROUP BY email
                ORDER BY GradimentoTotale DESC
                LIMIT 5;";
    
    $stmt = $cid->prepare($query);
    $stmt->execute();

    $result = $stmt->get_result();

    $top5 = array();

    // Ciclare sui risultati e aggiungere all'array
    while ($row = $result->fetch_assoc()) {
        $utente = $row['Utente'];
        $numeroCommenti = $row['NumeroCommenti'];
        $gradimentoTotale = $row['GradimentoTotale'];

        // Aggiungere i dati all'array
        $top5[] = array(
            'Utente' => $utente,
            'NumeroCommenti' => $numeroCommenti,
            'GradimentoTotale' => $gradimentoTotale
        );
    }

    $stmt->close();

    return $top5;
}

function calcolaRispettabilita($cid, $email) {
    // Query per la media degli indici di gradimento
    $query = "SELECT email, AVG(indicediGradimento) AS media_indice_gradimento
              FROM (
                    SELECT email, indicediGradimento AS indicediGradimento FROM post
                    WHERE email = ?
                    UNION ALL
                    SELECT autore AS email, indicediGradimento
                    FROM commento
                    WHERE autore = ?
                ) AS utente
              GROUP BY email;";

    $stmt = $cid->prepare($query);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $media_indice_gradimento = $row['media_indice_gradimento'];

    $stmt->close();
    return $media_indice_gradimento;
}
function decrementaIndice($cid, $email) {
    $updateQuery = "UPDATE utente
                    SET indiceRispettabilità = indiceRispettabilità - 1
                    WHERE email = ?";
    
    $stmtUpdate = $cid->prepare($updateQuery);
    $stmtUpdate->bind_param("s", $email);
    $stmtUpdate->execute();
    
    $stmtUpdate->close();

    $selectQuery = "SELECT indiceRispettabilità FROM utente WHERE email = ?";
    
    $stmtSelect = $cid->prepare($selectQuery);
    $stmtSelect->bind_param("s", $email);
    $stmtSelect->execute();
    
    $result = $stmtSelect->get_result();
    
    $row = $result->fetch_assoc();
    $nuova_rispettabilita = $row['indiceRispettabilità'];

    $stmtSelect->close();

    // Restituisce il nuovo valore dell'indice di rispettabilità
	return $nuova_rispettabilita;
}

function sbloccaUtente($cid, $email) {
    $updateQuery = "UPDATE utente
					SET bloccato = NULL,
						indiceRispettabilità = 5
					WHERE email = ?";
    
    $stmtUpdate = $cid->prepare($updateQuery);
    $stmtUpdate->bind_param("s", $email);
    $stmtUpdate->execute();
    
    $stmtUpdate->close();

    $selectQuery = "SELECT indiceRispettabilità FROM utente WHERE email = ?";
    
    $stmtSelect = $cid->prepare($selectQuery);
    $stmtSelect->bind_param("s", $email);
    $stmtSelect->execute();
    
    $result = $stmtSelect->get_result();
    
    $row = $result->fetch_assoc();
    $nuova_rispettabilita = $row['indiceRispettabilità'];

    $stmtSelect->close();

    // Restituisce il nuovo valore dell'indice di rispettabilità
	return $nuova_rispettabilita;
}