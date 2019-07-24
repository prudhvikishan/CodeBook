<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<!-- Bootstrap -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.min.css" rel="stylesheet">

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/d3.js"></script>


<link href="css/custom.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">

</head>

<style>
hr.style-eight {
    padding: 0;
    border: none;
    border-top: medium double #333;
    color: #333;
    text-align: center;
    margin:15px;
}
hr.style-eight:after {
    content: "§";
    display: inline-block;
    position: relative; 
    top: -0.7em;  
    font-size: 1.5em;
    padding: 0 0.25em;
    background-image: url('images/paper.jpg');
}

#timer { position: absolute; top:20px; right:10px; }

</style>
<body>
<?php include "header.php" ?>

    <div class="container" >
      <div class="row" style="margin-top:10px;background-image:url('images/paper.jpg');">
        <div class="col-lg-12">
         <div class="row" style="text-align:center;">
            <h3>Chemistry</h3>
            <hr class="style-eight"></hr>
          </div>
          <div id="timer">1 Hr 29 Mins Remaining</div>
       
        
        <div class="row" id="alert_area"></div>
        
        <!-- BEGIN Questions -->
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">1.</span>
              With respect to chlorobenzene , which of the following statements is NOT correct ?
            </div>
            <br /><div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='A' />
                  Cl is ortho/para directing
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='B' />
                  Cl exhibits +M effect
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='C' />
                  Cl is ring deactivating
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='D' />
                  Cl is meta directing
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">2.</span>
              Which of the following statements is NOT correct ?
            </div>
            <br /><div class='remediation'></div> 
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='A' />
                  The six carbons in benzene are <span class='formula'>sp^{2}</span> hybridised
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='B' />
                  Benzene has <span class='formula'>(4n + 2) \pi </span> electrons
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='C' />
                  Benzene undergoes substitution reactions
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='D' />
                  Benzene has two carbon-carbon bond lengths, <span class='formula'>1.54 \overset{0}{A}</span> and <span class='formula'>1.34 \overset{0}{A}</span>
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">3.</span>
              The chlorination of ethane is an example for which type of the following reactions?
            </div>
            <br /><div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='A' />
                  Nucleophilic substitution
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='B' />
                  Electrophilic substitution
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='C' />
                  Free radical substitution
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='D' />
                  Rearrangement
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">4.</span>
             In photoelectric effect, if the energy required to overcome the attractive forces on the electron,
			(work functions) of Li, Na and Rb are 2.41eV, 2.30eV and 2.09eV respectively, the work
			function of 'K' could approximately be in eV
            </div>
           <br /> <div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='A' />
                  2.52
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='B' />
                  2.20
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='C' />
                  2.35
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='D' />
                  2.01
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">5.</span>
              	The quantum number which explains the line spectra observed as doublets in case of hydro-
				gen and alkali metals and doublets and triplets in case of alkaline earth metals is
            </div>
            <br /><div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='A' />
                  Spin
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='B' />
                  Azimuthal
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='C' />
                  Magnetic
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='D' />
                  Principal
                </label>
              </li>
            </ul>
          </div>
        </div>
        <!-- END Questions -->
      </div>

    </div>

      <div class="row" style="margin:20px; text-align:center;">
        <div class="col-lg-12">
          <a href='#' class='btn btn-primary' id="submit_exam">Submit</a>
        </div>
      </div>

      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <div class="modal fade" id="quiz_confirmation_modal" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title center">Congratulations!</h4>
            </div>
            <div class="modal-body">
                 <div class="row center">
                  <div class="col-lg-5 col-lg-offset-1">
                    <div class="panel">
                      <div class="panel-heading center">
                      <strong>Points</strong>
                      </div>
                      <div class="center">
                       <h4>You have earned</h4><h1 style="font-size:3.1em;">150</h1><h4> points</h4>
                     </div>
                     </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="panel">
                      <div class="panel-heading center">
                      <strong>Badge</strong>
                      </div>
                      <div class="center">
                      <h4> You have unlocked </h4>
                      <h3 class="center"><i class="icon-bullhorn icon-3x"></i></h3>
                       <h4>Apprentice in Algebra</h4>
                     </div>
                     </div>
                  </div>
                </div>
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->

</div>

    </div><!-- /.container -->

    <script src="js/jquery.js"></script>
    <script src="js/d3.js"></script>
    <script src="js/holder.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/formula.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        updateFormulas();

        $("#submit_exam").click(function(){

          $("#alert_area").html("");

          // Go Over each question to see if its answered
          var num_questions = $(".question_container").length;
          var num_answered = $("ul.choices li input:checked").length;

          console.log(num_questions + " - " + num_answered);

          if(num_answered != num_questions)
          {
            $("#alert_area").html(
              '<div class="panel panel-danger">'+
                '<div class="panel-heading">Please Answer All Questions</div>' +
                '<div class="panel-body">' +
                  'You need to complete the entire exam before submitting.' + 
                '</div>' + 
              '</div>'
            );
            return ;
          }

          // fade out the submit button
          $("#submit_exam").fadeOut();
          $("#return_to_map").fadeIn();

          // they've answered the questions now lets give them some remediation
          $(".question_container").each(function(i,item){
            if(i % 2 == 0)
            {
              $(".remediation", item).html(
                '<div class="panel panel-success">'+
                  '<div class="panel-heading">Correct!</div>' +
                  '<div class="panel-body">' +
                    'The answer is ... because ... See <a href="topic.php">This page</a> for more information'+ 
                  '</div>' + 
                '</div>'  
              );
            }
            else
            {
              $(".remediation", item).html(
                '<div class="panel panel-danger">'+
                  '<div class="panel-heading">Incorrect</div>' +
                  '<div class="panel-body">' +
                    'The answer is ... because ... See <a href="topic.php">This page</a> for more information'+ 
                  '</div>' + 
                '</div>'  
              );
            }
          });

          // Now show them their total score
          $("#alert_area").html(
            '<div class="panel panel-success">'+
              '<div class="panel-heading">Great Job!</div>' +
              '<div class="panel-body">' +
                'You Scored 3/5 (60%). Great Job!' + 
              '</div>' + 
            '</div>'
          );

          // show a modal aabout the badges
          $('#quiz_confirmation_modal').modal({});
        });
      });
    </script>
  </body>
</html>