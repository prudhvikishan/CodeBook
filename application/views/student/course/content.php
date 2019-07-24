<h3 class="page-header"><?= $this->topic->name; ?></h3>

<div class="row">

	<div class="col-md-12">
		<section class="block track-map">
			<h4>Course Materials</h4>
			<div class="body">

				<div class="course-subcategories">
					<ul>


						<?php foreach($this->content as $content): ?>

							<li class="subcategory">
								<a class="content-link" href="<?= site_url('content/review/' . $content->content_id); ?>">
									<div class="learning-type <?php if($content->userHasCompleted()){ echo 'completed'; }?>"><!-- Give class of completed if content has been viewed -->
										
										<?php 
										switch( $content->content_type ) {
											case "video":
												echo "<i class='fa fa-fw ";
												if(!$content->available) {
													echo "fa-lock"; 
												}
												else if($content->userHasCompleted()){ 
													echo "fa-check"; 
												} else { 
													echo "fa-video-camera"; 
												}
												echo "'></i><p>Video</p>";
												break;
											case "text/html":
												echo "<i class='fa fa-fw ";
												if(!$content->available) {
													echo "fa-lock"; 
												}
												else if($content->userHasCompleted()){ echo "fa-check"; } else { echo "fa-file"; }
												echo "'></i><p>Notes</p>";
												break;
											case "inline_html":
												echo "<i class='fa fa-fw ";
												if(!$content->available) {
													echo "fa-lock"; 
												}
												else if($content->userHasCompleted()){ echo "fa-check"; } else { echo "fa-file"; }
												echo "'></i><p>Notes</p>";
												break;
											case "application/pdf":
												echo "<i class='fa fa-fw ";
												if(!$content->available) {
													echo "fa-lock"; 
												}
												else if($content->userHasCompleted()){ echo "fa-check"; } else { echo "fa-file"; }
												echo "'></i><p>Notes</p>";
												break;
										}
										?>

									</div>

									<div class="description">
										<h5>
											<?= $content->name; ?>
										</h5>
										<span><?= $content->description; ?></span>
									</div>
								</a>
							</li>

						<?php endforeach; ?>
					</ul>
				</div>

			</div>
		</section>

		<div class="center"><a href="<?= site_url('student/learning_map/' . $this->course->course_id); ?>" class="btn btn-secondary mb">Back To Learning Map</a></div>

	</div>

</div>