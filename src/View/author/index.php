<?php if (isset($authors)): ?>
<?php foreach ($authors as $author): ?>
<div class="card p-3 my-5 w-50 mx-auto">
    <div class="card-body">
        <a href="?p=author/show/<?= $author['id'] ?>"><h3 class="card-title fw-bold"><?= $author['first_name'] . ' ' . $author['last_name'] ?></h3></a>
    </div>
</div>
<?php endforeach; ?>
<?= $pagination?>
<a href="?p=author/add"><button class="btn btn-primary">Ajouter un auteur</button></a href="form_author.php">
<?php else: ?> -->
<p>Aucun résultat trouvé</p>
<?php endif; ?>