<?php 

class Leaderboard_model extends CI_Model {

	public static function LeaderboardForUserId($user_id, $size = 5) {
		$results = &get_instance()->db->query("SELECT user_id, @row_num := @row_num + 1 as row, points 
						FROM `View_UserPoints`, (SELECT @row_num := 0) a 
						ORDER BY points ASC, user_id ASC")->result();
		return Leaderboard_model::stackResults($results, $user_id, $size);
	}

	public static function LeaderboardForUserIdAndCourseId($user_id, $course_id, $size = 5) {
		$results = &get_instance()->db->query("SELECT user_id, @row_num := @row_num + 1 as row, points 
												FROM `View_UserPointsForCourseId`, (SELECT @row_num := 0) a 
												WHERE course_id = ?
												ORDER BY points ASC, user_id ASC", array($course_id))->result();
		return Leaderboard_model::stackResults($results, $user_id, $size);
	}

	public static function MonthlyLeaderboardForUserId($user_id, $size = 5) {
		$results = &get_instance()->db->query("SELECT user_id, @row_num := @row_num + 1 as row, points, month
						FROM `View_UserPointsByMonth`, (SELECT @row_num := 0) a 
						WHERE month = ?
						ORDER BY points ASC, user_id ASC", array(date("n")))->result();
		return Leaderboard_model::stackResults($results, $user_id, $size);
	}

	public static function MonthlyLeaderboardForUserIdAndCourseId($user_id, $course_id, $size = 5) {
		$results = &get_instance()->db->query("SELECT user_id, @row_num := @row_num + 1 as row, points, month
						FROM `View_UserPointsByMonthAndCourse`, (SELECT @row_num := 0) a 
						WHERE month = ? and course_id = ?
						ORDER BY points ASC, user_id ASC", array(date("n"), $course_id))->result();
		return Leaderboard_model::stackResults($results, $user_id, $size);
	}
	
	private static function stackResults($results, $user_id, $size) {
		$currentStack = array();

		// Now go through the entire leader board and keep a stack running
		// Once we find the users id, we should only add $size / 2 more entries
		// This will keep the leaderboard cetnered on the search user.
		$searchUserCountdown = false;
		$total = count($results);
		foreach($results as $r) {
			if($r->user_id == $user_id && $searchUserCountdown === false) {
				$searchUserCountdown = ($size / 2);
			}

			array_unshift($currentStack, $r);
			if(count($currentStack) > $size) {
				array_pop($currentStack);
			}

			if($searchUserCountdown !== false && --$searchUserCountdown <= 0) {
				break ;
			}
		}

		foreach ($currentStack as $entry) {
			$entry->row = 1 + $total - $entry->row;
			$entry->user = Users_model::LoadById($entry->user_id);
		}

		return $currentStack;
	}
}