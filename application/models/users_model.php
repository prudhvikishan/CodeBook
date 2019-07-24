<?php
// TODO: Save/Update Address
// TODO: Add/Remove Roles

class Users_model extends CI_Model {

	public $user_id, $email, $firstname, $lastname, $password, $expiration_date, $profile_pic, $is_premium;

	/**
	 * Create a new User.
	 **/
    function __construct($user_id = null, $email = null, $firstname = null, $lastname = null, $password = null, $expiration_date = null, $profile_pic = null, $phone = null, $is_premium = false)
    {
        parent::__construct();
        $this->user_id          = $user_id;
        $this->email            = $email;
        $this->firstname        = $firstname;
        $this->lastname         = $lastname;
        $this->password         = $password;
        $this->expiration_date  = $expiration_date;
        $this->profile_pic      = $profile_pic;
        $this->phone            = $phone;
        $this->is_premium       = $is_premium;
    }

    function __autoload() { }

    /**
     * Return any announcements that need to be shown to the user.
     **/
    public function getUnseenAnnouncements() {
      return $this->db->query("SELECT * FROM View_UserAnnouncementsToBeShown WHERE user_id = ?", array($this->user_id))->result();
    }

    /**
     * Return true if the user has dismissed a pop up for this notification already
     **/
    public function hasSeenAnnouncement($announcement_id) {
      return count($this->db->query("SELECT * FROM UserAnnouncementView WHERE user_id = ? AND announcement_id = ?", array($this->user_id, $announcement_id))->result()) != 0;
    }

    /**
     * Mark an announcement as seen.
     **/
    public function markAnnouncementAsSeen($announcement_id) {
      if(!$this->hasSeenAnnouncement($announcement_id)) {
        $this->db->query("INSERT INTO UserAnnouncementView (user_id, announcement_id) VALUES (?, ?);", array($this->user_id, $announcement_id));
        return true;
      } 
      return false;
    }

    /**
     * Return the number of gold coins for this user.
     **/
    public function getGoldCoinCount() {
      $result = $this->db->query(
        "SELECT coins FROM View_UserGoldCoins WHERE user_id = ?",
        array($this->user_id)
      )->result();
      $result = $result[0];
      return intval($result->coins);
    }

    /**
     * Attempt to redeem gold coins for a specific reward
     * Will return false if the user doesn't have enough coins, otherwise returns true
     **/
    public function redeemGoldCoinsForReward($reward) {
      $this->load->model("Rewards_model");
      $reward = Rewards_model::LoadById($reward);
      if(!$reward) {
        throw("Reward not found.");
      }
      return $this->redeemGoldCoins($reward->cost, "Coin Redemption", "Reward", $reward->reward_id);
    }

    /**
     * Attempt to redeem gold coins
     * NOTE: Always pass the redemption amount as a positive integer.
     * Will return false if the user doesn't have enough coins, otherwise returns true
     **/
    public function redeemGoldCoins($amount, $explanation = "Coin Redemption", $entity_type = "", $entity_id = null) {
      if($this->getGoldCoinCount() < intval($amount)) {
        return false;
      }

      $this->awardGoldCoins(intval($amount) * -1, $explanation, true, $entity_type, $entity_id);
      return true;
    }

    /**
     * Award gold coins to a user
     * NOTE: Always pass the reward amount as a positive integer.
     **/
    public function awardGoldCoins($amount, $explanation, $allowNegative = false, $entity_type = "", $entity_id = null) {
      if(intval($amount) < 0 && $allowNegative == false) {
        throw "Negative Awards not Allowed.";
      }

      $this->db->query("INSERT INTO GoldCoinTransactions (user_id, transaction_amount, explanation, entity_type, entity_id) VALUES (?, ?, ?, ?, ?)", array(
        $this->user_id,
        intval($amount),
        $explanation,
        $entity_type,
        $entity_id
      ));
    }

    /**
     * Return the last N records from tthis users gold coin transaction history.
     **/
    public function goldCoinHistory($n = 5) {
      return $this->db->query(
        "SELECT * FROM GoldCoinTransactions WHERE user_id = ? ORDER BY transaction_date DESC LIMIT ?",
        array($this->user_id, $n)
      )->result();
    }

    /**
     * Return the last N interactions the user has had
     **/
    public function getRecentInteractions($n = 1) {
      $results = $this->db->query(
        "SELECT * FROM (
            SELECT uci.user_id, uci.interaction_type as type, uci.`timestamp` as `timestamp`, c.name FROM `UserContentInteraction` uci
            JOIN `Content` c 
            ON uci.content_id = c.content_id
                  WHERE user_id = ?
          ) a
          UNION 
          (
            SELECT uea.user_id, 'Exam Attempt' as type, uea.`finished` as `timestamp`, t.name 
            FROM `UserExamAttempt` uea 
            JOIN `ExamTopics` et
            ON uea.exam_id = et.exam_id
            JOIN Topics t 
            ON et.topic_id = t.topic_id
                  WHERE user_id = ?
          ) 
          UNION 
          (
            SELECT gt.user_id, 'Gold Coin' as type, gt.`transaction_date` as `timestamp`, CONCAT( CONCAT( CONCAT('[', gt.transaction_amount), ']  '), gt.explanation) COLLATE utf8_unicode_ci as name 
            FROM `GoldCoinTransactions` gt 
            WHERE user_id = ?
          )
          ORDER BY `timestamp` DESC
          LIMIT ?",
          array($this->user_id, $this->user_id, $this->user_id, $n)
      );

      return $results->result();
    }

    /**
     * Return true ifthe user can access premium content
     **/
    public function isPremium(){
      return $this->is_premium;
    }

    /**
     * Save the current user.
     **/
    public function save()
    {
    	// If theres no user_id, create a new one.
    	if($this->user_id == null)
    	{
    		$this->db->insert("Users", array(
				"email" => $this->email,
				"firstname" => $this->firstname,
				"lastname" => $this->lastname,
				"password" => Users_model::EncryptPassword($this->password),
				"expiration_date" => $this->expiration_date,
				"profile_pic" => $this->profile_pic,
        "phone" => $this->phone,
        "is_premium" => $this->is_premium ? 1 : 0
    		));
    		$this->user_id = $this->db->insert_id();
    	}	
    	// Otherwise update the existing one.
    	else
    	{
    		// Note when updating, we check if a password was set or not and add that to the update 
    		$update_data = array(
    			"email" => $this->email,
  				"firstname" => $this->firstname,
  				"lastname" => $this->lastname,
    			"expiration_date" => $this->expiration_date,
    			"profile_pic" => $this->profile_pic,
          "phone" => $this->phone,
          "is_premium" => $this->is_premium ? 1 : 0
    		);
    		if($this->password != null) $update_data["password"] = Users_model::EncryptPassword($this->password);
    		$this->db->where("user_id", $this->user_id);
    		$this->db->update("Users", $update_data);
    	}
    }

    /**
     * Load a user by id.
     **/
    public static function LoadById($user_id)
    {
    	$result = &get_instance()->db->get_where("Users", array("user_id" => $user_id));
    	$result = $result->result();
    	return count($result) != 0 ? Users_model::LoadWithData($result[0]) : null;
    }

   	/**
   	 * Load a user with a username/password combo, return null if theres no such user.
   	 **/
   	public function LoadWithCredentials($username, $password)
   	{
   		$result = &get_instance()->db->get_where("Users", array("email" => $username, "password" => Users_model::EncryptPassword($password)));
    	$result = $result->result();
    	return count($result) != 0 ? Users_model::LoadWithData($result[0]) : null;
   	}
   	
   	/**
   	* Load a user with a username , return null if theres no such user.
   	**/
   	public function LoadWithUsername($username)
   	{
   		$result = &get_instance()->db->get_where("Users", array("email" => $username));
   		$result = $result->result();
   		return count($result) != 0 ? Users_model::LoadWithData($result[0]) : null;
   	}

    /**
     * Load a user with an object.
     **/
   	public static function LoadWithData($row)
   	{
   		return new Users_model(
   			$row->user_id,
   			$row->email,
   			$row->firstname,
   			$row->lastname,
   			null, // never load the password...
   			$row->expiration_date,
   			$row->profile_pic,
        $row->phone,
        $row->is_premium == 1
   		);
   	}

    /**
     * Return all roles this user has
     **/
    public function getRoles()
    {
      $ret = array();
      foreach($this->db->get_where("UserRoles", array("user_id" => $this->user_id))->result() as $r)
        $ret[] = $r->type;
      return $ret;
    }
    
    /**
    * Return all courses this user has
    **/
    public function getCourses()
    {
    	if($this->user_id == null) return null;
   		$user_id = $this->user_id;
   		 
   		$this->db->select('*');
   		$this->db->from ('Courses');
   		$this->db->join('UserCourses', 'UserCourses.course_id = Courses.course_id', 'inner');
   		$this->db->where('UserCourses.user_id',$user_id);
   		$query  = $this->db->get();
   		$courses_ar=array();

   		if ($query->num_rows() > 0)
   		{
   			$this->load->model("Courses_model");
   			foreach ($query->result() as $row)
   			{
   				$courses_ar[]=Courses_model::LoadWithData($row);
   			}
   		}
   		return $courses_ar;
   	}

    /** 
     * REturn a "home" link for this user (based on type)
     **/
    public function user_home()
    {
      // redirect them to the dashboard.
      if($this->hasRole("S"))
        return base_url() . "student";
      else if($this->hasRole("T"))
        return base_url() . "instructor";
      else
        return null;
    }

    /**
     * Returns true if a user has the specified role.
     **/
    public function hasRole($role)
    {
      return in_array($role, $this->getRoles());
    }

    /**
     * Store this object as the current user in the session.
     **/
    public function saveInSession() { $this->session->set_userdata('akshara_user', $this->user_id); }

    /**
     * Remove any student data in the sessions
     **/
    public static function ClearSession() 
    { 
      $r =  &get_instance()->session->unset_userdata('akshara_user'); 
      return $r;
    }

   	/**
   	 * Encrypt a password
   	 **/
   	public static function EncryptPassword($password) { return hash("sha512", $password); }

    /**
     * Award a badge to this user.
     **/
    public function awardBadge($badge, $entity_id, $entity_type) 
    {
      return $this->db->query("INSERT INTO UserBadgeAward (user_id, badge_id, entity_id, entity_type) VALUES (?, ?, ?, ?)", array($this->user_id, $badge->badge_id, $entity_id, $entity_type));
    }
    
    /**
     * Return all badges awarded to this user.
     **/
    public function getBadgesAwarded() 
    {
      $this->load->model("Badges_model");
      $ret = array();
      $result = $this->query("SELECT * FROM UserBadgeAward WHERE user_id = ?", array($this->user_id))->result();
      foreach($result as $r) {
        $ret[] = array( "badge" => Badges_model::LoadById($r->badge_id), "date_awarded" => $r->date_awarded );
      }
      return $ret;
    }

    /**
     * Return how many points this user has earned.
     **/
    public function getTotalPoints() {
      $result = $this->db->query("SELECT IFNULL(points, 0) as points FROM `View_UserPoints` WHERE user_id = ?", array($this->user_id));
      foreach($result->result() as $r) {
        return $r->points;
      }
    }

    /**
     * Return how many points this user has earned in a certain course id
     **/
    public function getTotalPointsByCourse($course_id) {
      $result = $this->db->query("SELECT IFNULL(points, 0) as points FROM `View_UserPointsForCourseId` WHERE user_id = ? AND course_id = ?", array($this->user_id, $course_id));
      foreach($result->result() as $r) {
        return $r->points;
      }
    }

    /**
     * Return how many points the user has earned this month.
     **/
    public function getTotalPointsThisMonth() {
      $result = $this->db->query("SELECT IFNULL(points, 0) as points FROM `View_UserPointsByMonth` WHERE user_id = ? AND month = ?", array($this->user_id, date("n")));
      foreach($result->result() as $r) {
        return $r->points;
      }
    }

    /** 
     * Return the users current level
     **/
    public function getLevel() {
      $result = $this->db->query("SELECT IFNULL(level, 0) as level FROM `View_UserLevel` WHERE user_id = ?", array($this->user_id));
      foreach($result->result() as $r) {
        return $r->level;
      }
    }
    
    /**
    * Return the users current level
    **/
    public function getNextLevelInfo() {
    	$result = $this->db->query("select m.min_points as next_level_points, m.min_points- ? as next_level_reach_points, m.rank as next_level from (select r.min_points, @row:=@row+1 rank 
 	 from (SELECT * from LevelPointCutoff ) r join (SELECT @row:=0) pos) m where m.rank = ?", array($this->getTotalPoints(), $this->getLevel()+1));
    	$info = array();
    	foreach($result->result() as $r) {
  			$info['next_level_points'] = $r->next_level_points;
  			$info['next_level_reach_points'] = $r->next_level_reach_points;
  			$info['next_level'] = $r->next_level;
    	}
    	return $info;
    }
    
    /**
     * Return a nice looking name ofr the user.
     **/
    public function getName(){
      return $this->firstname . " " . $this->lastname;
    }

    /**
    * Save password status for user.
    **/
	public  function updatePasswordStatus($password_status){
   		$update_data = array(
   						"is_password_reset" => $password_status
   		);
   		$this->db->where("user_id", $this->user_id);
   		$this->db->update("Users", $update_data);
   	}
   	

    /**
     * Return the newsfeed for this user.
     **/
    public function getNewsfeed($limit = 5, $user_id = null) {
      $this->load->model("Exams_model");

      // Currently just get the recent badge awards
      $results = $this->db->query(
              "SELECT * 
                FROM `UserBadgeAward` uba
                JOIN Badges b
                ON uba.badge_id = b.badge_id
                JOIN Users u
                ON uba.user_id = u.user_id
                JOIN SchoolUsers su
				ON su.user_id = u.user_id 
				JOIN Schools s
				ON s.school_id = su.school_id
                where u.status = 'A' and b.badge_name !='No' and b.badge_name !='No Badge' and s.name != 'codebook' 
                ORDER BY uba.date_awarded DESC
                LIMIT ?", array($limit)
              )->result();

      $ret = array();
      foreach ($results as $row) {
        $topic_message = "";
        if($row->entity_type == "topic") {
          $topic = Topics_model::LoadById($row->entity_id); 
          $topic_message = " in <em>" . $topic->name . "</em>";
        } else if($row->entity_type == "exam") {
          $exam = Exams_model::LoadById($row->entity_id);
          //$topic_message = " in <em>" . $exam->getTopic() . "</em>";
        }

        $ret[] = array("user_id" => $row->user_id, "message" => "has earned the <strong>" . $row->badge_name . "</strong> badge" . $topic_message);
      }

      return $ret;
    }

    /**
     * Return recently awarded badges
     **/
    public function getRecentBadges($limit = 4) {
      $results = $this->db->query(
              "SELECT * 
                FROM `UserBadgeAward` uba
                JOIN Badges b
                ON uba.badge_id = b.badge_id
                AND uba.user_id = ?
                ORDER BY uba.date_awarded DESC
                LIMIT ?", array($this->user_id, $limit)
              )->result(); 

      $ret = array();
      foreach ($results as $row) {
        // if($row->entity_type == "exam") {
        //   $exam = Exams_model::LoadById($row->entity_id);
        //   $ret[] = array("image" => $row->icon_path, "message" => $row->badge_name . " in " . $exam->getTopic());
        // } else {
          $ret[] = array("image" => $row->icon_path, "message" => $row->badge_name);
        // }
      }

      return $ret;
    }

    /**
     * Return counts for each type of badge
     **/
    public function getBadgeCounts() {
      $this->load->model("Badges_model");
      $results = $this->db->query(
                  "SELECT b.badge_id, count(uba.badge_id) as total
                  FROM `UserBadgeAward` uba
                  RIGHT JOIN `Badges` b
                  ON uba.badge_id = b.badge_id
                  AND (uba.user_id = ? OR uba.user_id IS NULL)
                  GROUP BY b.badge_id
                  ORDER BY b.badge_id ASC
                     ", array($this->user_id)
      )->result();
      
      $ret = array();
      foreach ($results as $value) {
        $ret[] = array("badge" => Badges_model::LoadById($value->badge_id), "count" => $value->total);
      }
      return $ret;
    }

    /**
     * Return the badges earned by topic
     **/
    public function badgesByTopic() {
      $this->load->model("Badges_model");
      $this->load->model("Topics_model");
      $badgeNames = array( "", "Apprentice Exam", "Senior Exam", "Master Exam" );
      $res = array();

      // Get the exam badges by topic
      $results = $this->db->query("SELECT * 
                                    FROM `UserBadgeAward` uba 
                                    JOIN `ExamTopics` et 
                                    ON uba.entity_id = et.exam_id
                                    AND uba.entity_type = 'exam'
                                    AND uba.user_id = ?
                                    JOIN Exams e 
                                    ON e.exam_id = et.exam_id", array($this->user_id))->result();
      foreach ($results as $value) {
        if(!array_key_exists($value->topic_id, $res)) {
          $res[$value->topic_id] = array();
        }
        $b = Badges_model::LoadById($value->badge_id);
        $b->label = $badgeNames[$value->exam_type];
        $res[$value->topic_id][] = $b;
      }

      // Get the topic badges
      $results = $this->db->query("SELECT * 
                                    FROM `UserBadgeAward` uba 
                                    WHERE uba.entity_type = 'topic'
                                    AND uba.user_id = ?", array($this->user_id))->result();
      foreach ($results as $value) {
        if(!array_key_exists($value->entity_id, $res)) {
          $res[$value->entity_id] = array();
        }
        $b = Badges_model::LoadById($value->badge_id);
        $b->label = "100% Completion";
        $res[$value->entity_id][] = $b;
      }

      // $ret = array();
      // foreach ($res as $topic => $badges) {
      //   $topic = Topics_model::LoadById($topic);
      //   $ret[$topic->name] = $badges;        
      // }

      return $res;
    }
    
    /**
    * Return all awarded badges
    **/
    public function getAllBadges() {
    	$results = $this->db->query(
                  "SELECT * 
                    FROM `UserBadgeAward` uba
                    JOIN Badges b
                    ON uba.badge_id = b.badge_id
                    AND uba.user_id = ?
                    ORDER BY uba.date_awarded DESC
                     ", array($this->user_id)
    	)->result();
    
    	$ret = array();
    	foreach ($results as $row) {
    		// if($row->entity_type == "exam") {
    		// 	$exam = Exams_model::LoadById($row->entity_id);
    		// 	$ret[] = array("image" => $row->icon_path, "message" => $row->badge_name . " in " . $exam->getTopic());
    		// } else {
    			$ret[] = array("image" => $row->icon_path, "message" => $row->badge_name);
    		// }
    	}
    
    	return $ret;
    }
    
    /**
     * Return overall rank
     **/
    public function getOverAllRank() {
    	$result = $this->db->query(
                      "select IFNULL(rank, 1) as rank from (
						SELECT user_id, points, @curRank := @curRank + 1 AS rank
						FROM  View_UserPoints a, (SELECT @curRank := 0) r
						ORDER BY  points desc) q where user_id = ?
						", array($this->user_id));    
    	foreach($result->result() as $r) {
    		return $r->rank;
    	}
      }
    
    /**
     * get course rank by course id
     */
    public function getCourseRankById($course_id){
    	$result = $this->db->query("select IFNULL(rank, 1) as rank from (SELECT a.user_id, a.course_id, a.points , @curRank := @curRank + 1 AS rank
				FROM `View_UserPointsForCourseId` a , UserCourses b , (SELECT @curRank := 0) r
				where a.user_id = b.user_id and
				a.course_id = b.course_id and 
				a.course_id = ? ) m where user_id = ?", array($course_id, $this->user_id));
    	foreach($result->result() as $r) {
    		return $r->rank;
    	}
    }
    
    /**
     * Saves user role.
     */
    public function saveRoles($role){
    		return $this->db->query("INSERT INTO UserRoles (user_id, type) VALUES (?, ?)", 
    		array($this->user_id, $role));
    }
    
    /**
    * Saves user to the school.
    */
    public function saveSchoolSection($school_id, $school_section_id){
    	return $this->db->query("INSERT INTO SchoolUsers (user_id, school_id, school_section_id) VALUES (?, ?, ?)",
    	array($this->user_id, $school_id, $school_section_id));
    }
    
    /**
    * Saves user to the school.
    */
    public function saveCourses($class_id){
    	
    	$this->db->select('course_id');
    	$this->db->from ('ClassCourses');
    	$this->db->where('ClassCourses.class_id',$class_id);
    	$query  = $this->db->get();
    	foreach ($query->result() as $row)
    	{
			$this->db->query("INSERT INTO UserCourses (user_id, course_id) VALUES (?, ?)",
    			array($this->user_id, $row->course_id));    	
    	}
    }

    /**
     * Get the exam attempts for a user.
     **/
    public function getExamAttempts($user_id) {
      return $this->db->query(
        "SELECT uea.score, t.name, e.exam_type, uea.finished, uea.exam_id
          FROM UserExamAttempt uea 
          JOIN ExamTopics et 
          ON uea.exam_id = et.exam_id
          AND uea.user_id = ?
          JOIN Exams e 
          ON e.exam_id = et.exam_id
          JOIN Topics t 
          ON t.topic_id = et.topic_id",
          array(
            $user_id
          )
      )->result();
    }
    
    /**
    * Return the users school 
    **/
    public function getSchoolId() {
    	$result = $this->db->query("SELECT school_id  FROM `SchoolUsers` WHERE user_id = ?", array($this->user_id));
    	foreach($result->result() as $r) {
    		return $r->school_id;
    	}
    }
    
    
    /**
    * Return the user section
    **/
    public function getSection() {
    	$result = $this->db->query("SELECT b.section  FROM `SchoolUsers` a, SchoolSections b WHERE a.school_section_id = b.school_section_id and a.user_id = ?", array($this->user_id));
    	foreach($result->result() as $r) {
    		return $r->section;
    	}
    }
    
    /**
    * Save password status for user.
    **/
    public  function saveUserAccountStatus($is_account_verified,$token,$verified_on){
    	$update_data = array(
       						"is_account_verified" => $is_account_verified,
       						"token" => $token,
       						"verified_on" => $verified_on
    	);
    	$this->db->where("user_id", $this->user_id);
    	$this->db->update("Users", $update_data);
    }
    
    public function isAccountVerified(){
    	$result = $this->db->query("SELECT is_account_verified  FROM `Users` WHERE user_id = ?", array($this->user_id));
    	foreach($result->result() as $r) {
    		if($r->is_account_verified == 1){
    			return true;
    		}
    	}
    	return false;
    }
    
    public function getAccountVerificationToken(){
    	$result = $this->db->query("SELECT token  FROM `Users` WHERE user_id = ?", array($this->user_id));
    	foreach($result->result() as $r) {
    		return $r->token;
    	}
    }
    
    public function getLeaderboadrdData(){
    	$rank = $this->getRank();
    	$result = $this->db->query("select rank, u.user_id, u.firstname, u.lastname, q.level, p.points from (
			SELECT rank, user_id,points FROM (SELECT @rank:=@rank+1 AS rank, points, user_id FROM
            View_UserPoints, (SELECT @rank := 0) r ORDER BY points DESC ) t ) p , View_UserLevel q, Users u where p.user_id = q.user_id and
	        q.user_id = u.user_id and p.rank between ? and ? order by rank", array($rank-3,$rank+3));
    	return $result->result();
    }
    
    private function getRank(){
    	$result = $this->db->query("SELECT rank FROM (SELECT @rank:=@rank+1 AS rank, points, user_id FROM View_UserPoints, (SELECT @rank := 0) r
     		ORDER BY points DESC ) t where user_id = ?", array($this->user_id));
    	foreach($result->result() as $r) {
    		return $r->rank;
    	}
    }
    
    public function isIntroComplete(){
    	$result = $this->db->query("SELECT is_intro_complete  FROM `Users` WHERE user_id = ?", array($this->user_id));
    	foreach($result->result() as $r) {
    		if($r->is_intro_complete == 1){
    			return true;
    		}
    	}
    	return false;
    }
    
    /**
    * Save password status for user.
    **/
    public  function saveIntroComplete(){
    	$update_data = array(
       						"is_intro_complete" => 1
    	);
    	$this->db->where("user_id", $this->user_id);
    	$this->db->update("Users", $update_data);
    }
    
    
}
?>
