
<div class="row">
	<div class="col-lg-12">
<?php foreach($this->courses as $course): ?>
	
	<table style="width:100%">
	<thead><tr><th class="course textgrey" width="60%"><?= $course->name; ?></th>
		<th width="20%"> <a class="btn btn-orange" style="width:107px;" href='<?= base_url(); ?>course/addtopic/courseId/<?= $course->course_id; ?>'><i class="icon-plus-sign"/> Topic</a></th>
		<th width="20%"></th>
	</tr></thead>
	</table>
	<hr class="style-three"/>
		<?php foreach($course->getCourseTopics() as $topic): ?>
		<table style="width:100%">
		<thead><tr><th width="60%"><th width="20%"> </th><th width="15%"></th><th width="20%"></th></tr></thead>
		<tbody>
			<tr>
				<td class="topic"><?= $topic->name; ?></td>
				<td><a  class="btn btn-orange" style="width:107px;"  href='<?= base_url(); ?>course/addtopic/topicId/<?= $topic->topic_id; ?>/<?= $course->course_id; ?>'><i class="icon-plus-sign"/> Sub-Topic</i></a></td>
				<td><a class="btn btn-chocolate" href='<?= base_url(); ?>question/by_topic/<?= $topic->topic_id; ?>'><i class="icon-book"/> Questions</i></a></td>
				<td><a class="btn btn-chocolate" href='<?= base_url(); ?>content/by_topic/<?= $topic->topic_id; ?>'><i class="icon-book"/> Content</i></a></td>
				<!--<td><a class="textchocolate" href='<?= base_url(); ?>question/by_topic/<?= $topic->topic_id; ?>'><i class="icon-book"/> Questions</i></a></td>-->
				<!--<td><a class="btn btn-blue" href='<?= base_url(); ?>course/edittopic/<?= $topic->topic_id; ?>'><i class="icon-edit-sign"/> Edit Topic</i></a></td>-->

				<td></td>
			</tr>
			<?php if($topic->getSubTopics() != null && count($topic->getSubTopics()) > 0): ?>
					<?php foreach($topic->getSubTopics() as $subtopic): ?>
						<tr>
							<td class="subtopic"><?= $subtopic->name; ?></td>
							<td></td>
							<td><a class="btn btn-chocolate" href='<?= base_url(); ?>question/by_topic/<?= $subtopic->topic_id; ?>'><i class="icon-book"/> Questions</i></a></td>
							<td><a class="btn btn-chocolate" href='<?= base_url(); ?>content/by_topic/<?= $subtopic->topic_id; ?>'><i class="icon-book"/> Content</i></a></td>
							<!--<td><a class="btn btn-orange" style="width:107px;" href='<?= base_url(); ?>question/create/<?= $subtopic->topic_id; ?>'><i class="icon-plus-sign"/> Question</i></a></td>-->
							<!--<td><a class="btn btn-blue" href='<?= base_url(); ?>course/edittopic/<?= $subtopic->topic_id; ?>'><i class="icon-edit-sign"/> Edit topic</i></a></td>-->
						
						</tr>
					<?php endforeach; ?>
			<?php endif ?>	
			</tbody>
			</table>
			<hr class="style-three"/>
		<?php endforeach; ?>

</table>

<?php endforeach; ?>
</div>
</div>
<!--<div class="row">
					<a class="btn btn-orange" href='<?= base_url(); ?>course/addcourse'><i class="icon-plus-sign"/>  Course</i></a></td>
</div>-->
