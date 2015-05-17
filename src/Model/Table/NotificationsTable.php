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
                        case 'thread.reply':
                            $username = $notification->data['sender']->username;
                            $threadTitle = Text::truncate($notification->data['thread']->title, 50, ['ellipsis' => '...', 'exact' => false]);

                            //Check if the creator of the thread is the current user.
                            if ($notification->data['thread']->user_id === $options['session']->read('Auth.User.id')) {
                                $notification->text = __(
                                    '<strong>{0}</strong> has replied to your thread <strong>{1}</strong>.',
                                    h($username),
                                    h($threadTitle)
                                );
                            } else {
                                $notification->text = __(
                                    '<strong>{0}</strong> has replied to the thread <strong>{1}</strong>.',
                                    h($username),
                                    h($threadTitle)
                                );
                            }

                            $notification->link = Router::url(['controller' => 'posts', 'action' => 'go', $notification->data['thread']->last_post_id, 'prefix' => 'forum']);
                            break;

                        case 'thread.lock':
                            $notification->text = __(
                                '<strong>{0}</strong> has locked your thread <strong>{1}</strong>.',
                                h($notification->data['sender']->username),
                                h(Text::truncate($notification->data['thread']->title, 50, ['ellipsis' => '...', 'exact' => false]))
                            );

                            $notification->link = Router::url([
                                '_name' => 'forum-threads',
                                'id' => $notification->data['thread']->id,
                                'slug' => $notification->data['thread']->title,
                                'prefix' => 'forum'
                            ]);
                            break;

                        case 'post.like':
                            $notification->text = __(
                                '<strong>{0}</strong> has liked your post in <strong>{1}</strong>.',
                                h($notification->data['sender']->username),
                                h(Text::truncate($notification->data['post']->forum_thread->title, 50, ['ellipsis' => '...', 'exact' => false]))
                            );

                            $notification->link = Router::url(['controller' => 'posts', 'action' => 'go', $notification->data['post']->id, 'prefix' => 'forum']);
                            break;

                        case 'bot':
                            $notification->text = __(
                                'Welcome on <strong>{0}</strong>! You can now post your first message in the Forum.',
                                \Cake\Core\Configure::read('Site.name')
                            );

                            $notification->link = Router::url(['controller' => 'forum', 'action' => 'index', 'prefix' => 'forum']);
                            $notification->icon = $notification->data['icon'];
                            break;

                        case 'badge':
                            $notification->text = __(
                                'You have unlock the badge "{0}".',
                                $notification->data['badge']->name
                            );

                            $notification->link = Router::url(['_name' => 'users-profile', 'id' => $notification->data['user']->id, 'slug' => $notification->data['user']->slug, '#' => 'badges', 'prefix' => false]);
                            break;
                    }

                    return $notification;
                });
            });
    }
}
