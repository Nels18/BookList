<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link"<?= (1 < $page) ? 'href="' . $_SERVER['REQUEST_URI'] . '&page=' . $page - 1 . '"' : ''?>>Précédent</a>
        </li>
        <?php
            for ($i = 1; $i <= $nbPages; $i++) {
                if ($page != $i) {
        ?>
        <li class="page-item">
            <a class="page-link" href="<?=$_SERVER['REQUEST_URI']?>&page=<?php echo $i ?>">
            <?= $i ?>
            </a>
        </li>
        <?php
            } else {
        ?>
        <li class="page-item active" aria-current="page">
            <a class="page-link">
            <?= $i ?>
            </a>
        </li>
        <?php
            }
        }
        ?>
        <li class="page-item">
            <a class="page-link"
            <?= ($nbPages > $page) ? 'href="' . $_SERVER['REQUEST_URI'] . '&page=' . $page + 1 . '"' : ''?>
            >Suivant</a>
        </li>
    </ul>
</nav>