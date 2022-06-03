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
        <div class="container-fluid p-md-5 p-3  min-vh-100 text-dark bg-light">
            <h1 class="display-1 text-center m-5 fw-bold">Booklist</h1>
            <main class="container-fluid">
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
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="asset/script/script.js"></script>
    </body>
</html>