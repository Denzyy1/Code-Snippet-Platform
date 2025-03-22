<?php
require("phpfunc/dbconfig.php");

if($_SESSION['logged'] != 1){
    header('Location: ./index.php');
}

$username = $_SESSION['user_name'];
$sql = "SELECT id FROM users WHERE username = '$username'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc(); 
    $user_id = $row['id'];
}

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
    HAVING s.user_id = $user_id
    ORDER BY s.created_at DESC ");
    $stmt->execute();
    $result = $stmt->get_result();
    $snippets = $result->fetch_all(MYSQLI_ASSOC);

    ?> <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
        <title>Mysnippets</title>
    </head>
    <body>
        <h1> Mysnippets</h1>
        <script> hljs.highlightAll();</script>
<div class="snippets-container">
    <?php if (empty($snippets)): ?>
        <div class="error-message">
            <p>🚨 No snippets found! Why not create one?</p>
        </div>
    <?php else: ?>
       
        <div class="snippets-list">
            <?php foreach ($snippets as $snippet): 
                $finished_data = truncateLines($snippet['content']);
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
                            data-full="<?= htmlspecialchars($finished_data['full']) ?>" 
                            <?= $finished_data['hasMore'] ? 'data-truncated="' . htmlspecialchars($finished_data['truncated']) . '"' : '' ?>>
                            <?= htmlspecialchars($finished_data['truncated']) ?>
                        </code>
                    </pre>

                    <div class="snippet-actions">
                        <button class="btn-secondary copy-btn" data-content="<?= htmlspecialchars($finished_data['full']) ?>">
                            📋 Copy
                        </button>

                   

                        <?php if ($finished_data['hasMore']): ?>
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
            const isExpanded = codeBlock.dataset.expanded === "true"; 

            if (isExpanded) {
            
                codeBlock.innerHTML = escapeHTML(codeBlock.dataset.truncated);
                this.textContent = ' Read More';
                codeBlock.dataset.expanded = "false";
            } else {
                
                codeBlock.innerHTML = escapeHTML(codeBlock.dataset.full);
                this.textContent = ' Show Less';
                codeBlock.dataset.expanded = "true";
            }

            hljs.highlightElement(codeBlock);
        });
    });

    
        function escapeHTML(str) {
            return str.replace(/</g, "&lt;").replace(/>/g, "&gt;");
        }
    });
    </script>
            
    </body>
    </html>