<?php
require 'db.php';

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename="senior_users_export.csv"");

$output = fopen("php://output", "w");
fputcsv($output, ['ID', 'Name', 'Age', 'Health Concern']);

$stmt = $pdo->query("SELECT * FROM users WHERE age >= 60");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [$row['id'], $row['name'], $row['age'], $row['health_concern']]);
}

fclose($output);
exit;
