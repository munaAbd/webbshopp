<?php

session_start();  // Starta sessionen om den inte redan är igång


// Kontrollera om användaren har genomfört en order

if (!isset($_SESSION['order_confirmed']) || $_SESSION['order_confirmed'] !== true) {

   // Om sessionen inte finns, skicka användaren tillbaka till startsidan eller en annan sida

   header('Location: /index.php');  // Omdirigera till startsidan (ändra vägen om nödvändigt)

   exit;  // Avsluta skriptet för att förhindra vidare körning

}


// Om användaren har genomfört en order, visa orderbekräftelsen

?>

<!DOCTYPE html>

<html lang="sv">

<head>

   <meta charset="UTF-8">

   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Orderbekräftelse</title>

</head>

<body>

   <h1>Din order är bekräftad!</h1>

   <p>Tack för din beställning! Du kommer att få en bekräftelse via e-post.</p>

   <?php

   // Rensa sessionen efter att orderbekräftelsen har visats

   session_unset();  // Ta bort alla sessionvariabler

   session_destroy();  // Stäng av sessionen helt

   ?>

</body>

</html>
