<?php
// =================================================================
// 1. CONFIGURAZIONE
// =================================================================

// IL TUO INDIRIZZO EMAIL: SOSTITUISCI QUI!
$destinatario = "studiotecnicofarina@outlook.it"; 
$oggetto = "Nuova Richiesta Modulo Servizi";

// =================================================================
// 2. FUNZIONE DI SANIFICAZIONE E RACCOLTA DATI
// =================================================================

// Pulisce l'input per sicurezza
function pulisci_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Raccolta Campi Testo
$nome = pulisci_input(isset($_POST['nome']) ? $_POST['nome'] : 'N/A');
$cognome = pulisci_input(isset($_POST['cognome']) ? $_POST['cognome'] : 'N/A');
$email = pulisci_input(isset($_POST['email']) ? $_POST['email'] : 'N/A');
$data_nascita = pulisci_input(isset($_POST['data_nascita']) ? $_POST['data_nascita'] : 'N/A');
$telefono = pulisci_input(isset($_POST['telefono']) ? $_POST['telefono'] : 'N/A');
$indirizzo1 = pulisci_input(isset($_POST['indirizzo_1']) ? $_POST['indirizzo_1'] : 'N/A');
$indirizzo2 = pulisci_input(isset($_POST['indirizzo_2']) ? $_POST['indirizzo_2'] : 'N/A');

// Raccolta Campo Radio
$tutor_online = pulisci_input(isset($_POST['tutor_online']) ? $_POST['tutor_online'] : 'Non selezionato');

// Raccolta Campi Checkbox
if (isset($_POST['servizi']) && is_array($_POST['servizi'])) {
    $servizi_selezionati = array_map('pulisci_input', $_POST['servizi']);
    // Formatta la lista con un trattino e a capo
    $servizi_richiesti = "\n- " . implode("\n- ", $servizi_selezionati);
} else {
    $servizi_richiesti = "Nessun servizio specifico selezionato.";
}
// =================================================================
// 3. COSTRUZIONE DELL'EMAIL (A scopo di debug
$messaggio = "Hai ricevuto una nuova richiesta dal modulo servizi:\n\n";
$messaggio .= "================= DATI UTENTE =================\n";
$messaggio .= "Nome e Cognome: " . $nome . " " . $cognome . "\n";
$messaggio .= "Email: " . $email . "\n";
$messaggio .= "Telefono: " . $telefono . "\n";
$messaggio .= "Data di Nascita: " . $data_nascita . "\n";
$messaggio .= "Indirizzo (1): " . $indirizzo1 . "\n";
$messaggio .= "Indirizzo (2): " . $indirizzo2 . "\n\n";

$messaggio .= "================= RICHIESTE =================\n";
$messaggio .= "Tutor Online: " . $tutor_online . "\n";
$messaggio .= "Servizi Richiesti:\n" . $servizi_richiesti . "\n\n";
$messaggio .= "---------------------------------------------------\n";
$messaggio .= "Data/Ora Invio: " . date("d-m-Y H:i:s");


// =================================================================
// 4. INTESTAZIONI EMAIL (Necessarie per la costruzione del messaggio, anche se non inviamo)
// =================================================================
$headers = "From: Modulo Servizi <noreply@tuosito.com>\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";


// =================================================================
// 5. INVIO E REINDIRIZZAMENTO (VERSIONE DI TEST XAMPP)
// =================================================================

// Ignoriamo la funzione mail() per evitare l'errore del server di posta locale non configurato.

if (true) { 
    // DEBUG: Se vuoi vedere i dati, decommenta la riga sotto e commenta header()
    // echo "<h1>DEBUG: Invio simulato con successo!</h1><pre>"; print_r($messaggio); echo "</pre>";
    
    // Forziamo il reindirizzamento alla pagina di ringraziamento
    header("Location: grazie.html"); 
    exit;
} else {
    // Questo blocco non verrà mai raggiunto, ma è qui per completezza
    echo "Errore imprevisto nel test di reindirizzamento.";
}

/* * NOTE PER IL DEPLOYMENT (ONLINE):
 * Quando caricherai il file su un hosting professionale, SOSTITUISCI la sezione 5 
 * con il codice originale che include la funzione mail() per attivare l'invio reale.
*/

?>