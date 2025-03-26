<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uczen_id = $_POST['id']; // Selected student's ID
    $tytul = $_POST['tytul']; // Project title
    $tresc = $_POST['tresc']; // Project description
    $obraz = '';

    // Ensure the 'uploads/' directory exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Handle file upload
    if (!empty($_FILES['obraz']['name'])) {
        $obraz = 'uploads/' . basename($_FILES['obraz']['name']);
        if (!move_uploaded_file($_FILES['obraz']['tmp_name'], $obraz)) {
            die("File upload failed.");
        }
    }

    try {
        // Insert the project and associate it with the selected student
        $stmt = $pdo->prepare("INSERT INTO projekty (uczen_id, tytul_projektu, opis_projektu, obraz) VALUES (?, ?, ?, ?)");
        $stmt->execute([$uczen_id, $tytul, $tresc, $obraz]);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }

    header("Location: index.php");
    exit;
}

// Retrieve students for the dropdown
$uczniowie = $pdo->query("SELECT * FROM uczniowie")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj wpis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Dodaj nowy projekt</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Wybierz ucznia:</label>
            <select name="id" class="form-control" required>
                <?php foreach ($uczniowie as $uczen): ?>
                    <option value="<?= $uczen['id'] ?>"><?= htmlspecialchars($uczen['imie']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tytuł projektu:</label>
            <input type="text" name="tytul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Treść projektu:</label>
            <textarea name="tresc" class="form-control" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Obraz:</label>
            <input type="file" name="obraz" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Dodaj projekt</button>
    </form>
</div>
</body>
</html>
