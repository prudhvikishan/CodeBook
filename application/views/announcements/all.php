<h1>Announcements</h1>
<a href='<?= base_url() . "instructor/announcements/new" ?>' class='btn btn-primary'>Post Announcement</a>

<table class='table'>
	<thead>
		<tr><th>Title</th><th>Posted By</th><th>Date Posted</th><th>Edit</th><th>Delete</th></tr>
	</thead>
	<tbody>
		<?php foreach($this->announcements as $a): ?>
			<tr>
				<td><?= $a->title; ?></td>
				<td><?= $a->getPostedByUser()->getName(); ?></td>
				<td><?= $a->posted_on; ?></td>
				<td><a href='<?= base_url() . "instructor/announcements/edit/" . $a->announcement_id; ?>'>Edit</a></td>
				<th><a href='<?= base_url() . "instructor/announcements/delete/" . $a->announcement_id; ?>'>Delete</a></th>
			</tr>
		<?php endforeach; ?>
	</tbody>	
</table>