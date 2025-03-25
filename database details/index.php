<?php
$dsn = "pgsql:host=db.eppxrgnnkrrlzoihgvhq.supabase.co;port=5432;dbname=postgres";
$username = "postgres";
$password = "Ksanthosh25"; // Use your actual password from Supabase

try {
    $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    // Query to fetch images from master_watches table
    $query = "SELECT model_name, image_url FROM heritage_watches";
    $stmt = $pdo->query($query);
    $watches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .watch-card {
            border: 1px solid #ddd;
            padding: 10px;
            width: 200px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <h2>Watch Gallery</h2>
    
    <div class="gallery">
        <?php foreach ($watches as $watch): ?>
            <div class="watch-card">
                <img src="<?= htmlspecialchars($watch['image_url']) ?>" alt="<?= htmlspecialchars($watch['model_name']) ?>">
                <p><strong><?= htmlspecialchars($watch['model_name']) ?></strong></p>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
