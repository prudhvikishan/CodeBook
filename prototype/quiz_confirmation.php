<!DOCTYPE html>
<html>
<head>
<title>Quiz Confirmation</title>
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

<div class="container">

<div class="modal fade" id="quiz_confirmation_modal">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title center">Congratulations!</h4>
          </div>
          <div class="modal-body">
    
             <div class="row center">
              <div class="col-lg-3 col-lg-offset-3">
                <div class="panel">
                  <div class="panel-heading center">
                  <strong>Points</strong>
                  </div>
                  <div class="center">
                   <h4>You have earned</h4><h1 style="font-size:3.1em;">150</h1><h4> points</h4>
                 </div>
                 </div>
              </div>
              <div class="col-lg-3">
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
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->

</div>
    <script>
    $('#quiz_confirmation_modal').modal({

        });

    </script>

  </body>
  </html>