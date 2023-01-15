<?php
$answerId = (new Answers())->lastId();
$answerId = $answerId[0]['LAST_INSERT_ID()'] + 50;

?>
<form method="post" id="editForm">
    <div class="mb-3 row">
        <input type="text" name="pool_id" hidden value="null">
        <label for="poolName" class="col-sm-2 col-form-label">Pool Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="poolName" name="name" value="Input pool text">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="poolName" class="col-sm-2 col-form-label">Answers:</label>
        <div class="col-sm-10" id="aswerBlock">

            <div class="row">
                <div class="col">
                    <input type="text" hidden class="answerId" value="<?= $answerId ?>" name="answerId[]">
                    <input type="text" class="form-control" id="poolName" name="answerText[]" value="Input answer text">
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="poolName" name="answerCount[]" value="0">
                </div>
            </div>

            <button type="button" id="answerButton" class="btn btn-primary">Add new answer</button>
        </div>
    </div>



    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="published" name="published">
        <label class="form-check-label" for="published">Published</label>
    </div>
    <button type="submit" class="btn btn-success"> Save </button>
</form>


<script>
    $('#answerButton').click(function() {
        messageArray = document.getElementsByClassName('answerId');

        if (messageArray.length > 0) {
            id = parseInt(messageArray[messageArray.length - 1].value) + 1;
        }
        console.log(id);
        $(this).parent().append($('<div class="row">' +
            '<div class="col">' +
            '  <input type="text" class="answerId" hidden value="' + id + '" name="answerId[]">' +
            ' <input type="text" class="form-control" id="poolName" name="answerText[]" value="Input answer text">' +
            '</div>' + ' <div class="col">' +
            '<input type="text" class="form-control" id="poolName" name="answerCount[]"value="0">' +
            '</div></div>'
        ));
    });
</script>