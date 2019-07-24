

	<div id="container" class="container">
	</div>
<script>
(function() {
 $.getJSON('data/maths_syllabus_json.txt', function(data) {
var topics = data.syllabus.subjects.subject.topics;
$.each( topics.topic, function( i, topic ) {
		var topicName = topic.name;
		$('#container').append('<table id="topic'+i+'" class="table table-striped padtop"><tr ><th style="width:70%">' + topicName + '</th><th class="center" style="width:15%">'+
		'View Questions</th><th class="center" style="width:15%">Add Question</th></tr>');
             
		var subtopics = topic.subtopics;
      $.each( subtopics.subtopic, function( j, subtopic ) {
        $('#topic'+i).append('<tr><td style="width:70%">'+subtopic.name+'</td><td class="center" style="width:15%"><a href="teacher_view_questions.php">View Questions</a></td><td class="center" style="width:15%"><a href="teacher_question_editor.php">Add Question</a></td></tr>');
    });
      //$('#container').append('</table>');
    });
}); 
})();
</script>
