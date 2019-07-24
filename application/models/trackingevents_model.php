<?php

class TrackingEvents_model extends CI_Model {

	public static function track($eventType, $entityType, $entityId, $otherData, $page_url, $user_id) {
		$result = &get_instance()->db->query(
			"INSERT INTO TrackingEvents (event_type, entity_type, entity_id, other_data, page_url, user_id) VALUES (?, ?, ?, ?, ?, ?)",
			array(
				$eventType,
				$entityType,
				$entityId,
				json_encode($otherData),
				$page_url,
				$user_id
			)
		);
	}
}