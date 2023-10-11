<?php
// POST Request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formfelder validieren und Whitespace entfernen
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]);
    $zip = trim($_POST["zip"]);
    $city = trim($_POST["city"]);
    $select_opt = trim($_POST["select_opt"]);
    $comment = trim($_POST["comment"]);

    // Prüfen, ob wichtige Felder ausgefüllt sind und die E-Mail-Adresse gültig ist
    if (empty($name) || empty($comment) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Setzen des HTTP-Statuscodes auf 400 (Bad Request)
        http_response_code(400);
        echo "Bitte füllen Sie das Formular aus und versuchen Sie es erneut.";
        exit;
    }

    // Empfänger-E-Mail-Adresse festlegen
    $recipient = "IOeztuerk@airplus.com";

    // E-Mail-Betreff erstellen
    $subject = "Kontaktanfrage von $name";

    // E-Mail-Inhalt erstellen
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Zip: $zip\n";
    $email_content .= "City: $city\n";
    $email_content .= "Country: $select_opt\n";
    $email_content .= "Comment:\n$comment\n";

    // E-Mail-Header erstellen
    $email_headers = "From: $name <$email>";

    // E-Mail senden
    $okk = mail($recipient, $subject, $email_content, $email_headers);

    if ($okk) {
        // Erfolg: HTTP-Statuscode auf 200 (OK) setzen
        http_response_code(200);
        echo "Vielen Dank! Ihre Nachricht wurde gesendet.";
    } else {
        // Fehler: HTTP-Statuscode auf 500 (Internal Server Error) setzen
        http_response_code(500);
        echo "Es ist ein Fehler aufgetreten, und wir konnten Ihre Nachricht nicht senden.";
    }
} else {
    // Kein POST-Request: HTTP-Statuscode auf 403 (Forbidden) setzen
    http_response_code(403);
    echo "Es gab ein Problem mit Ihrer Anfrage. Bitte versuchen Sie es erneut.";
}
?>
