<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version4X;

class Notification {

    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Notifications_model');
    }

    public function sendNotification($data)
    {
        // $client = new Client(new Version4X('ws://localhost:3000'));

        // try {
        //     $client->initialize();

        //     $client->emit('new_notification', [
        //         'user_id' => $data['user_id'],
        //         'message' => $data['message']
        //     ]);

        //     $client->close();

        //     return $this->CI->Notifications_model->create($data);

        // } catch (Exception $e) {
        //     log_message('error', 'Failed to send emit: ' . $e->getMessage());
        //     echo 'Failed to create notification or send emit.' . $e->getMessage();
        // }

    }
}