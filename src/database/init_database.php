<?php

include_once('db_connect.php');

$sql = "CREATE TABLE IF NOT EXISTS customers (
id INT AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(200) NOT NULL,
last_name VARCHAR(200) NOT NULL,
phone VARCHAR(200) NOT NULL,
address VARCHAR(200) NOT NULL,
postal_code VARCHAR(10) NOT NULL,
city VARCHAR(200) NOT NULL,
email VARCHAR(200) NOT NULL 
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'customers' successfully.<br>";
} else {
    echo "Error creating table 'customers': " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS products (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(200) NOT NULL,
description TEXT,
price DECIMAL(10, 2) NOT NULL,
image_url VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'products' created successfully.<br>";
} else {
    echo "Error creating table 'products': " . $conn->error;
}


$sql = "CREATE TABLE IF NOT EXISTS orders (
id INT AUTO_INCREMENT PRIMARY KEY,
customer_id INT NOT NULL,
order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
total_amount DECIMAL(10, 2) NOT NULL,
status VARCHAR(50) DEFAULT 'Ordered',
FOREIGN KEY (customer_id) REFERENCES customers(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'orders' created successfully.<br>";
} else {
    echo "Error creating table 'orders': " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS order_items (
id INT AUTO_INCREMENT PRIMARY KEY,
order_id INT NOT NULL,
product_id INT NOT NULL,
quantity INT NOT NULL,
amount DECIMAL(10, 2) NOT NULL,
FOREIGN KEY (order_id) REFERENCES orders(id),
FOREIGN KEY (product_id) REFERENCES products(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'order_items' created successfully.<br>";
} else {
    echo "Error creating table 'order_items': " . $conn->error;
}

$conn->close();
?>