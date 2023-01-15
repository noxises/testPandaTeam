<?php
$answerId = (new Answers())->lastId();
$answerId = $answerId[0]['LAST_INSERT_ID()'] + 50;

?>
<form method="post" id="editForm">
    <div class="mb-3 row">
        <input type="text" name="pool_id" hidden value="<?= $pool['id']?>">
        <label for="poolName" class="col-sm-2 col-form-label">Pool Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="poolName" name="name" value="<?= $pool['name'] ?>">
        </div>
    </div>
    <div class="mb-3 row" id="answers_block">
        <label for="poolName" class="col-sm-2 col-form-label">Answers:</label>
        <div class="col-sm-10" id="aswerBlock">
            <?php foreach($poolAnswers as $answer) {?>
            <div class="row">
                <div class="col">
                    <input type="text" hidden class="answerId" value="<?= $answer['id']?>" name="answerId[]">
                    <input type="text" class="form-control" id="poolName" name="answerText[]"
                        value="<?= $answer['text'] ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="poolName" name="answerCount[]"
                        value="<?= $answer['count'] ?>">
                </div>
                <div class="col">
                    <input type="checkbox" class="form-check-input"  name="answers[]" value="<?= $answer['id']?>">
                    
                </div>
            </div>
            <?php } ?>
            
                    

        </div>
       
    </div>
    <button type="button" id="answerButton" class="btn btn-primary">Add new answer</button>
            <button type="button" class="btn btn-danger" id="delete_selected">Delete selected answers</button>


    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="published" name="published"
            <?= $pool['status'] ?"checked":"" ?>>
        <label class="form-check-label" for="published">Published</label>
    </div>
    <button type="submit"  class="btn btn-success"> Save </button>
    <button type="button" class="btn btn-danger" id="delete" name="<?= $pool['id'] ?>"> Delete </button>

</form>


<script>
$('#answerButton').click(function() {
    messageArray = document.getElementsByClassName('answerId');
    console.log(messageArray);
    let id = <?= $answerId ?>;
    if (messageArray.length > 0) {
        id = parseInt(messageArray[messageArray.length - 1].value) + 1;
    }
    console.log(id);
    $("#answers_block").append($('<div class="row" id="'+id+ '">' +
        '<div class="col" >' +
        '  <input type="text" class="answerId" hidden value="' + id + '" name="answerId[]">' +
        ' <input type="text" class="form-control" id="poolName" name="answerText[]" value="Input answer text">' +
        '</div>' + ' <div class="col">' +
        '<input type="text" class="form-control" id="poolName" name="answerCount[]"value="0">' +
        '</div><button class="col btn btn-danger" onclick="RemoveNotSavedAnswer('+id+')"  type="button">Remove</button></div>'
    ));
});

function  RemoveNotSavedAnswer(id){

    console.log('test');
    $("#"+id).remove();
}
</script>