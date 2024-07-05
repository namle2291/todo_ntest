<?php

class Notifications_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_notification($id, $user_id)
    {
        return $this->db->get_where('notifications', ['id' => $id, 'user_id' => $user_id])->row_object();
    }

    public function get_all_notifications($user_id)
    {
        $notifications = $this->db->get_where('notifications', ['user_id' => $user_id])->result_object();

        return $notifications;
    }

    public function get_unread_notifications($user_id)
    {
        $unread_notifications = $this->db->get_where('notifications', ['user_id' => $user_id, 'status' => true])->result_object();

        return $unread_notifications;
    }

    public function get_read_notifications($user_id)
    {
        $read_notifications = $this->db->get_where('notifications', ['user_id' => $user_id, 'status' => false])->result_object();

        return $read_notifications;
    }

    public function create($data)
    {

        $notification = [
            'message' => $data['message'],
            'user_id' => $data['user_id'],
        ];

        $result = $this->db->insert('notifications', $notification);

        return $result;
    }

    public function read($id, $user_id)
    {
        $notification = $this->get_notification($id, $user_id);

        if (!empty($notification)) {
            $notification->status = false;
            return $this->update($notification->id, $notification);
        }
        return false;
    }

    public function update($id, $notification)
    {
        return $this->db->update('notifications', $notification, ['id' => $id, 'user_id' => $this->user_id]);
    }
}
