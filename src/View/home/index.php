<h2 class="my-4">Accueil</h2>
<h3 class="my-4 pt-3 border-top">Livres</h3>

<div class="row h-50">
    <?php foreach ($books as $book): ?>
    <div class="col-md">
        <a href="#" class="bg-danger">
            <div class="card p-3 h-100">
                <div class="card-body d-flex flex-column">
                <h4 class="card-title fw-bold"><?=$book['title'] . ' - ' . $book['author_first_name'] . ' ' . $book['author_last_name']?></h4>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach;?>
</div>

<p class="card-title my-3"><a href="/?p=book/index">Tous les livres</a></p>

<h3 class="my-4 pt-3 border-top">Auteurs</h3>

<div class="row h-50">
    <?php foreach ($authors as $author): ?>
    <div class="col-md">
        <a href="#" class="bg-danger">
            <div class="card p-3 h-100">
                <div class="card-body d-flex flex-column">
                <h4 class="card-title fw-bold"><?=$author['first_name'] . ' ' . $author['last_name']?></h4>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach;?>
</div>

<p class="card-title my-3"><a href="/?p=author/index">Tous les auteurs</a></p>

<h3 class="my-4 pt-3 border-top">Genres</h3>

<div class="row h-50">
    <?php foreach ($categories as $category): ?>
    <div class="col-md">
        <a href="#" class="bg-danger">
            <div class="card p-3 h-100">
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title fw-bold"><?=$category['name']?></h4>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach;?>
</div>

<p class="card-title my-3"><a href="/?p=category/index">Tous les genres</a></p>
