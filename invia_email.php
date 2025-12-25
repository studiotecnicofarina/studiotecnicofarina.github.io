<?php
// =================================================================
// 1. CONFIGURAZIONE
// =================================================================
$destinatario = "studiotecnicofarina@outlook.it"; 
$oggetto = "Nuova Richiesta Modulo Servizi";

// =================================================================
// 2. FUNZIONE DI SANIFICAZIONE
// =================================================================
function pulisci_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// =================================================================
// 3. RACCOLTA DATI (Uso dell'operatore null coalescing ?? per pulizia)
// =================================================================
$nome         = pulisci_input($_POST['nome'] ?? 'N/A');
$cognome      = pulisci_input($_POST['cognome'] ?? 'N/A');
$email        = pulisci_input($_POST['email'] ?? 'N/A');
$data_nascita = pulisci_input($_POST['data_nascita'] ?? 'N/A');
$telefono     = pulisci_input($_POST['telefono'] ?? 'N/A');
$indirizzo1   = pulisci_input($_POST['indirizzo_1'] ?? 'N/A');

// Gestione Checkbox Servizi
if (isset($_POST['servizi']) && is_array($_POST['servizi'])) {
    $servizi_selezionati = array_map('pulisci_input', $_POST['servizi']);
    $servizi_richiesti = "\n- " . implode("\n- ", $servizi_selezionati);
} else {
    $servizi_richiesti = "Nessun servizio selezionato.";
}

// =================================================================
// 4. COSTRUZIONE MESSAGGIO
// =================================================================
$corpo_messaggio = "Hai ricevuto una nuova richiesta dal sito:\n\n";
$corpo_messaggio .= "Dati Utente:\n";
$corpo_messaggio .= "---------------------------\n";
$corpo_messaggio .= "Nome: $nome $cognome\n";
$corpo_messaggio .= "Email: $email\n";
$corpo_messaggio .= "Telefono: $telefono\n";
$corpo_messaggio .= "Data di Nascita: $data_nascita\n";
$corpo_messaggio .= "Indirizzo: $indirizzo1\n\n";
$corpo_messaggio .= "Servizi richiesti:$servizi_richiesti\n\n";
$corpo_messaggio .= "---------------------------\n";
$corpo_messaggio .= "Inviato il: " . date("d/m/Y alle H:i");

// =================================================================
// 5. INTESTAZIONI (HEADERS)
// =================================================================
$headers = "From: Modulo Sito <studiotecnicofarina@outlook.it>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// =================================================================
// 6. INVIO E REINDIRIZZAMENTO
// =================================================================
if (mail($destinatario, $oggetto, $corpo_messaggio, $headers)) {
    // Se l'invio ha successo, prova a rimandare a grazie.html 
    // Se grazie.html non esiste ancora, mostrerà il messaggio testuale sotto.
    if (file_exists('grazie.html')) {
        header("Location: grazie.html");
        exit;
    } else {
        echo "<h1>Richiesta inviata con successo!</h1>";
        echo "<p>Grazie $nome, ti ricontatteremo al più presto.</p>";
        echo "<a href='index.html'>Torna alla Home</a>";
    }
} else {
    echo "<h1>Errore nell'invio</h1>";
    echo "<p>Ci scusiamo, ma si è verificato un problema tecnico. Riprova più tardi.</p>";
}
?>

