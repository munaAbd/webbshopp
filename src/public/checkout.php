<?php

// Starta sessionen så tidigt som möjligt

session_start();  // Starta sessionen om den inte redan är igång


require('../database/db_connect.php');


// Efter att ordern har genomförts (t.ex. när betalning har bekräftats):

$_SESSION['order_confirmed'] = true;  // Sätt en sessionvariabel för att indikera att ordern har bekräftats


// Om formuläret skickas via POST

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   // Hämta kundinformation och varukorgsinformation från formuläret

   $first_name = $_POST['first_name'];

   $last_name = $_POST['last_name'];

   $phone = $_POST['phone'];

   $address = $_POST['address'];

   $postal_code = $_POST['postal_code'];

   $city = $_POST['city'];

   $email = $_POST['email'];

   $product_id = $_POST['product_id'];

   $quantity = $_POST['quantity'];


   // Kontrollera att alla nödvändiga fält är ifyllda

   if (empty($first_name) || empty($last_name) || empty($phone) || empty($address) || empty($postal_code) || empty($city) || empty($email)) {

       echo "Alla fält måste fyllas i!";

       exit;

   }


   // Lägg till kunden i databasen (undvik duplicering av kunder om du vill)

   $stmt = $conn->prepare("INSERT INTO customers (first_name, last_name, phone, address, postal_code, city, email) VALUES (?, ?, ?, ?, ?, ?, ?)");

   $stmt->bind_param("sssssss", $first_name, $last_name, $phone, $address, $postal_code, $city, $email);

   $stmt->execute();

   $customer_id = $stmt->insert_id; // Få kundens ID från det nyss skapade kundregistret


   // Hämta produktinformation och beräkna totalbelopp

   $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");

   $stmt->bind_param("i", $product_id);

   $stmt->execute();

   $result = $stmt->get_result();

   $product = $result->fetch_assoc();

   $total_amount = $product['price'] * $quantity;


   // Skapa en order

   $stmt = $conn->prepare("INSERT INTO orders (customer_id, total_amount) VALUES (?, ?)");

   $stmt->bind_param("id", $customer_id, $total_amount);

   $stmt->execute();

   $order_id = $stmt->insert_id;


   // Lägg till orderrader (produkter i ordern)

   $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, amount) VALUES (?, ?, ?, ?)");

   $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $product['price']);

   $stmt->execute();


   // Bekräfta order

   echo "Order har lagts! Din order-ID är " . $order_id;

   echo "<br><a href='order_confirmed.php'>Till orderbekräftelse</a>";

} else {

   echo "Ingen order har lagts ännu.";

}

?>

