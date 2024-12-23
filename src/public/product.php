<?php

require('../database/db_connect.php'); // Kopplar till databasen

?>


<!DOCTYPE html>

<html lang="sv">

<head>

   <meta charset="UTF-8">

   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Produktdetaljer</title>

   <link rel="stylesheet" href="css/style.css"> <!-- Länka till din CSS-fil -->

</head>

<body>

   <header>

       <h1>Produktdetaljer</h1>

   </header>


   <main>

       <?php

       if (isset($_GET['id'])) {

           $product_id = $_GET['id'];


           // Hämta produktinformation

           $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");

           $stmt->bind_param("i", $product_id);

           $stmt->execute();

           $result = $stmt->get_result();


           if ($result->num_rows > 0) {

               $product = $result->fetch_assoc();

               echo "<div class='product-detail'>";

               echo "<h2>" . htmlspecialchars($product['name']) . "</h2>";

               echo "<p><strong>Pris:</strong> " . htmlspecialchars($product['price']) . " SEK</p>";

               echo "<img src='" . htmlspecialchars($product['image_url']) . "' alt='" . htmlspecialchars($product['name']) . "' class='product-image' />";


               // Visa kort beskrivning (existerande beskrivning från databasen)

               echo "<h3>Beskrivning</h3>";

               echo "<p>" . nl2br(htmlspecialchars($product['description'])) . "</p>";


               // Visa detaljerad beskrivning (nytt fält från databasen)

               if (!empty($product['detailed_description'])) {

                   echo "<h3>Detaljerad Beskrivning</h3>";

                   echo "<p>" . nl2br(htmlspecialchars($product['detailed_description'])) . "</p>";

               }


               // Formulär för att lägga till produkten i varukorgen

               echo "<form method='post' action='checkout.php'>";

               echo "<input type='hidden' name='product_id' value='" . $product['id'] . "' />";

               echo "<label for='quantity'>Antal:</label><input type='number' name='quantity' min='1' value='1' required /><br>";


               // Kunduppgifter (lägg till dessa fält till formuläret)

               echo "<label for='first_name'>Förnamn:</label><input type='text' name='first_name' required /><br>";

               echo "<label for='last_name'>Efternamn:</label><input type='text' name='last_name' required /><br>";

               echo "<label for='phone'>Telefon:</label><input type='text' name='phone' required /><br>";

               echo "<label for='address'>Adress:</label><input type='text' name='address' required /><br>";

               echo "<label for='postal_code'>Postnummer:</label><input type='text' name='postal_code' required /><br>";

               echo "<label for='city'>Stad:</label><input type='text' name='city' required /><br>";

               echo "<label for='email'>E-post:</label><input type='email' name='email' required /><br>";


               // Skicka-knapp för formuläret

               echo "<input type='submit' value='Lägg i varukorg'>";

               echo "</form>";

               echo "</div>";

           } else {

               echo "Produkt hittades inte.";

           }

       } else {

           echo "Ingen produkt vald.";

       }

       ?>


   </main>


   <footer>

       <p>&copy; 2024 Webbshop</p>

   </footer>

</body>

</html>
