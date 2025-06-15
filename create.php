<?php
require 'db.php';
$name = '';
$age = '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $age = (int)$_POST['age'];
        if (!$name) $errors[] = 'Name is required';
    if ($age < 60) $errors[] = 'Only users aged 60 and above can be added';

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO users (name, age) VALUES (?, ?)");
        $stmt->execute([$name, $age]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Senior</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Add Senior Citizen</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" class="row g-3">


        <div class="col-12">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="col-12">
            <label for="age" class="form-label">Age (60+ only)</label>
            <input type="number" class="form-control" name="age" id="age" value="<?= htmlspecialchars($age) ?>" min="60" required>
        </div>
                <div class="col-12">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>

