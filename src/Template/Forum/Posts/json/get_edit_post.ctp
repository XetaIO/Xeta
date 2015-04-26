<?php
if ($json['error'] === false):
    $json['html'] = "<div class=\"editingPost\" id=\"editingPost-{$post->id}\">
        {$this->Form->create($post, [
            'url' => ['action' => 'edit']
        ])}
            <div class=\"form-group\">
                {$this->Form->input(
                    'message', [
                        'label' => false,
                        'class' => 'form-control postBox',
                        'id' => 'postBox-' . $post->id
                    ]
                )}
            </div>
            <div class=\"form-group\">
                {$this->Form->button(__('Update Post'), ['type' => 'submit', 'class' => 'btn btn-sm btn-primary'])}
                {$this->Html->link(__('Cancel'), '#', ['data-id' => $post->id, 'class' => 'btn btn-sm btn-danger', 'id' => 'cancelEditPost'])}
            </div>
        {$this->Form->end()}
        <script type=\"text/javascript\">
        $(function() {
            $(\"#cancelEditPost\").click(function () {
                var postId = $(this).attr(\"data-id\");
                $(\"#post-\" + postId + \" .message\").fadeIn();
                $(\"#editingPost-\" + postId).remove();

                return false;
            });
        });
        </script>
    </div>";
endif;

echo json_encode($json);
?>
