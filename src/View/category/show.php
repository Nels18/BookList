<div class="card p-3 my-5">
    <div class="card-body">
        <h2 class="card-title fw-bold"><?=$category['name']?></h2>
        <a href="/?p=category/edit/<?=$category['id']?>" class="btn btn-primary me-3">Modifier</a>
        <a href="/?p=category/remove/<?=$category['id']?>" class="btn btn-outline-danger ">Supprimer</a>
    </div>
</div>