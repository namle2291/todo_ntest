<?php

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version4X;

class Notification extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Notifications_model');
        $this->load->helper('url');
        $this->load->library('session');

        if (!$this->authenticate->is_authenticated()) {
            redirect('/login');
        }
    }

    public function sendNotification($data)
    {
        $notification = [
            'message' => $data['message'],
            'user_id' => $data['user_id'],
        ];

        $result = $this->Notifications_model->create($notification);

        if ($result) {
            // Gửi emit tới WebSocket server
            $client = new Client(new Version4X('http://localhost:3000'));

            try {
                $client->initialize();

                $client->emit('new_notification', [
                    'user_id' => $notification['user_id'],
                    'message' => $notification['message']
                ]);

                $client->close();

                echo 'Notification created and emitted successfully.';
            } catch (Exception $e) {
                log_message('error', 'Failed to send emit: ' . $e->getMessage());
                echo 'Failed to create notification or send emit.' . $e->getMessage();
            }

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to insert notification!'));
        }
    }

    public function fetchUnreadNotifications($user_id)
    {
        return $this->Notifications_model->get_unread_notifications($user_id);
    }

    public function fetchNotifications($user_id)
    {
        return $this->Notifications_model->get_all_notifications($user_id);
    }

    public function readNotification($id)
    {
        $user_id = $this->sesstion->userdata('user_id');

        return $this->Notifications_model->read($id, $user_id);
    }
}
