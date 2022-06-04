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
    <body class="text-dark bg-light">
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
                <div class="container-xxl">
                    <a href="/" class="navbar-brand px-md-5 px-3">Accueil</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="/?p=book/index">Livres</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main class="container-xxl px-md-5 px-3 pt-5 min-vh-100">
            <div class="container-xxl px-md-5 px-3 min-vh-100">
                <h1 class="display-1 text-center m-5 fw-bold">Booklist</h1>
                <?php if (!empty($_SESSION['messages'])): ?>
                    <?php foreach ($_SESSION['messages'] as $message): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $message; ?>
                    </div>
                    <?php endforeach;?>
                    <?php unset($_SESSION['messages']);?>
                <?php endif;?>

                <?php if (!empty($_SESSION['errors'])): ?>
                    <div class="card p-5 my-3">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                        <?php endforeach;?>
                        <?php unset($_SESSION['errors']);?>
                    </div>
                <?php endif;?>

                <?=$content?>
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="asset/script/script.js"></script>
    </body>
</html>