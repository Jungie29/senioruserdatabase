<?php
require 'db.php';

$search = $_GET['search'] ?? '';
$minAge = $_GET['min_age'] ?? '';
$maxAge = $_GET['max_age'] ?? '';

$sql = "SELECT * FROM users WHERE age >= 60";
$params = [];

if ($search) {
    $sql .= " AND name LIKE ?";
    $params[] = "%$search%";
}
if ($minAge) {
    $sql .= " AND age >= ?";
    $params[] = $minAge;
}
if ($maxAge) {
    $sql .= " AND age <= ?";
    $params[] = $maxAge;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple Senior Citizen Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Simple Senior Citizen Database</h1>

<form method="get">
    <input type="text" name="search" placeholder="Search by name" value="<?= htmlspecialchars($search) ?>">
    <input type="number" name="min_age" placeholder="Min age" value="<?= htmlspecialchars($minAge) ?>">
    <input type="number" name="max_age" placeholder="Max age" value="<?= htmlspecialchars($maxAge) ?>">
    <button type="submit">Filter</button>
    <a href="create.php">Add New</a>
</form>

<table>
    <tr><th>ID</th><th>Name</th><th>Age</th><th>Actions</th></tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= $user['age'] ?></td>
        <td>
            <a href="edit.php?id=<?= $user['id'] ?>">Edit</a> |
            <a href="delete.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach ?>
</table>
</body>
</html>