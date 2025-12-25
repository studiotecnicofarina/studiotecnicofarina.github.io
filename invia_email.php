<?php
// 1. CONFIGURAZIONE
$destinatario = "studiotecnicofarina@outlook.it"; 
$oggetto = "Nuova Richiesta Modulo Servizi";

// 2. FUNZIONE DI SANIFICAZIONE
function pulisci_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// 3. RACCOLTA DATI
$nome = pulisci_input($_POST['nome'] ?? 'N/A');
$cognome = pulisci_input($_POST['cognome'] ?? 'N/A');
$email = pulisci_input($_POST['email'] ?? 'N/A');
$data_nascita = pulisci_input($_POST['data_nascita'] ?? 'N/A');
$telefono = pulisci_input($_POST['telefono'] ?? 'N/A');
$indirizzo1 = pulisci_input($_POST['indirizzo_1'] ?? 'N/A');

// Servizi Checkbox
if (isset($_POST['servizi']) && is_array($_POST['servizi'])) {
    $servizi_selezionati = array_map('pulisci_input', $_POST['servizi']);
    $servizi_richiesti = "\n- " . implode("\n- ", $servizi_selezionati);
} else {
    $servizi_richiesti = "Nessun servizio selezionato.";
}

// 4. COSTRUZIONE MESSAGGIO
$messaggio = "Hai ricevuto una nuova richiesta:\n\n";
$messaggio .= "Nome: $nome $cognome\n";
$messaggio .= "Email: $email\n";
$messaggio .= "Telefono: $telefono\n";
$messaggio .= "Data Nascita: $data_nascita\n";
$messaggio .= "Indirizzo: $indirizzo1\n\n";
$messaggio .= "SERVIZI RICHIESTI: $servizi_richiesti\n";

// 5. INTESTAZIONI (HEADERS)
// IMPORTANTE: Usa un'email del tuo dominio se possibile, o la stessa del destinatario per evitare filtri spam
$headers = "From: Modulo Sito <studiotecnicofarina@outlook.it>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// 6. INVIO REALE
if (mail($destinatario, $oggetto, $messaggio, $headers)) {
    // Se l'invio riesce, mostra un messaggio o rimanda a una pagina
    echo "<h1>Grazie! Il modulo è stato inviato correttamente.</h1>";
    echo "<p>Sarai ricontattato al più presto. <a href='index.html'>Torna alla Home</a></p>";
} else {
    echo "Errore nell'invio dell'email. Per favore riprova più tardi.";
}
?>
