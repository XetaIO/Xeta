<?php
if ($json['error'] === false):
    $json['html'] = "<div class=\"editingComment\" id=\"editingComment-{$comment->id}\">
        {$this->Form->create($comment, [
            'url' => ['action' => 'editComment']
        ])}
        <div class=\"form-group\">
            {$this->Form->input(
                'content', [
                    'label' => false,
                    'class' => 'form-control commentBox',
                    'id' => 'commentBox-' . $comment->id
                ]
            )}
        </div>
        <div class=\"form-group\">
            {$this->Form->button(__('{0} Save', '<i class="fa fa-floppy-o"></i>'), ['type' => 'submit', 'class' => 'btn btn-primary-outline', 'escape' => false])}
            {$this->Html->link(__('{0} Cancel', '<i class="fa fa-remove"></i>'), '#', ['data-id' => $comment->id, 'class' => 'btn btn-danger-outline', 'id' => 'cancelEditComment', 'escape' => false])}
        </div>
        {$this->Form->end()}

        <script type=\"text/javascript\">
            $(function() {
                $(\"#cancelEditComment\").click(function () {
                    var commentId = $(this).attr(\"data-id\");
                    $(\"#comment-\" + commentId + \" .content\").fadeIn();
                    $(\"#editingComment-\" + commentId).remove();

                    return false;
                });
            });
        </script>
    </div>";
endif;

echo json_encode($json);
?>
