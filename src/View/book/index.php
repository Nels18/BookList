<?php if (isset($books)): ?>
<?php foreach ($books as $book): ?>
<div class="card p-3 my-5 w-50 mx-auto">
    <div class="card-body">
        <a href="?p=book/show/<?= $book['id'] ?>"><h3 class="card-title fw-bold"><?= $book['title'] . ' - ' . $book['author_last_name'] . ' ' . $book['author_first_name'] ?></h3></a>
        <h4 class="card-subtitle mb-2 text-muted"><?=$book['category']?></h4>
        <p class="text-truncate"><?= $book['summary'] ?></p>
    </div>
</div>
<?php endforeach; ?>
<?= $pagination?>
<a href="?p=book/add"><button class="btn btn-primary">Ajouter un livre</button></a href="form_book.php">
<?php else: ?> -->
<p>Aucun résultat trouvé</p>
<?php endif; ?>