<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends MY_Controller 
{
	public function __construct(){ parent::__construct(); }

	/**
	 * Return a json array containing all of the html compilation elements
	 **/
	public function compilation_elements() {
		$this->load->model("Content_model");
		$results = Content_model::getReplacementElements();
		header("Content-Type: application/json");
		echo json_encode($results);
		exit();
	}

	public function by_topic($topic_id) 
	{
		$this->requireRole("T");

		$this->load->model("Topics_model");
		$this->load->model("Content_model");
		
		// Load the objects for the view
		$this->topic = Topics_model::LoadById($topic_id);

		// load all the content for this topic
		$this->content = Content_model::ContentForTopicId($topic_id);

		// Load the view
		$this->load->view("content/by_topic");
	}

	public function post_comment($content_id) {
		$this->requireRole("S");
		$this->load->model("ContentComment_model");

		// Process the form
		if($this->input->post("comment")){

			$comment = $this->input->post("comment");
			$ccm = new ContentComment_model(null, $comment, $content_id, $this->user->user_id);
			$ccm->save();
			die("Your comment has been recieved, it should appear shortly.");

		} else {
			die("You have not submitted a comment.");
		}
	}

	public function create_video($default_topic_id = null) 
	{
		$this->requireRole("T");

		$this->load->model("Topics_model");
		$this->load->model("Content_model");
		$this->default_topic_id = $default_topic_id;
		$this->default_topic = ($default_topic_id ? Topics_model::LoadById($default_topic_id) : null);

		// Load all topics for the tagging modal
		$this->topics = Topics_model::All();

		// Check for form submissions
		if($this->input->post("new_content")) {
			$content_name = $this->input->post("content_name");
			$content_description = $this->input->post("content_description");
			$content_type = $this->input->post("content_type");
			$is_hosted_external = $this->input->post("is_hosted_external");
			$embed_html = $this->input->post("embed_html");
			if($is_hosted_external){
				$is_hosted_external = 1;
			}
			
			$content = new Content_model(null, $content_type, "", $content_name, $content_description, false, false,$is_hosted_external, $embed_html);
			$content->save();
			if(!$is_hosted_external) {
				$content->content_path = "uploads/". $content->content_id;
				$content->save();
				
				if($_FILES && $_FILES["content_mp4"]["name"]) {
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = '*';
					$config['max_size']	= '100000';
					$config["file_name"] = $content->content_id . ".mp4";
					$this->load->library('upload', $config);
	
					$success = $this->upload->do_upload("content_mp4");
					if ( !$success )
					{
						$error = array('error' => $this->upload->display_errors());
						var_dump($error);
						die();
					}
	
					$data = $this->upload->data();
					$image_path = "uploads/" . $data["file_name"];
				}
	
				if($_FILES && $_FILES["content_webm"]["name"]) {
	
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = '*';
					$config['max_size']	= '1000';
					$config["file_name"] = $content->content_id . ".webm";
					$this->load->library('upload', $config);
	
					$success = $this->upload->do_upload("content_webm");
					if ( !$success )
					{
						$error = array('error' => $this->upload->display_errors());
						var_dump($error);
						die();
					}
	
					$data = $this->upload->data();
					$image_path = "uploads/" . $data["file_name"];
				}
			}

			// Loop over the topics and join them in
			foreach($this->input->post("topics") as $topic)
				$content->addTopicById($topic);
		}

		// Render the view
		$this->content = new Content_model();
		$this->load->view("content/new_video");
	}

	public function create($default_topic_id = null) 
	{
		$this->requireRole("T");

		$this->load->model("Topics_model");
		$this->load->model("Content_model");
		$this->default_topic_id = $default_topic_id;
		$this->default_topic = ($default_topic_id ? Topics_model::LoadById($default_topic_id) : null);

		// Load all topics for the tagging modal
		$this->topics = Topics_model::All();

		// Check for form submissions
		if($this->input->post("new_content"))
		{
			$content_name = $this->input->post("content_name");
			$content_description = $this->input->post("content_description");
			$content_type = $this->input->post("content_type");
			$content_path = $this->input->post("new_content_path");
				

			$content = new Content_model(null, $content_type, $content_path, $content_name, $content_description,false, false, 0,"");
			$content->save();

			// Loop over the topics and join them in
			foreach($this->input->post("topics") as $topic)
				$content->addTopicById($topic);
		}

		// Render the view
		$this->content = new Content_model();
		$this->load->view("content/new");
	}

	public function edit($content_id)
	{
		$this->requireRole("T");
		$this->load->model("Content_model");
		$this->load->model("Topics_model");

		// Load all topics for the tagging modal
		$this->topics = Topics_model::All();

		// Load the question and its main topic
		$this->content = Content_model::LoadById($content_id);
		$this->default_topic = null;

		if($this->input->post("edit_content_id"))
		{
			$this->content->name = $this->input->post("content_name");
			$this->content->description = $this->input->post("content_description");
			$this->content->content_type = $this->input->post("content_type");
			$this->content->content_path = $this->input->post("new_content_path");
			$is_hosted_external = $this->input->post("is_hosted_external");
			if($is_hosted_external){
				$this->content->is_hosted_external = 1;
			}
			$this->content->embed_html = $this->input->post("embed_html");
				
			$this->content->save();

			$topics_wanted = $this->input->post("topics");
			$topics_had = $this->content->getTopics();

			// Loop over the topics and join them in
			$topics_to_add = array();
			$topics_to_remove = array();
			// if a topic is wanted but not had, add it to the add list
			foreach($topics_wanted as $topic_id_wanted)
			{
				$found = false;
				foreach($topics_had as $topic_had)
					if($topic_id_wanted == $topic_had->topic_id)
					{
						$found = true;
						break ;
					}
				if($found == false)
					$topics_to_add[] = $topic_id_wanted;
			}

			// if a topic is had but not wanted, remove it from the list
			foreach($topics_had as $topic_had)
			{
				$found = false;
				foreach($topics_wanted as $topic_id_wanted)
					if($topic_id_wanted == $topic_had->topic_id)
					{
						$found = true;
						break ;
					}
				if($found == false)
					$topics_to_remove[] = $topic_had->topic_id;
			}

			// add the topics we need to add, remove the ones we need to remove.
			$this->content->removeTopics($topics_to_remove);
			foreach($topics_to_add as $topic_id)
				$this->content->addTopicById($topic_id);
		}

		// Load the view
		$this->load->view("content/new");		
	}

	public function complete() {
		$content_id  = $this->input->post('content_id');
		$this->load->model("Content_model");
		$this->load->model("Badges_model");
		$this->load->model("Courses_model");
		$content = Content_model::LoadById($content_id);

		$parent = $content->getParentInfo();
		$course_id = $parent['course_id'];
		$topic_id = $parent['topic_id'];
		$parent_topic_id = $parent['parent_topic_id'];
		if($parent_topic_id == null)
			$parent_topic_id = $topic_id;

		if($content->isLastContentForTopic(null, $parent_topic_id,$content_id)){
			$badges = Badges_model::getBadesBasedOnCriteria(50, 'topic', null);
			if(count($badges) > 0){
				foreach ($badges as $p => $badge){
					$this->user->awardBadge($badge, $parent_topic_id, 'topic');
				}
			}
		}

		$content->userCompleted();
		$this->savePoints(null, 100, null, $content_id);
		
		if(!$this->user->isIntroComplete()){
			$course =  Courses_model::LoadById($course_id);
			if($course->isIntroCourse()){
				$this->user->saveIntroComplete();
			}
		}
				
	}

	public function review($content_id) {
		$this->load->model("Content_model");
		$this->load->model("Topics_model");
		$this->load->model("ContentComment_model");
		if($content_id != null){
			$content_id = decode($content_id);
		}
		 $content= Content_model::LoadById($content_id);
		 $this->content = $content;
		 	
		 $this->parent = $content->getParentInfo();
		 

		 $this->course = Courses_model::LoadById($this->parent['course_id']);
		 $this->topic = Topics_model::LoadById($this->parent['topic_id']);
		 $this->courseContents = Content_model::ContentForTopicId($this->parent['topic_id']);
		 
		 // Check if this content is availabe, if not, forward them to the next available		
		 if(!$this->content->available($this->user)) {
		 	$nextAvailable = null;
		 	foreach ($this->courseContents as $value) {
		 		if($value->available($this->user)) {
		 			$nextAvailable = $value;
		 			break;
		 		}
		 	}

		 	if($nextAvailable != null) {
		 		header("Location: " . base_url() . "content/review/" . encode($nextAvailable->content_id));
		 		die();
		 	} else {
		 		header("HTTP/1.0 403 Forbidden");
				die("This topic is not available.");	
		 	}
		 }

 		 $parent_topic_id = $this->parent['parent_topic_id'];
 		 if($parent_topic_id == null)
 		 	$parent_topic_id = $this->parent['topic_id'];
		 
		 $this->alreadyCompleted = $content->isUserCompleted(null,$content_id);
		 $this->lastContentForTopic = $content->isLastContentForTopic(null, $parent_topic_id,$content_id);

		 // This needs to be figured out from DB
		 $this->lastContentInCourse = false; 
		 $this->nextLevelInfo = $this->user->getNextLevelInfo();
		$level_up = false;
		
		//print $this->user->getNextLevelInfo()['next_level_reach_points'] < 100;
// 		if(!$this->alreadyCompleted && $this->lastContentForTopic){
// 			if($this->nextLevelInfo != null && $this->nextLevelInfo['next_level_reach_points'] > 0 && $this->nextLevelInfo['next_level_reach_points'] = 100){
// 				$level_up = true;
// 			}
// 		} else 
		if(!$this->alreadyCompleted ){
			if($this->nextLevelInfo != null && $this->nextLevelInfo['next_level_reach_points'] > 0 &&  $this->nextLevelInfo['next_level_reach_points'] <= 100){
				$level_up = true;
			}
		}
		$this->levelUp = $level_up;
		 
		 $this->comments = ContentComment_model::CommentsForContentId($content_id);

		if(!$this->topic->available($this->user)) {
			header("HTTP/1.0 403 Forbidden");
			die("This topic is not available.");
		}

		$this->load->view("student/course/view");
	}

	public function view($content_id)
	{
		// Get all of the courses to show the question bank.
		$this->load->model("Content_model");
		$content = Content_model::LoadById($content_id);

		if(!$content)
		{
			header("HTTP/1.0 404 Not Found");
			die();
		}

		// check that the user has permission to access this file.
		if(!$content->canUserView())
		{
			header("HTTP/1.0 403 Forbidden");
			die();
		}

		// Tell database the user has viewed this content.
		$content->userViewed($this->user->user_id);

		$filepath = $content->content_path;
		$is_http = false;
		if(stripos($filepath, "http") === 0) {
			$filepath = $content->content_path;
			$is_http = true;
		} else {
			$filepath = base_url() . $filepath;
		}

		if(!$content->available($this->user)) {
			header('HTTP/1.0 403 Forbidden');
			die("");
		}

		switch($content->content_type)
		{
			case "video":
				if($content->is_hosted_external == 1) {
					echo '<iframe width="100%" height="400" src="'.$content->embed_html.
						'" frameborder="0" allowfullscreen></iframe>';
				} else {
				 echo '<video id="example_video_1" class="video-js vjs-default-skin" controls style="width:100%;">
				    <source src="'.$filepath.'.mp4" type="video/mp4" />
				    <source src="'.$filepath.'.webm" type="video/webm" />
				    <source src="'.$filepath.'.ogv" type="video/ogg" />
				  </video>';
				}
				break ;
			case "inline_html":
				echo $content->content_path;
				break ;
			default:
				if($is_http) {
					$body = file_get_contents($filepath);
				}
				else {
					// read in the file.
					$body = "";
					$fh = fopen($filepath, "r");
					$body = fread($fh, filesize($filepath));
					fclose($fh);
				}

				// header the content type
				header("Content-Type: " . $content->content_type);

				// deliver the content
				echo $body;
				break ;
		}

		// Prevent the view from loading
		exit();
	}
	
	private function savePoints($user_id, $points, $event_type, $content_id){
		if($user_id == null)
			$user_id = $this->user->user_id;
		$this->load->model("UserPointAwards_model");
		$userpointsawards = new UserPointAwards_model(null, $user_id, $points , $event_type, 'Content', $content_id);
		$userpointsawards->save();
	}
}