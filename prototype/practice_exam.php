<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/d3.js"></script>
<link href="css/custom.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">

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

</style>
    <div class="container" >
      <div class="row" style="margin-top:10px;background-image:url('images/paper.jpg');">
        <div class="col-lg-12">
         <div class="row" style="text-align:center;">
            <h3>Algebra</h3>
            <hr class="style-eight"></hr>
          </div>
       
        
        <div class="row" id="alert_area"></div>
        
        <!-- BEGIN Questions -->
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">1.</span>
              The equation of a straight line passing through the point (1, 2) and inclined at 45 degrees to the line:
              <span class="formula">y = 2x + 1</span>
            </div>
            <br /><div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='A' />
                  <span class="formula">5x + y = 7</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='B' />
                  <span class="formula">3x + y = 5</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='C' />
                  <span class="formula">x + y = 3</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[1]' value='D' />
                  <span class="formula">x - y + 1 = 0</span>
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">2.</span>
              A point moves in the xy Ð plane such that the sum of its distance from two mutually perpen-
              dicular lines is always equal to 5 units. The area ( in square units) enclosed by the locus of the
              point, is
            </div>
            <br /><div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='A' />
                  <span class="formula">\frac{25}{4}</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='B' />
                  <span class="formula">25</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='C' />
                  <span class="formula">50</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[2]' value='D' />
                  <span class="formula">100</span>
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">3.</span>
              The distance between the parallel lines given by <span class="formula">(x + 7y)^{2} + 4\sqrt{2}(x+7y)-42=0</span> is
            </div>
            <br /><div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='A' />
                  <span class="formula">\frac{4}{5}</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='B' />
                  <span class="formula">4\sqrt{2}</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='C' />
                  <span class="formula">2</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[3]' value='D' />
                  <span class="formula">10\sqrt{2}</span>
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">4.</span>
              If the area of the triangle formed by the pair of lines <span class="formula">8x^{2}-6xy + y^{2} = 0</span> and the line <span class="formula">2x + 3y = a</span> is 7 then a=
            </div>
           <br /> <div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='A' />
                  <span class="formula">14</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='B' />
                  <span class="formula">14\sqrt{2}</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='C' />
                  <span class="formula">28\sqrt{2}</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[4]' value='D' />
                  <span class="formula">28</span>
                </label>
              </li>
            </ul>
          </div>
        </div>
        <div class="question_container">
          <div class="question row">
            <div class='question'>
              <span class="question_number">5.</span>
              If the pair of lines given by <span class="formula">(x^{2}+y^{2})cos^{2}\theta=(xcos\theta + ysin\theta)^{2}}</span> are perpendicular to each other, then <span class="formula">\theta =</span>
            </div>
            <br /><div class='remediation'></div>
            <ul class="choices">
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='A' />
                  <span class="formula">0</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='B' />
                  <span class="formula">\frac{\pi}{4}</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='C' />
                  <span class="formula">\frac{\pi}{3}</span>
                </label>
              </li>
              <li class="choice">
                <label class="radio">
                  <input type='radio' name='questions[5]' value='D' />
                  <span class="formula">3\frac{\pi}{4}</span>
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


    </div><!-- /.container -->

    <script src="js/jquery.js"></script>
    <script src="js/d3.js"></script>
    <script src="js/holder.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/formula.js"></script>
    <script type="text/javascript">
      var rem = <?php echo (isset($_GET['rem'])) ? "true" : "false" ?>;

      $(document).ready(function(){
        updateFormulas();

        $("#submit_exam").click(function(){

          $("#alert_area").html("");

          // Go Over each question to see if its answered
          var num_questions = $(".question_container").length;
          var num_answered = $("ul.choices li input:checked").length;

          console.log(num_questions + " - " + num_answered);

          if(!rem && num_answered != num_questions)
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
                    'The answer is ... because ... See <a href="#">This page</a> for more information'+ 
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
                    'The answer is ... because ... See <a href="#">This page</a> for more information'+ 
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
          if(!rem) $('#quiz_confirmation_modal').modal({});
        });

        if(rem) $("#submit_exam").click();
      });
    </script>
