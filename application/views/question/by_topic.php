
<!--<table>
	<thead><tr><th>Question</th><th>Difficulty</th><th>View/Edit</th></tr></thead>
	<tbody>
		<?php foreach($this->topic->getQuestions() as $question): ?>
			<tr>
				<td><?= $question->question_text ?></td>
				<td><?= $question->getDifficultyString() ?></td>
				<td><a href='<?= base_url(); ?>question/edit/<?= $question->question_id; ?>'>View/Edit</a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table> -->

<div class="row">
  <div class="col-md-12">
    <a class="btn btn-orange" style="width:107px;" href='<?= base_url(); ?>question/create/<?= $this->topic->topic_id; ?>'><i class="fa fa-plus-circle"/>Add Question</i></a>
  </div>
</div>
<br/>
<div class="row">
	<div class="col-md-12">
		<?php $count = 1 ; foreach($this->topic->getQuestions() as $question): ?>
   <div class="question_container">
    <div class="row">
     <div class="col-md-1">
      <span class="question_number"><?=$count ?>.</span>
    </div>


    <div class="col-md-8">
      <?= $question->question_text ?>
    </div>

    <div class="col-md-1">
      <i class="fa fa-circle"  style="color:<?= $question->getDifficultyColor() ?>"></i> <?= $question->getDifficultyString() ?>
    </div>

    <div class="col-md-1">
      <a class="textorange" href='<?= base_url(); ?>question/edit/<?= $question->question_id; ?>'><i class="icon-edit"></i>  Edit</a>
    </div>

    <div class="col-md-1">
      <a href="#" id="show_hide_link<?=$count ?>" class="show_hide pull-right textorange" rel="#slidingDiv<?=$count ?>"><i id="up_down_arrow<?=$count ?>" class="icon-chevron-sign-down icon-large"></i></a>
    </div>
  </div>

  <div id="slidingDiv<?=$count ?>" class="toggleDiv" style="display: none;">
    <div class="row">
      <div class="col-md-8 col-md-offset-1">
        <?php $choices = $question->getAnswers();?>

        <ul class="choices">
          <li class="choice">
            <div class="radio">
              <input type='radio' name='questions[<?=$count ?>]' value='A' <?= $choices[0]->is_correct == 1 ? "checked" : "" ?> />
              <?= $choices[0]->answer_text ?>
            </div>
          </li>
          <li class="choice">
            <div class="radio">
              <input type='radio' name='questions[<?=$count ?>]' value='B' <?= $choices[1]->is_correct == 1 ? "checked" : "" ?> />
              <?= $choices[1]->answer_text ?>
            </div>
          </li>
          <li class="choice">
            <div class="radio">
              <input type='radio' name='questions[<?=$count ?>]' value='C' <?= $choices[2]->is_correct == 1 ? "checked" : "" ?> />
              <?= $choices[2]->answer_text ?>
            </div>
          </li>
          <li class="choice">
            <div class="radio">
              <input type='radio' name='questions[<?=$count ?>]' value='D' <?= $choices[3]->is_correct == 1 ? "checked" : "" ?> />
              <?= $choices[3]->answer_text ?>
            </div>
          </li>
        </ul>


      </div>

    </div>
    <div class="row">
      <div class="col-md-11 col-md-offset-1">
        <div class='remediation'> <b>Solution :</b> <?= $question->explanation ?></div>
      </div>
    </div>
  </div>

</div>
<?php $count++; endforeach; ?>




</div>
</div>
<script src="<?= base_url(); ?>js/jquery.js"></script>
<script>
$(document).ready(function(){
	$("a").click(function(event) {        	
    if( event.target.id.indexOf('up_down_arrow') != -1) {
     var c  = event.target.id.substring(13);
     if($("#up_down_arrow"+c).attr('class') == 'icon-chevron-sign-down icon-large'){
       $("#up_down_arrow"+c).removeClass('icon-chevron-sign-down icon-large' );
       $("#up_down_arrow"+c).addClass('icon-chevron-sign-up icon-large' );
     } else {
      $("#up_down_arrow"+c).removeClass('icon-chevron-sign-up icon-large' );
      $("#up_down_arrow"+c).addClass('icon-chevron-sign-down icon-large' );
    }
  }
});
});
</script>


