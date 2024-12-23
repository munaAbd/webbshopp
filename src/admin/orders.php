<?php

require('../database/db_connect.php');


// Hämta alla ordrar med kund- och produktinformation

$sql = "SELECT 

           o.id AS order_id, 

           o.order_date, 

           o.status AS order_status, 

           o.total_amount,

           c.first_name, c.last_name, c.phone, c.address, c.postal_code, c.city, c.email,

           oi.quantity, oi.amount, p.name AS product_name, p.description AS product_description, p.image_url AS product_image

       FROM orders o

       JOIN customers c ON o.customer_id = c.id

       JOIN order_items oi ON o.id = oi.order_id

       JOIN products p ON oi.product_id = p.id

       ORDER BY o.order_date DESC";

$result = $conn->query($sql);


if ($result->num_rows > 0) {

   // Lista alla ordrar

   while ($row = $result->fetch_assoc()) {

       echo "<div>";

       echo "<h2>Order-ID: " . $row['order_id'] . "</h2>";

       echo "<p>Status: " . $row['order_status'] . "</p>";

       echo "<p>Totalbelopp: " . $row['total_amount'] . " SEK</p>";

       echo "<p>Orderdatum: " . $row['order_date'] . "</p>";

       

       // Visa kundens information

       echo "<h3>Kundinformation</h3>";

       echo "<p><strong>Namnet:</strong> " . $row['first_name'] . " " . $row['last_name'] . "</p>";

       echo "<p><strong>Telefon:</strong> " . $row['phone'] . "</p>";

       echo "<p><strong>Adress:</strong> " . $row['address'] . "</p>";

       echo "<p><strong>Postnummer:</strong> " . $row['postal_code'] . "</p>";

       echo "<p><strong>Stad:</strong> " . $row['city'] . "</p>";

       echo "<p><strong>E-post:</strong> " . $row['email'] . "</p>";


       // Visa produktinformation

       echo "<h3>Produkter i ordern</h3>";

       echo "<p><strong>Produkt:</strong> " . $row['product_name'] . "</p>";

       echo "<p><strong>Beskrivning:</strong> " . $row['product_description'] . "</p>";

       echo "<p><strong>Antal:</strong> " . $row['quantity'] . "</p>";

       echo "<p><strong>Pris:</strong> " . $row['amount'] . " SEK</p>";

       echo "<img src='" . $row['product_image'] . "' alt='" . $row['product_name'] . "' style='width:100px; height:auto;' />";

       

       // Lägg till länkar för att uppdatera orderstatus och ta bort order

       echo "<br><br>";

       echo "<a href='update_order.php?id=" . $row['order_id'] . "'>Uppdatera status</a> | ";

       echo "<a href='delete_order.php?id=" . $row['order_id'] . "'>Ta bort order</a>";

       

       echo "<hr>";

       echo "</div>";

   }

} else {

   echo "Inga ordrar.";

}


$conn->close();

?>