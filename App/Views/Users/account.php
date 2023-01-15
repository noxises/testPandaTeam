
    <h1>Pools</h1>
    <div class="pools">
        sort by:
        <a href="?sort=name&dir=<?= ($dir == 'asc' ? 'desc' : 'asc') ?>">name</a>
        <a href="?sort=created_at&dir=<?= ($dir == 'asc' ? 'desc' : 'asc') ?>">Created</a>
        <a href="?sort=status&dir=<?= ($dir == 'asc' ? 'desc' : 'asc') ?>">Status</a>
        <ul>
            <?php foreach ($pools as $pool) { ?>
            <li>
                <a href="/pools/<?= $pool['id']?>"> <?= $pool['name'] . ' (' .($pool['status'] ? 'published' : 'not published' ) .')' ?> </a>
                <ol>
                    <?php foreach ($pool['answers'] as $answer) { ?>
                    <li>
                        <?= $answer['text'] . ' (Answers count = ' . $answer['count'] . ')' ?>
                    </li>
                    <?php } ?>
                </ol>
            </li>
            <?php } ?>
        </ul>
    </div>
