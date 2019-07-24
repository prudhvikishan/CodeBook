<!DOCTYPE html>
<html>
<head>
<title>Teacher Dashboard</title>
<!-- Bootstrap -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.min.css" rel="stylesheet">

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/d3.js"></script>

<link href="css/slider.css" rel="stylesheet">    
<link href="css/custom.css" rel="stylesheet">
<link href="css/charts.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>
<?php include "header.php" ?>

    <div class="container">
      <div class="row" style="margin-top:10px;">
        <div class="col-lg-12">
          <div class="panel">
            <div class="panel-heading">
            <strong><span class="glyphicon glyphicon-pencil"></span> Create Question</strong>
          </div>
               <div class="row" style="margin-bottom:10px;">
                <div class="col-lg-2">
                  
                    <h5>Question Grouping</h5>
                  </div>
                    <div class="col-lg-3">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="checkbox">
                        </span>
                        <span class='form-control'>Practice Question</span>
                      </div><!-- /input-group -->
                    </div><!-- /.col-lg-5 -->
                    <div class="col-lg-3">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="checkbox">
                        </span>
                        <span class='form-control'>Exam Question</span>
                      </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                  </div><!-- /.row -->

            <div class="row" style="margin-bottom:10px;">
              <div class="col-lg-2">
              <h5>Question Difficulty</h5>
            </div>
              <div class="col-lg-3">
                <div class="input-group">
                  <span class="input-group-addon">
                    <input type="radio" name='question_difficulty' />
                  </span>
                  <span class='form-control'>Easy</span>
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
              <div class="col-lg-3">
                <div class="input-group">
                  <span class="input-group-addon">
                    <input type="radio" name='question_difficulty' />
                  </span>
                  <span class='form-control'>Medium</span>
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
              <div class="col-lg-3">
                <div class="input-group">
                  <span class="input-group-addon">
                    <input type="radio" name='question_difficulty' />
                  </span>
                  <span class='form-control'>Hard</span>
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
      
          <div class="row">
          <div class="col-lg-2">
            <h5>Tags</h5>
          </div>
          <div class="col-lg-10">
            <div class="input-group">
              <input type="text" id="tag_entry" autocomplete="off" class="form-control" />
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Add Tag</button>
              </span>
            </div><!-- /input-group -->

          </div>

          </div>

           <div class="row">
          <div class="col-lg-12">
            <hr/>
          </div>
        </div>

          <div class="row" style="margin-bottom:10px;">
          <div class="col-lg-12">
  

          <h5>Question</h5>

        
        <textarea cols="80" id="quesetion_prompt" name="quesetion_prompt" rows="10"></textarea>
        <hr />
        <label>Choice A</label>
        <textarea cols="80" id="choice_a" name="choices[0]" class="choice_editor" rows="2"></textarea><br />
        <label>Choice B</label>
        <textarea cols="80" id="choice_b" name="choices[1]" class="choice_editor" rows="2"></textarea><br />
        <label>Choice C</label>
        <textarea cols="80" id="choice_c" name="choices[2]" class="choice_editor" rows="2"></textarea><br />
        <label>Choice D</label>
        <textarea cols="80" id="choice_d" name="choices[3]" class="choice_editor" rows="2"></textarea><br />
     
       
          </div>
          </div>

           <div class="row" style="margin-bottom:10px;text-align:center;">
          <div class="col-lg-12">
            <hr/>
             <input type='button' name='create_question' class="btn btn-primary" value="Create" />
          </div>
        </div>
  
          </div> <!--Panel-->
        </div><!-- Main 12 columns -->
          </div> <!-- Main Row -->
        </div>
      </div>

      	
   

       
    </div><!-- /.container -->

    <script src="js/jquery.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <script src="ckeditor/config.js"></script>
	<script src="ckeditor/adapters/jquery.js"></script>	
    <script src="js/d3.js"></script>
    <script src="js/holder.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

	    CKEDITOR.disableAutoInline = true;

		$( document ).ready( function() {
			$( '#quesetion_prompt' ).ckeditor({height:"300px", extraPlugins: 'eqneditor'});
      $( '.choice_editor' ).ckeditor(
        {
          height:"75px", 
          extraPlugins: 'eqneditor',
          toolbar :
          [
            { name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
            { name: 'paragraph', items : [ 'NumberedList','BulletedList' ] },
            { name: 'tools', items : [ 'Maximize','-','About' ] },
            { name: 'insert', items : [ 'Image','Table','HorizontalRule','SpecialChar','PageBreak'
                 ,'Iframe','EqnEditor' ] },
          ]
        });
		});

    </script>
  </body>
</html>