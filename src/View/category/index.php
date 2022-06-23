<?php if (isset($categories)): ?>
<?php foreach ($categories as $category): ?>
<div class="card p-3 my-5 w-50 mx-auto">
    <div class="card-body">
        <a href="?p=category/show/<?= $category['id'] ?>"><h3 class="card-title fw-bold"><?= $category['name'] ?></h3></a>
    </div>
</div>
<?php endforeach; ?>
<?= $pagination?>
<a href="?p=category/add"><button class="btn btn-primary">Ajouter un genre</button></a href="form_category.php">
<?php else: ?> -->
<p>Aucun résultat trouvé</p>
<?php endif; ?>