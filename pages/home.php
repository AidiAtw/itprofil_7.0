<?php
$data = json_decode(file_get_contents('profile.json'), true);
?>
<h1>O mně</h1>
<div class="profile-info">
    <p><strong>Jméno:</strong> <?php echo htmlspecialchars($data['name']); ?></p>
    <p><strong>Role:</strong> <?php echo htmlspecialchars($data['role']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($data['email']); ?></p>
    <p class="bio"><?php echo htmlspecialchars($data['bio']); ?></p>
</div>

<h2>Moje Projekty</h2>
<div class="projects-grid">
    <?php foreach ($data['projects'] as $project): ?>
        <div class="project-card">
            <h3><?php echo htmlspecialchars($project['title']); ?></h3>
            <p><?php echo htmlspecialchars($project['description']); ?></p>
        </div>
    <?php endforeach; ?>
</div>