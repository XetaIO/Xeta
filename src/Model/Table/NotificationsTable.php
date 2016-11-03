<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Utility\Text;

class NotificationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('notifications');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Custom finder for map the ntofications.
     *
     * @param \Cake\ORM\Query $query The query finder.
     * @param array $options The options passed in the query builder.
     *
     * @return \Cake\ORM\Query
     */
    public function findMap(Query $query, array $options)
    {
        return $query
            ->formatResults(function ($notifications) use ($options) {
                return $notifications->map(function ($notification) use ($options) {
                    $notification->data = unserialize($notification->data);

                    switch ($notification->type) {
                        case 'conversation.reply':
                            $username = $notification->data['sender']->username;
                            $conversationTitle = Text::truncate($notification->data['conversation']->title, 50, ['ellipsis' => '...', 'exact' => false]);

                            //Check if the creator of the conversation is the current user.
                            if ($notification->data['conversation']->user_id === $options['session']->read('Auth.User.id')) {
                                $notification->text = __(
                                    '<strong>{0}</strong> has replied in your conversation <strong>{1}</strong>.',
                                    h($username),
                                    h($conversationTitle)
                                );
                            } else {
                                $notification->text = __(
                                    '<strong>{0}</strong> has replied in the conversation <strong>{1}</strong>.',
                                    h($username),
                                    h($conversationTitle)
                                );
                            }

                            $notification->link = Router::url(['controller' => 'conversations', 'action' => 'go', $notification->data['conversation']->last_message_id, 'prefix' => false]);
                            break;

                        case 'bot':
                            $notification->text = __(
                                'Welcome on <strong>{0}</strong>! You can now post your first comment in the blog.',
                                \Cake\Core\Configure::read('Site.name')
                            );

                            $notification->link = Router::url(['controller' => 'blog', 'action' => 'index', 'prefix' => false]);
                            $notification->icon = $notification->data['icon'];
                            break;

                        case 'badge':
                            $notification->text = __(
                                'You have unlock the badge "{0}".',
                                $notification->data['badge']->name
                            );

                            $notification->link = Router::url(['_name' => 'users-profile', 'id' => $notification->data['user']->id, 'slug' => $notification->data['user']->username, '#' => 'badges', 'prefix' => false]);
                            break;
                    }

                    return $notification;
                });
            });
    }
}
