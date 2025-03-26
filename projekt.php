<?php
$conn = new mysqli('localhost', 'root', '', 'uczni');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$projekt_id = $_GET['id']; // Get the project ID from URL
$sql = "SELECT * FROM projekty WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $projekt_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $project = $result->fetch_assoc();
    echo "<h1>" . $project['tytul_projektu'] . "</h1>";
    echo "<p>" . $project['opis_projektu'] . "</p>";
    if (!empty($project['obraz'])) {
        echo "<img src='" . $project['obraz'] . "' alt='Project Image'>";
    }
} else {
    echo "Projekt nie znaleziono.";
}
$conn->close();
?>
