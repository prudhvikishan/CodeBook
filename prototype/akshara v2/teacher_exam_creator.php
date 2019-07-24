

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
                    <input type="text" class="form-control" placeholder="40" />
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
            <div class="col-lg-4">
              <div>
                <input type='text' style='width:100%;' id='slider1' class='percent_slider' value='' data-slider-min='0' data-slider-max='100' data-slider-step='1' data-slider-value='0' data-slider-orientation='horizontal' data-slider-selection='after' data-slider-tooltip='hide'>
                <div class='col-lg-1 pct_label'>0%</div>
              </div>
            </div>
            <div class="col-lg-4">
              <div>
                <input type='text' style='width:100%;' id='slider1' class='percent_slider' value='' data-slider-min='0' data-slider-max='100' data-slider-step='1' data-slider-value='0' data-slider-orientation='horizontal' data-slider-selection='after' data-slider-tooltip='hide'>
                <div class='col-lg-1 pct_label'>0%</div>
              </div>
            </div>
            <div class="col-lg-4">
              <div>
                <input type='text' style='width:100%;' id='slider1' class='percent_slider' value='' data-slider-min='0' data-slider-max='100' data-slider-step='1' data-slider-value='0' data-slider-orientation='horizontal' data-slider-selection='after' data-slider-tooltip='hide'>
                <div class='col-lg-1 pct_label'>0%</div>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
        <div class='row'><div class="col-lg-4 col-lg-offset-4 center"><a href="#" id="generate_exam" class="btn btn-primary">Generate Exam</a></div></div>
    </div><!-- /.container -->

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
        $(target).slider('setValue', val);
        $(target).attr("data-current-value", val);
        $(target).parent().parent().parent().find(".pct_label").html(Math.floor(val) + "%");
      }

      function generateExam()
      {
        
      }
      $("#generate_exam").click(generateExam);

		});

    </script>
 