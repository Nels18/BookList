<?php
    use App\Core\Autoloader;
    use App\Controller\BookController;

    require_once 'src/Core/Autoloader.php';
    Autoloader::register();
?>

<main class="container-fluid p-5">
    <?php
        $book = new BookController();
        $book->index();
    ?>

    <?php
        foreach ($parameters["books"] as $book) {
    ?>
    <div class="card p-3 my-5">
        <div class="card-body">
            <h5 class="card-title"><?=$book['title']; ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"> <?=$book['firstname'] . ' ' . strtoupper($book['lastname']) . ' (' . date('d/m/Y', strtotime($book['publication_date'])) . ')' . ' - ' . $book['category'] ?> </h6>
            <p class="card-text"> <?=$book['summary'] ?></p>
        </div>
    </div>
    <?php
        }
        echo $parameters["pagination"];
    ?>
    <a href="form_book.php"><button class="btn btn-primary">Ajouter un livre</button></a href="form_book.php">
</main>