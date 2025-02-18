<div class="sort-item" data-item-id="<?= $task->id ?>" data-position="<?= $task->position ?>">
    <div class="task-item d-flex" data-item-id="<?= $task->id ?>">
        <div class="menu_hover" data-bs-toggle="dropdown" aria-expanded="false" aria-hidden="true">
            <div class="task-item-menu">
                <i class="fa fa-ellipsis-h"></i>
            </div>
        </div>
        <ul class="dropdown-menu menu_hover_list">
            <li data-id="<?= $task->id ?>" class="btn-delete-task px-2 dropdown-item" style="font-size: 14px;"><span><i class="fa fa-trash" aria-hidden="true"></i></span> Xóa</li>
        </ul>
        <div class="stt" data-id="<?= $task->id; ?>">
            <input type="checkbox" value="" />
        </div>

        <div class="task-id border-end" style="width: 80px;" data-bs-title="<?= $task->title ?>" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="top">
            <?php
            $data['value'] = $task->id;
            $data['data_id'] = $task->id;
            $data['disabled'] = false;
            $data['showMenu'] = false;
            $data['width'] = "50px;";
            $this->load->view("admin/views/input/text", $data);
            ?>
        </div>

        <!-- Task title -->
        <div class="task-title border-end" style="width: 380px;" data-bs-title="<?= $task->title ?>" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="top">
            <?php
            $data['value'] = $task->title;
            $data['data_id'] = $task->id;
            $data['disabled'] = false;
            $data['showMenu'] = false;
            $data['width'] = "150px;";
            $this->load->view("admin/views/input/text", $data);
            ?>
        </div>

        <!-- Item metas -->
        <?php foreach ($this->Items_model->get_all_meta($task->id) as $meta) : ?>
            <?php $field = $this->Items_model->get_field_by_key($meta->key); ?>
            <div <?= $field->display == 0 ? "hidden" : "" ?> class="task-meta border-end" style="width: <?= $field->width ? $field->width : '' ?>" data-field-id="<?= $field->id ?>" data-meta-id="<?= $meta->id ?>">
                <?php
                $data['key'] = $meta->key;
                $data['value'] = $meta->value;
                $data['data_id'] = $task->id;
                $data['meta_id'] = $meta->id;
                $data['showBtnClear'] = true;
                $data['showMenu'] = false;
                $data['placeholder'] = "";
                $data['width'] = $field->width;
                $data['project'] = $project;
                $data['group'] = $project;
                $this->load->view("admin/views/input/" . $field->type_html, $data);
                ?>
            </div>
        <?php endforeach; ?>
        <!-- End Item meta -->
    </div>
</div>