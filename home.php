<!DOCTYPE html>
<?php
require("phpfunc/dbconfig.php");

if($_SESSION['logged'] != 1){
    header('Location: ./index.php');
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Snippet Share</title>
    <link rel="stylesheet" href="styles.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">Snippet Share</div>
            <ul class="nav-links">
                <li><a href="home.php" class="active">Home</a></li>
                <li><a href="snippets.php">Snippets</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="mysnippets.php">Mysnippets</a></li>  
                <li><a href="index.php">Login</a></li>
                <li><a href="register.php" class="signup">Sign Up</a></li>
                <li><a href="phpfunc/logout-control.php"class="btnSignout" >Sign out</a> </li>
           
            </ul>
            <form action="index.php" method="post" class="search-form">
                <input type="text" name="search" placeholder="Search snippets..." >
                <button type="submit" >Search</button>
            </form>
        
            <!-- <?php
            $search = isset($_POST['search']) ? $_POST['search'] : '';
                $sql = "SELECT * FROM snippets WHERE title LIKE '%$search%' OR language LIKE '%$search%' ORDER BY created_at DESC LIMIT 5";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<div calss = 'snippet-block'><h3>{$row['title']}</h3><pre><code class='{$row['language']}'>" . htmlspecialchars($row['content']) . "</code></pre></div>";
                }
                ?> -->
        </div>
       
    </nav>
    
    <header class="hero">
        <div class="hero-content">
            <h1>The Ultimate Snippet Sharing Platform</h1>
            <p>Save, manage, and share your code snippets efficiently.</p>
            <br>

            <?php

                
            function truncateLines($text, $lines = 3) {
                $textlines = explode("\n", $text);
                if(count($textlines) > $lines) {
                    $truncated = array_slice($textlines, 0, $lines);
                    return [
                        'truncated' => implode("\n", $truncated),
                        'full' => $text,
                        'hasMore' => true
                    ];
                }
                return [
                    'truncated' => $text,
                    'full' => $text,
                    'hasMore' => false
                ];
            }
                $stmt = $conn->prepare("SELECT s.*, u.username AS Publisher FROM snippets as s
                JOIN users as u
                 ON s.user_id = u.id 
                ORDER BY s.created_at DESC ");
                $stmt->execute();
                $result = $stmt->get_result();
                $snippets = $result->fetch_all(MYSQLI_ASSOC);

            ?>
         <script> hljs.highlightAll();</script>
<div class="snippets-container">
    <?php if (empty($snippets)): ?>
        <div class="error-message">
            <p>🚨 No snippets found! Why not create one?</p>
        </div>
    <?php else: ?>
       
        <div class="snippets-list">
            <?php foreach ($snippets as $snippet): 
                $processed = truncateLines($snippet['content']);
                $isOwner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $snippet['user_id'];
            ?>
                <div class="snippet">
                    <h3><?= htmlspecialchars($snippet['title']) ?></h3>
                    
                    <div class="snippet-info">
                        <span>👤 <?= htmlspecialchars($snippet['Publisher']) ?></span> |
                        <span>🖥 <?= htmlspecialchars($snippet['language']) ?></span> |
                        
                    </div>

                    <pre>
                        <code 
                            class="language-<?= htmlspecialchars($snippet['language']) ?>" 
                            data-full="<?= htmlspecialchars($processed['full']) ?>" 
                            <?= $processed['hasMore'] ? 'data-truncated="' . htmlspecialchars($processed['truncated']) . '"' : '' ?>>
                            <?= htmlspecialchars($processed['truncated']) ?>
                        </code>
                    </pre>

                    <div class="snippet-actions">
                        <button class="btn-secondary copy-btn" data-content="<?= htmlspecialchars($processed['full']) ?>">
                            📋 Copy
                        </button>

                        <?php if ($isOwner): ?>
                            <button class="btn-primary edit-btn" data-id="<?= $snippet['id'] ?>">✏️ Edit</button>
                            <button class="btn-danger delete-btn" data-id="<?= $snippet['id'] ?>">🗑 Delete</button>
                        <?php endif; ?>

                        <?php if ($processed['hasMore']): ?>
                            <button class="btn-secondary read-more"> Read More</button>
                            
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
   
document.addEventListener("DOMContentLoaded", () => {
    // Copy Snippet to Clipboard
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            navigator.clipboard.writeText(this.dataset.content).then(() => {
                alert("Snippet copied to clipboard!");
            });
        });
    });

    document.querySelectorAll('.read-more').forEach(btn => {
        btn.addEventListener('click', function() {
            const snippet = this.closest('.snippet');
            const codeBlock = snippet.querySelector('code');
            const isExpanded = codeBlock.dataset.expanded === "true"; // Track expansion state

            if (isExpanded) {
                // Collapse back to truncated version
                codeBlock.innerHTML = escapeHTML(codeBlock.dataset.truncated);
                this.textContent = ' Read More';
                codeBlock.dataset.expanded = "false";
            } else {
                // Expand to full version
                codeBlock.innerHTML = escapeHTML(codeBlock.dataset.full);
                this.textContent = ' Show Less';
                codeBlock.dataset.expanded = "true";
            }

            // Re-apply syntax highlighting
            hljs.highlightElement(codeBlock);
        });
    });

    // Function to escape HTML to prevent issues when setting innerHTML
    function escapeHTML(str) {
        return str.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    }
});
</script>

            <a href="register.php" class="btn">Get Started</a>
        </div>
    </header>

    <footer>
        <p>&copy; 2025 Snippet Share | All Rights Reserved</p>
    </footer>
</body>
</html>
