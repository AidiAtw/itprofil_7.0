<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = trim($_POST["new_interest"] ?? '');
        if (!empty($name)) {
            try {
                $stmt = $db->prepare("INSERT INTO interests (name) VALUES (?)");
                $stmt->execute([$name]);
                $_SESSION['msg'] = ["text" => "Zájem přidán.", "type" => "success"];
            } catch (Exception $e) {
                $_SESSION['msg'] = ["text" => "Chyba: Zájem již existuje.", "type" => "error"];
            }
        }
    } elseif ($action === 'delete') {
        $stmt = $db->prepare("DELETE FROM interests WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $_SESSION['msg'] = ["text" => "Zájem smazán.", "type" => "success"];
    } elseif ($action === 'edit') {
        $newName = trim($_POST['new_value'] ?? '');
        if (!empty($newName)) {
            $stmt = $db->prepare("UPDATE interests SET name = ? WHERE id = ?");
            $stmt->execute([$newName, $_POST['id']]);
            $_SESSION['msg'] = ["text" => "Zájem upraven.", "type" => "success"];
        }
    }
    
    header("Location: index.php?page=interests");
    exit;
}

$interests = $db->query("SELECT * FROM interests ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Správa zájmů</h1>

<ul class="interests-list">
    <?php foreach ($interests as $item): ?>
        <li>
            <span id="text-<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['name']); ?></span>
            
            <form method="POST" id="edit-form-<?php echo $item['id']; ?>" style="display:none; flex:1;">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                <input type="text" name="new_value" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                <button type="submit">Uložit</button>
            </form>

            <div class="actions">
                <button onclick="toggleEdit(<?php echo $item['id']; ?>)">Upravit</button>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    <button type="submit" class="btn-delete" onclick="return confirm('Smazat?')">Smazat</button>
                </form>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

<hr>

<form method="POST" class="add-form">
    <input type="hidden" name="action" value="add">
    <input type="text" name="new_interest" placeholder="Nový zájem..." required>
    <button type="submit">Přidat</button>
</form>

<script>
function toggleEdit(id) {
    const text = document.getElementById('text-' + id);
    const form = document.getElementById('edit-form-' + id);
    if (form.style.display === 'none') {
        form.style.display = 'flex';
        text.style.display = 'none';
    } else {
        form.style.display = 'none';
        text.style.display = 'inline';
    }
}
</script>