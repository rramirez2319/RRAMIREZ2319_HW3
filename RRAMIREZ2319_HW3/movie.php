<?php
$movie = $_GET['film'] ?? 'wolf_of_wall_street';
$movieDataPath = __DIR__ . "/movies/$movie/";

// Helper function to safely read file content
function getFileContent($path) {
    return file_exists($path) ? file_get_contents($path) : 'Information not available';
}

// Extracting the movie information
$info = explode("\n", getFileContent($movieDataPath . 'info.txt'));
$overviewContent = getFileContent($movieDataPath . 'overview.txt');

list($title, $year, $rating, $reviewCount) = $info + array_fill(0, 4, 'N/A');

// Convert numeric rating to a visual representation (e.g. 8.5/10 becomes 4 stars)
$stars = str_repeat('★', floor($rating / 2)) . str_repeat('☆', 5 - floor($rating / 2));

// Parse the overview content into key-value pairs
$overviewLines = explode("\n", $overviewContent);
$overview = [];
foreach ($overviewLines as $line) {
    list($key, $value) = explode(':', $line, 2) + [null, null];
    if ($key !== null) {
        $overview[trim($key)] = trim($value);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - Movie Review</title>
    <link rel="stylesheet" href="movie.css">
    <style>
        .movie-info { margin-bottom: 20px; }
        .movie-overview { margin-top: 20px; }
        .star-rating { color: gold; }
        .overview-item { margin-bottom: 10px; }
        .overview-title { font-weight: bold; }
    </style>
</head>
<body>
    <header>
        <h1><?= htmlspecialchars($title) ?> (<?= htmlspecialchars($year) ?>)</h1>
    </header>
    <section id="movie-intro">
       <img src="<?= 'movies/' . $movie . '/poster.jpg' ?>" alt="<?= htmlspecialchars($title) ?> Poster" class="movie-poster">
        <div class="movie-info">
            <p><span class="star-rating"><?= $stars ?></span> - <?= $rating ?>/10 based on <?= $reviewCount ?> reviews</p>
        </div>
    </section>
    <section class="movie-overview">
        <?php foreach ($overview as $key => $value): ?>
            <div class="overview-item">
                <span class="overview-title"><?= htmlspecialchars($key) ?>:</span> <?= htmlspecialchars($value) ?>
            </div>
        <?php endforeach; ?>
    </section>
    <footer>
        <p>Review by Robert Ramirez. University of Arizona. Bear Down!</p>
    </footer>
</body>
</html>

