

    <div class="container">


              <div class="row">
                <div class="col-lg-12">
                 <div class="panel" >
                   <div class="panel-heading">
                     <strong>Create an Exam</strong>
                   </div>
                   <div class="row">
                  <div class="col-lg-4">
                    <span class="help-block">Exam Name</span>
                    <input type="text" class="form-control" placeholder="Algebra Practice Exam" />
                  </div>
                  <div class="col-lg-4">
                    <span class="help-block">Number of Questions</span>
                    <input type="text" class="form-control" placeholder="40" id="number_of_questions" />
                  </div>
                  <div class='col-lg-4'>
                    <span class="help-block">Start Date</span>
                    <input type="date" class="form-control" />
                  </div>
                </div>
              </div>
              </div>
            </div>
   
          <div class="row">
      
            
          <div class="col-lg-12">

              <div class="panel" >
             <div class="panel-heading">
               <strong>Add Topics to Exam</strong>
             </div>
             <div class="row">
    
                       <div class="col-lg-10">
             <select id="topic_select" class="form-control">
                  <option value="-1">Select A Topic To Add</option>
                  
                </select>
                </div>
       
              <div class="col-lg-2">
                <a href="#" id="add_topic" class="btn btn-primary">Add Topic</a>
              </div>
          </div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-lg-12" >

            <div class="panel" id="slider_holder">
             <div class="panel-heading">
               <strong>Topics</strong>
             </div>
          </div>
        </div>
      </div>
        <div class="row" id="difficulty_sliders">
          <div class="col-lg-12">
           <div class="panel" >
            <div class="panel-heading">
              <strong>Difficulty Level</strong>
            </div>
            <div class="row">
              <div class="col-lg-4" style="text-align:center;">
                  Easy
              </div>
              <div class="col-lg-4" style="text-align:center;">
                  Medium
              </div>
              <div class="col-lg-4" style="text-align:center;">
                  Hard
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4">
                <div>
                  <input type='text' style='width:100%;' id='slider1' class='percent_slider' value='' data-slider-min='0' data-slider-max='100' data-slider-step='1' data-slider-value='0' data-slider-orientation='horizontal' data-slider-selection='after' data-slider-tooltip='hide'>
                  <div class='col-lg-1 pct_label'>0%</div>
                </div>
              </div>
              <div class="col-lg-4">
                <div>
                  <input type='text' style='width:100%;' id='slider2' class='percent_slider' value='' data-slider-min='0' data-slider-max='100' data-slider-step='1' data-slider-value='0' data-slider-orientation='horizontal' data-slider-selection='after' data-slider-tooltip='hide'>
                  <div class='col-lg-1 pct_label'>0%</div>
                </div>
              </div>
              <div class="col-lg-4">
                <div>
                  <input type='text' style='width:100%;' id='slider3' class='percent_slider' value='' data-slider-min='0' data-slider-max='100' data-slider-step='1' data-slider-value='0' data-slider-orientation='horizontal' data-slider-selection='after' data-slider-tooltip='hide'>
                  <div class='col-lg-1 pct_label'>0%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class='row' style="margin-bottom:20px;"><div class="col-lg-4 col-lg-offset-4 center"><a href="#" id="generate_exam" class="btn btn-primary">Generate Exam</a></div></div>
    </div><!-- /.container -->

    <div class="modal fade" id="exam_generation_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Exam Generated Successfully!</h4>
          </div>
          <div class="modal-body">
            <p>Your exam has been generated, below is a breakdown of the questions generated: </p>

            <table class="table">
              <thead><th>Topic</th><th>Easy</th><th>Medium</th><th>Hard</th><th>Total</th></tr></thead>
              <tbody id="result_body"></tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    

    <script src="js/jquery.js"></script>
    <script src="js/d3.js"></script>
    <script src="js/holder.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-slider.js"></script>
     <script type="text/javascript">
    var topics; 

    $( document ).ready( function() {
      // rebalance the diffculty sliders
      rebalanceSliders(null, $("#difficulty_sliders"));

      // Go get the syllabus from the JSON
      $.get("data/maths_syllabus_json.txt", {}, function(data)
      {
        topics = data.syllabus.subjects.subject.topics.topic;

        // now populate the select box.
        var num_topics = topics.length;
        var input = $("#topic_select");
        for(var x = 0 ; x < num_topics ; x++)
          input.append("<option value='"+x+"'>" + topics[x].name + "</option>");

        // Bind an event to the add topic button.
        $("#add_topic").click(function(){
          // get the topic index chosen
          var chosen = $("#topic_select").val();
          if(chosen == -1) return ;

          // remove the chosen entry from the select 
          $("option[value='"+chosen+"']", input).remove();

          // get all of the sub-topics
          var subtopics = topics[chosen].subtopics.subtopic;

          // Loop over the subtopics and add slider groups for each one.
          var slider_holder = $("#slider_holder");
          var num_subtopics = subtopics.length;
          for(var x = 0 ; x < num_subtopics ; x++)
          {
            slider_holder.append(
              "<div class='row'>" +
                "<div class='col-lg-7' style='text-align:right;'>" + topics[chosen].name + " - " + subtopics[x].name + "</div>" + 
                "<div class='col-lg-4'>" + 
                  "<input type='text' style='width:100%;' id='slider1' class='percent_slider' value='' data-slider-min='0' data-slider-max='100' data-slider-step='1' data-slider-value='0' data-slider-orientation='horizontal' data-slider-selection='after' data-slider-tooltip='hide'> " + 
                "</div>" + 
                "<div class='col-lg-1 pct_label'>0%</div>" + 
              "</div>"
            );
          }

          // Rebalance the sliders
          rebalanceSliders(null, $("#slider_holder"));
        });

      }, "json");

      // A function to compute the sum of all sliders
      function computeSum(parent)
      {
        var sum = 0;
        $(".percent_slider", parent).each(function(i, item){
          var amt = $(item).attr("data-current-value");
          if(!amt) amt = 0;
          sum += parseInt(amt);
        });
        return sum;
      }

      // A function to evenly distribute the question weight among all sliders
      function rebalanceSliders(target, parent)
      {
        // unbind the slide handler
        $('.percent_slider', parent).slider().off('slide');
        $(".slider").css({"width":"100%"});

        // bind the correct slide handler
        $('.percent_slider', parent).slider().on('slide', function(ev){
          setSliderValue(ev.value, this);

          var newSum = computeSum(parent);
          if(newSum > 100)
            setSliderValue(ev.value - (newSum - 100), this);

          // rebalanceSliders(ev.value, this); 
        });

        // Compute the sum of the sliders
        var sum = computeSum(parent);

        // Go over all of the sliders and compute their values
        var numOtherSliders = $(".percent_slider", parent).not(target).length;

        // now divide the sum among the other sliders
        var remaining = Math.ceil(100 - sum);
        var partPerItem = Math.floor(remaining / numOtherSliders);
        var slidersUpdated = 0;

        $(".percent_slider", parent).each(function(i, item){
          if(item == target) return ;

          var currentValue = parseInt($(item).attr('data-current-value'));
          if(!currentValue) currentValue = 0;

          var newValue = currentValue + partPerItem;
          if(newValue < 0) newValue = 0;

          setSliderValue(newValue, item);
        });
      } 

      function setSliderValue(val, target)
      {
        $("input", $(target).parent()).val(val);
        $(target).slider('setValue', val);
        $(target).attr("data-current-value", val);
        $(target).parent().parent().parent().find(".pct_label").html(Math.floor(val) + "%");
      }

      function generateExam()
      { 
        // get the table to populate with the results
        var tbody = $("#result_body");
        tbody.html("");

        // figure out how many questions the exam has
        var num_questions = parseInt($("#number_of_questions").val());
        var easy_pct = (parseInt($("#difficulty_sliders .percent_slider:eq(0)").val()) / 100.0);
        var medium_pct = (parseInt($("#difficulty_sliders .percent_slider:eq(1)").val()) / 100.0);
        var hard_pct = (parseInt($("#difficulty_sliders .percent_slider:eq(2)").val()) / 100.0);

        if(isNaN(num_questions)) num_questions = parseInt($("#number_of_questions").attr("placeholder").trim());

        // populate the table.
        // Go over each row and check the percent to determine how many questions that row is given.
        var total_questions = 0;
        var total_slider_count = $("#slider_holder div.row").length;
        $("#slider_holder div.row").each(function(i,item){
          var name = $("div:eq(0)", item).html();

          var percent = $(".percent_slider", item).val();
          var topic_question_count = Math.round(num_questions * (percent / 100.0));
          if(i == total_slider_count -1){
        	  topic_question_count = num_questions-total_questions;
          }

          // now figure out the distribution
          var easy_questions = Math.round(topic_question_count * easy_pct);
          var medium_questions = Math.round(topic_question_count * medium_pct);
          //var hard_questions = Math.round(topic_question_count * hard_pct);
		  var hard_questions = topic_question_count - (easy_questions + medium_questions);
          var total = easy_questions + medium_questions + hard_questions;
          total_questions += total;

          // build the tr
          var tr = $("<tr />");
          tr.append("<td>" + name + "</td>");
          tr.append("<td>" + easy_questions + "</td>");
          tr.append("<td>" + medium_questions + "</td>");
          tr.append("<td>" + hard_questions + "</td>");
          tr.append("<td><strong>" + total + "</strong></td>");

          // add it to the table
          tbody.append(tr);
        });        

        tbody.append("<tr><td colspan='4'><strong>Total Questions:</strong></td><td>" + total_questions + "</td></tr>");
        
        // show the modal
        $('#exam_generation_modal').modal({

        }); 
      }
      $("#generate_exam").click(generateExam);

    });

    </script>
 