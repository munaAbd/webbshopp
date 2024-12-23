<?php

require('../database/db_connect.php');

if (isset($_GET['id'])) {

   $order_id = $_GET['id'];

   // Hämta aktuell status för ordern

   $stmt = $conn->prepare("SELECT status FROM orders WHERE id = ?");

   $stmt->bind_param("i", $order_id);

   $stmt->execute();

   $result = $stmt->get_result();

   $order = $result->fetch_assoc();

   if ($order) {

       // Visa nuvarande status och möjlighet att uppdatera

       echo "<h3>Order-ID: " . $order_id . "</h3>";

       echo "<p>Aktuell status: " . htmlspecialchars($order['status']) . "</p>";

       // Formulär för att uppdatera orderstatus

       echo "<form method='post' action=''>";

       echo "<label for='status'>Ny status:</label><br>";

       echo "<select name='status'>

               <option value='Ordered'>Beställd</option>

               <option value='Packed'>Packad</option>

               <option value='Shipped'>Skickad</option>

               <option value='Paid'>Betald</option>

             </select><br>";

       echo "<input type='submit' value='Uppdatera status'>";

       echo "</form>";

       

       // Om formuläret är skickat, uppdatera status

       if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {

           $new_status = $_POST['status'];

           $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");

           $stmt->bind_param("si", $new_status, $order_id);

           $stmt->execute();


           echo "Orderstatus har uppdaterats till: " . $new_status;

       }

   } else {

       echo "Ingen order hittades med detta ID.";

   }

}

?>

