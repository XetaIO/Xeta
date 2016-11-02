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
                {$this->Form->button(__d('conversations', '{0} Save', '<i class="fa fa-floppy-o"></i>'), ['type' => 'submit', 'class' => 'btn btn-primary-outline', 'escape' => false])}
                {$this->Html->link(__d('conversations', '{0} Cancel', '<i class="fa fa-remove"></i>'), '#', ['data-id' => $message->id, 'class' => 'btn btn-danger-outline', 'id' => 'cancelEditMessage', 'escape' => false])}
            </div>
        {$this->Form->end()}
        <script type=\"text/javascript\">
        $(function() {
            $(\"#cancelEditMessage\").click(function () {
                var messageId = $(this).attr(\"data-id\");
                $(\"#message-\" + messageId + \" .text\").fadeIn();
                $(\"#editingMessage-\" + messageId).remove();

                return false;
            });
        });
        </script>
    </div>";
endif;

echo json_encode($json);
?>
