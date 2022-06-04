<div class="card p-3 my-5">
    <div class="card-body">
        <h2 class="card-title fw-bold"><?=$book['title'] . ' - ' . $author['first_name'] . ' ' . $author['last_name']?></h2>
        <h3 class="card-subtitle mb-2 text-muted"><?=$category['name']?></h3>
        <p class="card-subtitle mb-2 fw-light"><?=$book['published_at']?></p>
        <p class="card-text"><?=$book['summary']?></p>
        <a href="/?p=book/edit/<?=$book['id']?>" class="btn btn-primary me-3">Modifier</a>
        <a href="/?p=book/remove/<?=$book['id']?>" class="btn btn-outline-danger ">Supprimer</a>
    </div>
</div>