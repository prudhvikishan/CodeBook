<h3 class="page-header">
	<small>
		<?php 
			$parentCourse = Courses_model::LoadById($this->parent['course_id']); 
			if($parentCourse->isIntroCourse()):
		?>
			<a href="<?= site_url('student'); ?>">Courses</a> &raquo; 
		<?php else: ?>
			<a href="<?= site_url('student/learning_map/' . encode($this->parent['course_id'])); ?>">Learning Map</a> &raquo; 
		<?php endif; ?>
	</small><?= $this->topic->name; ?>
</h3>

<div class="row">

	<div class="col-md-3">
		<section class="block track-map">
			<h4>Course Materials</h4>
			
			<div class="body">

				<div class="other-subcategories">

					<ul class="content-list">

					<?php foreach($this->courseContents as $courseContent): ?>

						<li class="subcategory">
							<div class="description">

								<span class="fa-stack <?php if(!$courseContent->available($this->user)) { echo "fa-lock"; } else if($courseContent->userHasCompleted()){ echo 'fa-complete'; } ?>">
									<i class="fa fa-square fa-stack-2x"></i>

									<?php 
										switch( $courseContent->content_type ) {
											case "video":
												echo "<i class='fa fa-fw fa-stack-1x fa-inverse ";
												if(!$courseContent->available($this->user)) {
													echo "fa-lock";
												} else { echo "fa-video-camera"; }
												echo "'></i>";
												break;
											case "text/html":
												echo "<i class='fa fa-fw fa-stack-1x fa-inverse ";
												if(!$courseContent->available($this->user)) {
													echo "fa-lock";
												} else { echo "fa-file"; }
												echo "'></i>";
												break;
											case "inline_html":
												echo "<i class='fa fa-fw fa-stack-1x fa-inverse ";
												if(!$courseContent->available($this->user)) {
													echo "fa-lock";
												} else { echo "fa-file"; }
												echo "'></i>";
												break;
											case "application/pdf":
												echo "<i class='fa fa-fw fa-stack-1x fa-inverse ";
												if(!$courseContent->available($this->user)) {
													echo "fa-lock";
												} else { echo "fa-file"; }
												echo "'></i>";
												break;
										}
									?>

								</span>
								<?php if($courseContent->available($this->user)): ?>
									<a data-content-id="<?= $courseContent->content_id; ?>" href="<?= site_url('content/review/' . encode($courseContent->content_id)); ?>"><?= $courseContent->name; ?></a>
								<?php else: ?>
									<?= $courseContent->name; ?>
								<?php endif; ?>
							</div>
						</li>

					<?php endforeach; ?>

					

					</ul>

				</div>

			</div>
		</section>

	</div>

	<div class="col-md-9">
		<section id="content_container" data-content-locked="<?= $this->content->available($this->user) ? "false" : "true"; ?>" class="block track-map" data-content-id="<?= $this->content->content_id ?>" data-content-type="<?= $this->content->content_type; ?>" 
				data-description="<?= $this->content->description ?>">

			<h4 class="content-heading"><?= $this->content->name; ?> <!-- <small><i class="fa fa-fw fa-gift"></i> 
				<?php if($this->content->content_type == "video") { ?> Watch <?php } else { ?> Read <?php } ?> for 10 Points</small>--></h4>
			<div id="content" class="body course-content">

				

			</div>
		</section>
		<?php $k = 0; $index = 0 ; 
			foreach($this->courseContents as $courseContent){ 
				if($this->content->content_id == $courseContent->content_id){
					$index = $k;
				}
				$k++;
			}
			
			$hasPrevious = false;
			$hasNext = false; 
			if($k == 1) {
			} else if($index !=0 && $index == $k-1 ) {
				$hasPrevious = true;
			} else if($index < $k) {
				if($index !=0){
					$hasPrevious = true;
				}
				$hasNext = true;
			}?>
  		<div id="back_learn1" <?php if(!$this->alreadyCompleted) {?> style="display:none" <?php } ?>>
  		<div class="row" >
			<div class="col-md-3">
			<?php if($hasPrevious) {?>
				<a id="previous-course" href="<?= site_url('content/review/' . encode($this->courseContents[$index-1]->content_id)); ?>" class="btn btn-secondary btn-block mb"><i class="fa fa-fw fa-arrow-circle-left"></i>Previous</a>
			<?php } ?>
			</div>
			<div class="col-md-6">
			</div>
			<div class="col-md-3">
			<?php if($hasNext) {?>
					<a id="next-course" href="<?= site_url('content/review/' . encode($this->courseContents[$index+1]->content_id)); ?>" class="btn btn-secondary btn-block mb"><i class="fa fa-fw fa-arrow-circle-right"></i>Next</a>
			<?php } else { ?>
					<a class="btn btn-secondary btn-block mb" href="<?= site_url('student/learning_map/' . encode($this->parent['course_id'])); ?>"><i class="fa fa-fw fa-arrow-circle-right"></i>Back to Course</a> 
			<?php }?>
			</div>
		</div>
		</div>	


		<div class="row">
			<?php if(!$this->alreadyCompleted) {?>
			<div id="cont_complete">
				<div class="col-md-6 reward">
					<i class="fa fa-fw fa-gift"></i> Reward: 100 Points
				</div>
				<div class="col-md-6">
					<a id="complete-course" class="btn btn-secondary btn-block mb"><i class="fa fa-fw fa-check"></i> I have completed this</a>
				</div>
			</div>
			<div id="back_learn" style="display:none">
				<div class="col-md-12 reward-complete">
					<i class="fa fa-fw fa-gift"></i> You received 100 points for completing this activity.
				</div>
				</div>
			<?php if($parentCourse->isIntroCourse()){?>
				<div id="back_learn" style="display:none">
				<div  class="col-md-8 reward-complete">
					<i class="fa fa-fw fa-gift"></i> You received 100 points for completing this activity.
				</div>
				<div class="col-md-4">
						<a href="<?= site_url('student'); ?>" class="btn btn-secondary btn-block mb"> Go to Dashboard <i class="fa fa-fw fa-arrow-circle-right"></i></a>					
				</div>
				</div>
				<?php } ?>
				
			<?php } else { ?>
					<?php if($parentCourse->isIntroCourse()){?>
				<div class="col-md-8 reward-complete">
					<i class="fa fa-fw fa-gift"></i> You received 100 points for completing this activity.
				</div>
				<div class="col-md-4">
						<a href="<?= site_url('student'); ?>" class="btn btn-secondary btn-block mb"> Go to Dashboard <i class="fa fa-fw fa-arrow-circle-right"></i></a>					
				</div>
				<?php } else { ?>
					
				<div class="col-md-12 reward-complete">
					<i class="fa fa-fw fa-gift"></i> You received 100 points for completing this activity.
				</div>
				
			<?php } } ?>
				<!-- <div id="back_learn" <?php if(!$this->alreadyCompleted) {?> style="display:none" <?php } ?>>

					<div class="col-md-6 reward">
						<i class="fa fa-fw fa-gift"></i> Rewarded: 100 Points
					</div>
					<div class="col-md-6">
						<a href="<?= site_url('student/learning_map/' . encode($this->parent['course_id'])); ?>" class="btn btn-theme btn-block mb"><i class="fa fa-fw fa-arrow-circle-left"></i> Back to learning map</a>					</div>
				</div> -->
				 	
		</div>

		<hr style="margin-top: 0;">

		<div class="row mb">

			<div class="col-md-12">
				<h4>Comments</h4>
				<ul class="comments-section">
					<?php foreach($this->comments as $comment): ?>
						<li>
							<p class='comment'><?= $comment->comment; ?></p>
							<p class='posted-by'>Posted by <a href="#"><?= $comment->getPosterName(); ?></a> <span class="posted-on">- <?= $comment->posted_on; ?></span></p>
						</li>
					<?php endforeach; ?>
				</ul>
				<p class='feedback'>&nbsp;</p>
				<?= form_open(null, array("id" => "comments_form")); ?>
					<div class="form-group">
						<div id="comment_preview"></div>
						<textarea class="form-control" data-preview-artifact-id="comment_preview"></textarea>
					</div>
					<div class="right">
						<a href="#" id="comment_button" disabled class="btn btn-secondary"><i class="fa fa-fw fa-comment"></i> Add A Comment</a>
					</div>
				<?= "</form>"; ?>
			</div>

		</div>
	</div>

</div>

<script>

$(document).ready(function() {

	$("#complete-course").on('click', function() {
		saveContentPoints();

		var bootboxMessage = "";
<?php if($this->levelUp) {?>
		bootboxMessage += "<div class='row mb'>";
		bootboxMessage += "<div class='col-md-12'>";

		bootboxMessage += "<div class='earned-content level-earned'>";
		bootboxMessage += "<h5>Level Up!</h5>";
		bootboxMessage += "<div class='level'>";
		bootboxMessage += "<div class='level-reason'>";
		bootboxMessage += "<h6>Congratulations!</h6>";
		bootboxMessage += "<p><i class='fa fa-fw fa-thumbs-up'></i> You're now level <?php echo $this->nextLevelInfo['next_level']; ?>.</p>";
		bootboxMessage += "</div></div>";
		bootboxMessage += "</div>";

		bootboxMessage += "</div></div>";
				<?php } ?>

		bootboxMessage += "<div class='row mb'>";
				<?php if($this->lastContentForTopic) { ?>

		bootboxMessage += "<div class='col-md-4'>";
		bootboxMessage += "<div class='earned-content badges-earned'>";
		bootboxMessage += "<h5>Badges Earned</h5>";
		bootboxMessage += "<div class='badges'>";
		bootboxMessage += "<i class='fa fa-fw fa-trophy complete100'></i>";
		bootboxMessage += "<h4>100% Complete</h4>";
		bootboxMessage += "</div>";
		bootboxMessage += "</div></div>";
		bootboxMessage += "<div class='col-md-8'>";
		<?php } else { ?>
		bootboxMessage += "<div class='col-md-12'>";
		<?php } ?>		
		bootboxMessage += "<div class='earned-content points-earned'>";
		bootboxMessage += "<h5>Points Earned</h5>";
		bootboxMessage += "<ul>";

		bootboxMessage += "<li>";
		bootboxMessage += "<div class='point-count'>";
		bootboxMessage += "100";
		bootboxMessage += "</div>";
		bootboxMessage += "<div class='point-reason'>";
		bootboxMessage += "<h6>Points for content</h6>";
		bootboxMessage += "<p>Each piece of content earned you points.</p>";
		bootboxMessage += "</div>";
		bootboxMessage += "</li>";
		<?php if($this->lastContentForTopic) { ?>
		// bootboxMessage += "<li>";
		// bootboxMessage += "<div class='point-count'>";
		// bootboxMessage += "200";
		// bootboxMessage += "</div>";
		// bootboxMessage += "<div class='point-reason'>";
		// bootboxMessage += "<h6>Points for topic completion</h6>";
		// bootboxMessage += "<p>Bonus completion points.</p>";
		// bootboxMessage += "</div>";
		// bootboxMessage += "</li>";
		<?php } ?>
		bootboxMessage += "<li class='total-point-count'>";
		bootboxMessage += "<div class='point-count'>";
		<?php if($this->lastContentForTopic) { ?>
		bootboxMessage += "100";
		<?php } else { ?>
		bootboxMessage += "100";
		<?php } ?>		
		bootboxMessage += "</div>";
		bootboxMessage += "<div class='point-reason'>";
		bootboxMessage += "<h6>Total Points</h6>";
		bootboxMessage += "</div>";
		bootboxMessage += "</li>";

		bootboxMessage += "</ul>";
		bootboxMessage += "</div></div></div>";
		<?php if($this->lastContentInCourse){?>

		bootboxMessage += "<div class='row'>";
		bootboxMessage += "<div class='col-md-12'>";
		bootboxMessage += "<a href='#' class='btn btn-secondary btn-block'>Go to next course <i class='fa fa-fw fa-arrow-circle-right'></i></a>";
		bootboxMessage += "</div></div>";
		<?php } ?>
		<?php if(!$this->user->isIntroComplete()){?>
		bootboxMessage += "<div class='row'>";
		bootboxMessage += "<div class='col-md-12'>";
		bootboxMessage += "<a href='<?= site_url('student'); ?>' class='btn btn-secondary btn-block'>Go to Dashboard <i class='fa fa-fw fa-arrow-circle-right'></i></a>";
		bootboxMessage += "</div></div>";
		<?php } ?>
		<?php if($this->user->isIntroComplete() && $hasNext){?>
		bootboxMessage += "<div class='row'>";
		bootboxMessage += "<div class='col-md-12'>";
		bootboxMessage += "<a href='<?= site_url('content/review/' . encode($this->courseContents[$index+1]->content_id)); ?>' class='btn btn-secondary btn-block'>Next Content<i class='fa fa-fw fa-arrow-circle-right'></i></a>";
		bootboxMessage += "</div></div>";
		<?php } else if($this->user->isIntroComplete() && !$hasNext) { ?>
		bootboxMessage += "<div class='row'>";
		bootboxMessage += "<div class='col-md-12' class='point-reason' style='padding-bottom:10px;text-align:center;margin-top:-20px'><h6>YOU HAVE COMPLETED ALL THE CONTENT IN THE SUBTOPIC:</h6> ";
		bootboxMessage += "<strong><?= $this->topic->name; ?></strong>";
		bootboxMessage += "</div></div>";
		bootboxMessage += "<div class='row'>";
		bootboxMessage += "<div class='col-md-12'>";
		bootboxMessage += "<a href='<?= site_url('student/learning_map/' . encode($this->parent['course_id'])); ?>' class='btn btn-secondary btn-block'>Back to Course <i class='fa fa-fw fa-arrow-circle-right'></i></a>";
		bootboxMessage += "</div></div>";
		<?php }?>
		bootbox.dialog({
			message: bootboxMessage,
			title: "<?= $this->topic->name; ?>"
		});

	});

});

function saveContentPoints(){
	$.ajax({
		url: "<?= base_url(); ?>content/complete" ,
		type: "post",
		data: { 
			content_id : $("#content_container").attr("data-content-id")
		},
		success: function(){
						$("#cont_complete").hide();
					$("#back_learn").show();
					$("#back_learn1").show();
				},
				error:function(){
					//alert("failure");
					//$("#result").html('There is error while submit');
				}
			});
}
</script>

<script type="text/javascript">
	$(function(){
		var startViewingContentTime = new Date();

		// bind click handler to the content links
		var content_id = $("#content_container").attr("data-content-id");
		var content_type = $("#content_container").attr("data-content-type");
		var contentLocked = $("#content_container").attr("data-content-locked");
		// if(contentLocked === "true") { 
		// 	window.location = "<?= base_url(); ?>content/review/"+$("a[data-content-id]:eq(0)").attr("data-content-id");
		// 	return ;
		// }
	
		switch(content_type)
		{
			case "application/pdf":
				// drop the pdf into an iframe
				$("#content").html("<iframe src='<?= base_url(); ?>content/view/"+content_id+"'><iframe>");
				$("#content iframe").css({
					"width":"100%",
					"height":"100%",
					"min-height":"500px"
				});
				Formula.updateFormulas();
				break ;
			case "video":
			case "text/html":
			case "inline_html":
				// load the content into the div
				$.get("<?= base_url(); ?>content/view/"+content_id, {}, function(data){
					$("#content").html(data);
					Formula.updateFormulas();
				}).fail(function(){
					$("#content").html("This content is not available.");
				});
				break ;
			default:
				$("#content").html("Unknown Content Type");
		}

		// Make sure we track the question time when they leave the page
		$(window).bind('beforeunload', function() { 
			var endTime = new Date();
			Tracker.trackEvent("content_time", content_type, content_id, endTime - startViewingContentTime, false);
		});

		// Handle comment posting
		$("#comments_form").submit(function(e){
			e.preventDefault();
			var comment = $("textarea", this).val();
			$.post(base_url + "content/post_comment/" + content_id, {"comment":comment}, function(data){
				// $(".feedback", $(e.target).parent()).html(data);
				$("#comments_form textarea").val("");
				window.location.reload();
			});
		});

		$("#comments_form a.btn").click(function(e){
			e.preventDefault();
			$(this).closest('form').submit();
		});

		Formula.createSmallEditor("#comments_form textarea", true, function(data){
			if($(data).text().trim().length === 0) {
				$("#comment_button").attr("disabled", "disabled");
			} else {
				$("#comment_button").removeAttr("disabled");
			}
		});
	});
</script>
