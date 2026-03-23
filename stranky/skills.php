<?php
$data = json_decode(file_get_contents('profile.json'), true);
?>
<h1>Moje Dovednosti</h1>
<ul class="skills-list">
    <?php foreach ($data['skills'] as $skill): ?>
        <li><?php echo htmlspecialchars($skill); ?></li>
    <?php endforeach; ?>
</ul>