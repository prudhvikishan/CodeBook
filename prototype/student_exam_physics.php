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
            <h3>Physics</h3>
            <hr class="style-eight"></hr>
          </div>
          <div id="timer">1 Hr 29 Mins Remaining</div>
       
        
        <div class="row" id="alert_area"></div>
        
        <!-- BEGIN Questions -->
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">1.</span>
              A uniform rope of mass 0.1 kg and length 2.45 m hangs from a rigid support. The time taken
              by the transverse wave formed in the rope to travel through the full length of the rope is
              (Assume <span class="formula">g=9.8 \frac{m}{s^{2}}</span> )
            </div>
            <br /><div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='A' />
                  <span class="formula">0.5s</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='B' />
                  <span class="formula">1.6s</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='C' />
                  <span class="formula">1.2s</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='D' />
                  <span class="formula">1.0s</span>
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">2.</span>
              When a vibrating tuning fork is placed on a sound box of a sonometer, 8 beats per second are
              heard when the length of the sonometer wire is kept at 101 cm or 100 cm. Then the frequency
              of the tuning fork is (consider that the tension in the wire is kept constant)
            </div>
            <br /><div class='remediation'></div> 
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='A' />
                  <span class="formula">1616 Hz</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='B' />
                  <span class="formula">1608 Hz</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='C' />
                  <span class="formula">1632 Hz</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='D' />
                  <span class="formula">1600 Hz</span>
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">3.</span>
              The objective and eyepiece of an astronomical telescope are double convex lenses with refrac-
              tive index 1.5. When the telescope is adjusted to infinity, the separation between the two lenses
              is 16 cm. If the space between the lenses is now filled with water and again telescope is ad-
              justed for infinity, then the present separation between the lenses is
            </div>
            <br /><div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='A' />
                  <span class="formula">8 cm</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='B' />
                  <span class="formula">16 cm</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='C' />
                  <span class="formula">24 cm</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='D' />
                  <span class="formula">32 cm</span>
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">4.</span>
              The dispersive powers of the materials of two lenses forming an achromatic combination are
              in the ratio of 4:3. Effective focal length of the two lenses is +60 cm then the focal lenghts of the
              lenses should be
            </div>
           <br /> <div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='A' />
                  <span class="formula">-20 cm, 25 cm</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='B' />
                  <span class="formula">20 cm, -25 cm</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='C' />
                  <span class="formula">-15 cm, 20 cm</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='D' />
                  <span class="formula">15 cm, -20 cm</span>
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">5.</span>
              Total emf produced in a thermocouple does not depend on
            </div>
            <br /><div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='A' />
                  the metals in the thermocouple
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='B' />
                  thomson coefficients of the metals in the thermocouple
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='C' />
                  temperature of the junctions
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='D' />
                  the duration of time for which the current is passed through thermocouple
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