

<?php

require('../database/db_connect.php'); // Kopplar till databasen

?>


<!DOCTYPE html>

<html lang="sv">

<head>

   <meta charset="UTF-8">

   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Produktöversikt</title>



  <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <header>

       <h1>Våra Produkter</h1>

   </header>


   <main>

       <?php

       // Hämta alla produkter från databasen

       $sql = "SELECT * FROM products";

       $result = $conn->query($sql);


       if ($result->num_rows > 0) {

           // Om vi har produkter, visa dem

           while ($row = $result->fetch_assoc()) {

               echo "<div class='product'>";

               echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";

               echo "<p>" . htmlspecialchars($row['description']) . "</p>";

               echo "<p>Pris: " . htmlspecialchars($row['price']) . " SEK</p>";


               // Länk runt bilden

               echo "<div class='product-container'>";

               echo "<a href='product.php?id=" . $row['id'] . "'>";

               echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "' class='product-image' />";

               echo "</a>";

               echo "</div>";

               


               // Formulär för att lägga till produkten i varukorgen

               echo "<form method='post' action='checkout.php'>";

               echo "<input type='hidden' name='product_id' value='" . $row['id'] . "' />";

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

           }

       } else {

           echo "Inga produkter tillgängliga.";

       }


       // Stäng anslutningen

       $conn->close();

       ?>

   </main>


   <footer>

       <p>&copy; 2024 Webbshop</p>

   </footer>

</body>

</html>

