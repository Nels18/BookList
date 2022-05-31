<!DOCTYPE html>
<html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <meta name='description' content='Ma Liste de livre à lire'/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel='stylesheet' href='asset/style/style.css'>
        <title>BookList</title>
    </head>
    <body>
        <div class="container-fluid p-5">
            <h1 class="display-1 text-center m-5">Booklist</h1>
            <main class="container-fluid p-5">
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
                <a href="add.php"><button class="btn btn-primary">Ajouter un livre</button></a href="form_book.php">
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="asset/script/script.js"></script>
    </body>
</html>