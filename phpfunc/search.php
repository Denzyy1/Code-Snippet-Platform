<?php
require("dbconfig.php");

$query = trim($_POST['query'] ?? "");

if ($query) {
    $stmt = $conn->prepare("SELECT * FROM snippets WHERE title LIKE ? OR content LIKE ?");
    $likeQuery = "%" . $query . "%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
    $stmt->execute();
    $result = $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>

    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li><a href="snippet.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>

</body>
</html>
