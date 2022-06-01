<!-- <?php if (isset($books)): ?> -->
<?php foreach ($books as $book): ?>
<div class="card p-3 my-5">
    <div class="card-body">
        <a href="?p=book/show/<?= $book->id ?>"><h5 class="card-title"><?= $book->title; ?></h5></a>
    </div>
</div>
<?php endforeach; ?>
<a href="add.php"><button class="btn btn-primary">Ajouter un livre</button></a href="form_book.php">
<!-- <?php else: ?> -->
<!-- <p>Aucun résultat trouvé</p> -->
<!-- <?php endif; ?> -->