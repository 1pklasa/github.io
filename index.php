<?php
$conn = new mysqli('localhost', 'root', '', 'uczni');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch students and their projects
$sql = "SELECT uczniowie.id AS uczen_id, uczniowie.imie, uczniowie.nazwisko, uczniowie.wiek, uczniowie.Zainteresowanie, projekty.id AS projekt_id, projekty.tytul_projektu 
        FROM uczniowie
        LEFT JOIN projekty ON uczniowie.id = projekty.uczen_id";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Uczniów</title>
    <style>
        body {
            background-color: #0c0c0c;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
            color: white;
        }
        .profile-panel {
            background-color: #111111;
            width: 600px;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .panel img {
            width: 600px

        }
        .profile-panel h3, .profile-panel p {
            margin: 10px 0;
        }
        .project-link {
            color: rgb(121, 7, 182);
            text-decoration: none;
        }
        .project-link:hover {
            text-decoration: underline;
        }
        .buttons {
            text-align: center;
            
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            font-family: cursive;
            color: #000;
            background-color: rgb(163, 163, 163);
            border: none;
            border-radius: 30px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .buttons a{
            font-size: 1.2rem;
        }
        .button:hover {
            background-color: rgb(85, 0, 131);
        }
    </style>
</head>
<body>
<div class="panel">
        <img src="obraz.jpg">
    <div class="buttons">
            <a href="#" class="button">Strona glówna</a>
            <a href="#" class="button">Nasza klasa</a>
            <a href="#" class="button">Wyszukaj</a>

        </div>
    <div class="panel1">
        <h1>Profile Uczniów</h1>
        
        <?php
        if ($result->num_rows > 0) {
            $current_uczen_id = null; // Initialize variable to avoid errors

            while ($row = $result->fetch_assoc()) {
                // If it's a new student, start a new panel
                if ($current_uczen_id !== $row["uczen_id"]) {
                    if ($current_uczen_id !== null) {
                        echo "</div>"; // Close the previous student's panel
                    }

                    // Start a new panel for the current student
                    echo '<div class="profile-panel">';
                    echo '<h3>Imię: ' . htmlspecialchars($row["imie"]) . '</h3>';
                    echo '<p>Nazwisko: ' . htmlspecialchars($row["nazwisko"]) . '</p>';
                    echo '<p>Wiek: ' . htmlspecialchars($row["wiek"]) . '</p>';
                    echo '<p>Zainteresowania: ' . htmlspecialchars($row["Zainteresowanie"]) . '</p>';
                    echo '<h4>Projekty:</h4>';

                    $current_uczen_id = $row["uczen_id"];
                }

                // Display projects if they exist
                if (!empty($row["tytul_projektu"])) {
                    echo '<p><a href="projekt.php?id=' . htmlspecialchars($row["projekt_id"]) . '" class="project-link">' . htmlspecialchars($row["tytul_projektu"]) . '</a></p>';
                }
            }

            // Close the last student's panel
            echo '</div>';
        } else {
            echo '<p>Brak wyników do wyświetlenia.</p>';
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
