<?php
// Create a connection to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tngl";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted for adding a new customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    if ($_POST["action"] == "addCustomer") {
        $name = $_POST["name"];
        $address = $_POST["address"];
        $customerNumber = $_POST["customerNumber"];
        $meterSerialNumber = $_POST["meterSerialNumber"];

        $sql = "INSERT INTO customers (name, address, customer_number, meter_serial_number) VALUES ('$name', '$address', '$customerNumber', '$meterSerialNumber')";

        if ($conn->query($sql) === TRUE) {
            echo "Customer added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Check if the form is submitted for deleting a customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteCustomerId"])) {
    $customerId = $_POST["deleteCustomerId"];

    $sql = "DELETE FROM customers WHERE id = $customerId";

    if ($conn->query($sql) === TRUE) {
        echo "Customer deleted successfully";
    } else {
        echo "Error deleting customer: " . $conn->error;
    }
}

// Retrieve and display the list of customers
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td>" . $row["customer_number"] . "</td>";
        echo "<td>" . $row["meter_serial_number"] . "</td>";
        echo "<td><button class='btn btn-danger' onclick='deleteCustomer(" . $row["id"] . ")'>Delete</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No customers found</td></tr>";
}

$conn->close();
?>
