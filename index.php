<?php
session_start();
require_once "db.php";

$profileJson = json_decode(file_get_contents('profile.json'), true);

$page = $_GET['page'] ?? 'home';

ob_start();

$pageFile = "pages/" . $page . ".php";
if (!file_exists($pageFile)) {
    $pageFile = "pages/not_found.php";
}

include $pageFile;
$content = ob_get_clean();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profileJson['name']); ?> | IT Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <a href="?page=home" class="<?php echo $page === 'home' ? 'active' : ''; ?>">Domů</a>
                <a href="?page=interests" class="<?php echo $page === 'interests' ? 'active' : ''; ?>">Zájmy</a>
                <a href="?page=skills" class="<?php echo $page === 'skills' ? 'active' : ''; ?>">Dovednosti</a>
            </nav>
        </header>

        <main>
            <?php if (isset($_SESSION['msg'])): ?>
                <div class="message <?php echo $_SESSION['msg']['type']; ?>">
                    <?php 
                        echo htmlspecialchars($_SESSION['msg']['text']); 
                        unset($_SESSION['msg']);
                    ?>
                </div>
            <?php endif; ?>

            <?php echo $content; ?>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars($profileJson['name']); ?></p>
        </footer>
    </div>
</body>
</html>