<!DOCTYPE html>
<html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <meta name='description' content='Ma Liste de livre à lire'/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel='stylesheet' href='public/style.css'>
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
                            <a class="nav-link" href="/?p=book/index">
                                <li class="nav-item">
                                    Livres
                                </li>
                            </a>
                            <a class="nav-link" href="/?p=author/index">
                                <li class="nav-item">
                                    Auteurs
                                </li>
                            </a>
                            <a class="nav-link" href="/?p=category/index">
                                <li class="nav-item">
                                    Genres
                                </li>
                            </a>
                        </ul>
                        <?php if (!isset($_SESSION['user'])): ?>
                            <div class="ms-md-auto">
                                <a href="/?p=user/register"><button class="btn btn-light me-2" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                </svg> S'enregister</button>
                                </a>
                                <a href="/?p=user/login"><button class="btn btn-outline-light me-2" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                    </svg> 
                                Se connecter</button>
                                </a>
                            </div>
                        <?php endif;?>
                        <?php if (!empty($_SESSION['user'])): ?>
                            <div class="ms-md-auto">
                                <span class="text-light"><?='Bonjour ' . $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']?></span>
                                <a href="/?p=user/logout"><button class="btn btn-outline-danger ms-2" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg> Se déconnecter</button>
                                </a>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </nav>
        </header>
        <main class="container-xxl px-md-5 p-5 min-vh-100">
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
                            <?php echo ($error); ?>
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