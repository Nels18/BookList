<!DOCTYPE html>
<html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <meta name='description' content='Ma Liste de livre à lire'/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel='stylesheet' href='asset/style/style.css'>
        <title>Booklist</title>
    </head>
    <body>
        <div class="container-fluid p-5">
            <header>
                <h1 class="display-1 text-center m-5">Booklist</h1>
            </header>
            <main>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md mb-3">
                            <label class="form-label" for="title">Titre :</label>
                            <input class="form-control" type="text" name="title" id="title" required>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md mb-3">
                            <label class="form-label" for="author">Auteur :</label>
                            <select class="form-select" name="author_id" id="author" required>
                                <option value="">Sélectionner un auteur</option>
                                <option value=""></option>
                            </select>
                        </div>
                        
                        <div class="col-md mb-3">
                            <label class="form-label" for="category">Genre :</label>
                            <select class="form-select" name="category_id" id="category" required>
                                <option value="">Sélectionner un genre</option>
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="col-md mb-3">
                            <label class="form-label" for="publication_date">Date de parution :</label>
                            <input class="form-control" type="date" name="publication_date" id="publication_date" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="summary">Résumé :</label>
                        <textarea class="form-control" name="summary" id="summary" cols="80" rows="10"></textarea>
                    </div>
                    <!-- <button type="submit" class="btn btn-primary">Ajouter le livre</button> -->
                    <div class="d-md-flex justify-content-between flex-column flex-md-row">
                        <div class="my-3">
                            <input class="btn btn-primary w-100" type="submit" name="submit" value="Ajouter le livre">
                        </div>
                        <div class="my-3">
                            <a href="index.php">
                                <button type="button" class="btn btn-danger w-100">
                                    Annuler
                                </button>
                            </a>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </body>
</html>
