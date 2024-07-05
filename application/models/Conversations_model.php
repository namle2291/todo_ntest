<?php

class Conversations_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get($id)
    {
        $conversation = $this->db->get_where('conversations', ['id' => $id, 'deleted_at' => null])->row_object();
        return $conversation;
    }

    public function get_by_task($task_id)
    {
        // $this->db->order_by('id', 'desc');
        $this->db->where([
            'item_id' => $task_id,
            // 'parent_id' => 0,
            'deleted_at' => null
        ]);
        $conversations = $this->db->get('conversations')->result_object();

        return $conversations;
    }

    public function get_replies($conversation_id)
    {
        $replies = $this->db->get_where('conversations', ['parent_id' => $conversation_id, 'deleted_at' => null])->result_object();

        return $replies;
    }

    public function create($conversation)
    {
        $result = $this->db->insert('conversations', $conversation);

        return $result;
    }

    public function update($id, $conversation)
    {
        $result = $this->db->update('conversations', $conversation, ['id' => $id]);

        return $result;
    }

    public function delete($id)
    {
        $result = $this->db->update('conversations', ['deleted_at' => date('Y-m-d H:i:s')], ['id' => $id]);

        $replies = $this->get_replies($id);

        foreach($replies as $reply)
        {
            $this->delete($reply->id);
        }

        return $result;
    }
}
