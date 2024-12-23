<?php

require('../database/db_connect.php');


if (isset($_GET['id'])) {

   $order_id = $_GET['id'];


   // Börja med att ta bort poster från order_items

   $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");

   $stmt->bind_param("i", $order_id);

   $stmt->execute();

   

   // Ta sedan bort ordern från orders-tabellen

   $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");

   $stmt->bind_param("i", $order_id);

   $stmt->execute();


   echo "Ordern och dess relaterade poster har raderats.";

} else {

   echo "Ingen order-ID angavs.";

}


?>