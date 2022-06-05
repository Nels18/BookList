<h2 class="my-4">Accueil</h2>
<h3 class="my-4">Livres</h3>

<div class="row h-50">
    <?php foreach ($books as $book): ?>
    <div class="card col-md mx-3 p-3 container-overflow">
        <div class="card-body d-flex flex-column">
            <h4 class="card-title fw-bold"><?=$book['title'] . ' - ' . $book['author_first_name'] . ' ' . $book['author_last_name']?></h4>
            <h5 class="card-subtitle mb-2 text-muted"><?=$book['category']?></h5>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<a href="/?p=book/index"><p class="card-title my-3">Tous les livres</p></a>

