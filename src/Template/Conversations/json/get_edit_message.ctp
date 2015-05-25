<?php
if ($json['error'] === false):
    $json['html'] = "<div class=\"editingPost\" id=\"editingMessage-{$message->id}\">
        {$this->Form->create($message, [
            'url' => ['action' => 'messageEdit']
        ])}
            <div class=\"form-group\">
                {$this->Form->input(
                    'message', [
                        'label' => false,
                        'class' => 'form-control messageBox',
                        'id' => 'messageBox-' . $message->id
                    ]
                )}
            </div>
            <div class=\"form-group\">
                {$this->Form->button(__d('conversations', 'Update Message'), ['type' => 'submit', 'class' => 'btn btn-sm btn-primary'])}
                {$this->Html->link(__d('conversations', 'Cancel'), '#', ['data-id' => $message->id, 'class' => 'btn btn-sm btn-danger', 'id' => 'cancelEditMessage'])}
            </div>
        {$this->Form->end()}
        <script type=\"text/javascript\">
        $(function() {
            $(\"#cancelEditMessage\").click(function () {
                var messageId = $(this).attr(\"data-id\");
                $(\"#message-\" + messageId + \" .message\").fadeIn();
                $(\"#editingMessage-\" + messageId).remove();

                return false;
            });
        });
        </script>
    </div>";
endif;

echo json_encode($json);
?>
