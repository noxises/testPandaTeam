<button type="button " class="btn btn-danger" id="delete" name="<?= $pool['id'] ?>"> Delete </button>
<a href="/pools/edit/<?= $pool['id']?>" class="btn btn-primary">Edit</a>


<h1><?= $pool['name'] . ' (' .($pool['status'] ? 'published' : 'not published' ) .')' ?></h1>

<ol>
    <?php foreach ($poolAnswers as $answer) { ?>
    <li>
        <?= $answer['text'] . ' (Answers count = ' . $answer['count'] . ')' ?>
    </li>
    <?php } ?>
</ol>