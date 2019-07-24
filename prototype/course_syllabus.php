

	<div id="container" class="container">
	</div>
<script>
(function() {
 $.getJSON('data/maths_syllabus_json.txt', function(data) {
var topics = data.syllabus.subjects.subject.topics;
$.each( topics.topic, function( i, topic ) {
		var topicName = topic.name;
		$('#container').append('<table id="topic'+i+'" class="table table-striped padtop"><tr ><th style="width:70%">' + topicName + '</th><th class="center" style="width:10%">'+
		'Attempts</th><th class="center" style="width:10%">Score</th><th class="center" style="width:10%">Progress</th></tr>');
             
		var subtopics = topic.subtopics;
      $.each( subtopics.subtopic, function( j, subtopic ) {
        $('#topic'+i).append('<tr><td style="width:70%"><a href="topic.php">'+subtopic.name+'</a></td><td class="center" style="width:10%">'+
        '1</td><td class="center" style="width:10%">78</td><td class="center" style="width:10%">Proficient</td></tr>');
    });
      //$('#container').append('</table>');
    });
}); 
})();
</script>
