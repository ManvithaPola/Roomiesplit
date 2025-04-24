<?php
require_once __DIR__ . '\tcpdf\tcpdf.php';
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user & group info
$user_result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($user_result);
$group_id = $user['group_id'];

// Fetch expenses for group
$expenses_result = mysqli_query($conn, "
    SELECT e.id, u.name AS payer, e.amount, e.description, e.date 
    FROM expenses e 
    JOIN users u ON e.paid_by = u.id 
    WHERE u.group_id = '$group_id' 
    ORDER BY e.date DESC
");

// Create PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Title
$pdf->Cell(0, 10, 'RoomieSplit - Group Expenses Report', 0, 1, 'C');
$pdf->Ln(5);

// Table header
$html = '
<table border="1" cellpadding="5">
    <tr style="background-color:#99BC85; color:white;">
        <th><b>ID</b></th>
        <th><b>Date</b></th>
        <th><b>Payer</b></th>
        <th><b>Description</b></th>
        <th><b>Amount (₹)</b></th>
    </tr>';

// Table rows
while ($row = mysqli_fetch_assoc($expenses_result)) {
    $html .= '<tr>
        <td>' . $row['id'] . '</td>
        <td>' . date('d-m-Y', strtotime($row['date'])) . '</td>
        <td>' . htmlspecialchars($row['payer']) . '</td>
        <td>' . htmlspecialchars($row['description']) . '</td>
        <td>' . number_format($row['amount'], 2) . '</td>
    </tr>';
}

$html .= '</table>';

// Output table
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('Group_Expenses_Report.pdf', 'I');
?>
