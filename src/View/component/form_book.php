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
