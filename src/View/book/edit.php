<h2>Modifier un livre</h2>
<?= $bookForm ?>
<div class="col-md-4 my-3 mx-auto">
    <a href="/?p=book/index"><button class="btn btn-outline-danger w-100"><?= isset($book) ? 'Annuler la modification' : 'Annuller l\'ajout' ?></button></a>
</div>