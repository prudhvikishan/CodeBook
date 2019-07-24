<h1>Content for <strong><?= $this->topic->name; ?></strong></h1>
<div class="row">
  <div class="col-md-12">
    <a class="btn btn-orange" style="width:107px;" href='<?= base_url(); ?>content/create/<?= $this->topic->topic_id; ?>'><i class="icon-plus-sign"/> Content</i></a>
    <a class="btn btn-orange" style="width:107px;" href='<?= base_url(); ?>content/create_video/<?= $this->topic->topic_id; ?>'><i class="icon-plus-sign"/> Video</i></a>
  </div>
</div>
<div class="row">
	<div class="col-md-12">
		<table style="width:100%;">
			<thead><tr><th>Name</th><th>Content Type</th><th>Content Path</th><th>Edit</th><th>Delete</th></tr></thead>
			<tbody>
				<?php foreach($this->content as $content): ?>
					<tr>
						<td><?= $content->name; ?></td>
						<td><?= $content->content_type; ?></td>
						<td><?= $content->content_type == "inline_html" ? "<em>Inline HTML Content (not shown)</em>" : $content->content_path; ?></td>
						<td><a href="<?= base_url(); ?>content/edit/<?= $content->content_id; ?>">Edit</a></td>
						<td><a href="#">Delete</a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>