<?php
// Database connection
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "kahuta_travels"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cnic = $_POST['cnic'];
    $phone = $_POST['phone'];
    $travel_date = $_POST['travel-date'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $travel_class = $_POST['class'];
    $seat_number = rand(1, 50);  // Generate random seat number
    
    // Calculate bill based on travel class and route
    $route = $origin . '-' . $destination;
    $bill = ($travel_class == 'business') ? 
            (($route == 'islamabad-karachi' || $route == 'karachi-islamabad') ? 8000 : 6000) :
            (($route == 'islamabad-karachi' || $route == 'karachi-islamabad') ? 4000 : 3000);

    // Insert data into database
    $sql = "INSERT INTO reservations (cnic, phone, travel_date, origin, destination, travel_class, seat_number, bill)
            VALUES ('$cnic', '$phone', '$travel_date', '$origin', '$destination', '$travel_class', $seat_number, $bill)";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully, prepare PDF
        require('fpdf.php');  // Make sure fpdf.php is in the same directory

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Reservation Details');
        $pdf->Ln();
        $pdf->Cell(40, 10, "CNIC: $cnic");
        $pdf->Ln();
        $pdf->Cell(40, 10, "Phone: $phone");
        $pdf->Ln();
        $pdf->Cell(40, 10, "Travel Date: $travel_date");
        $pdf->Ln();
        $pdf->Cell(40, 10, "Origin: $origin");
        $pdf->Ln();
        $pdf->Cell(40, 10, "Destination: $destination");
        $pdf->Ln();
        $pdf->Cell(40, 10, "Class: $travel_class");
        $pdf->Ln();
        $pdf->Cell(40, 10, "Seat Number: $seat_number");
        $pdf->Ln();
        $pdf->Cell(40, 10, "Bill: Rs $bill");
        $pdf->Output('reservation-details.pdf', 'D');  // Download the PDF
        
        // Display success message or redirect
        echo '<script>alert("Reservation Successful! PDF downloaded."); window.location.href = "index.html";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
