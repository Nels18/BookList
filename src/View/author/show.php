<div class="card p-3 my-5">
    <div class="card-body">
        <h2 class="card-title fw-bold"><?=$author['first_name'] . ' ' . $author['last_name']?></h2>
        <a href="/?p=author/edit/<?=$author['id']?>" class="btn btn-primary me-3">Modifier</a>
        <a href="/?p=author/remove/<?=$author['id']?>" class="btn btn-outline-danger ">Supprimer</a>
    </div>
</div>