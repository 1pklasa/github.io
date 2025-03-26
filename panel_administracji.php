<?php
$conn = new mysqli('localhost', 'root', '', 'uczni');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = $_POST["imie"];
    $nazwisko = $_POST["nazwisko"];
    $wiek = $_POST["wiek"];
    $zainteresowanie = $_POST["zainteresowanie"];
    $tytul_projektu = $_POST["tytul_projektu"];
    $opis_projektu = $_POST["opis_projektu"];

    $sql = "INSERT INTO uczniowie (imie, nazwisko, wiek, zainteresowanie, tytul_projektu, opis_projektu)
            VALUES ('$imie', '$nazwisko', $wiek, '$zainteresowanie', '$tytul_projektu', '$opis_projektu')";

    if ($conn->query($sql) === TRUE) {
        echo "Nowy uczeń został dodany!";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel Administracyjny</title>
</head>
<body>
    <h1>Dodaj Ucznia</h1>
    <form method="post" action="">
        <input type="text" name="imie" placeholder="Imię" required><br>
        <input type="text" name="nazwisko" placeholder="Nazwisko" required><br>
        <input type="number" name="wiek" placeholder="Wiek" required><br>
        <input type="text" name="zainteresowanie" placeholder="Zainteresowania"><br>
        <input type="text" name="tytul_projektu" placeholder="Tytuł Projektu"><br>
        <textarea name="opis_projektu" placeholder="Opis Projektu"></textarea><br>
        <input type="submit" value="Dodaj Ucznia">
    </form>
</body>
</html>
