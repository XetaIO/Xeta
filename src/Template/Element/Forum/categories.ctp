<div class="panel panel-forum">
    <div class="panel-heading">
        <div class="categoryTitle">
            <?= $this->Html->link($category->title, ['_name' => 'forum-categories', 'id' => $category->id, 'slug' => $category->title]) ?>
        </div>
    </div>
    <div class="panel-inner">
        <table class="table tableCategories table-striped table-primary table-hover">
            <thead>
                <tr>
                    <th class="categoryTitle">
                        <?= __("Title") ?>
                    </th>
                    <th class="statisticsTitle hidden-xs">
                        <?= __("Statistics") ?>
                    </th>
                    <th class="lastPostTitle">
                        <?= __("Last post") ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($forums as $forum): ?>
                    <?php
                    $threadCount = $forum->thread_count;
                    $lastPost = $forum->last_post;
                    ?>
                    <tr>
                        <td class="forumInfo">
                            <span class="forumIcon">
                                <i class="fa fa-comments-o fa-2x"></i>
                            </span>
                            <div class="forumText">
                                <div class="forumTitle">
                                    <?= $this->Html->link($forum->title, ['_name' => 'forum-categories', 'id' => $forum->id, 'slug' => $forum->title]) ?>
                                </div>
                                <span class="forumDescription">
                                    <?= h($forum->description) ?>
                                </span>
                                <div class="btn-group">
                                    <?php if($forum->child_count >= 1): ?>
                                        <a href="#" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-arrow-circle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <?php foreach ($forum->children as $child): ?>
                                                <li class="node subCategory">
                                                    <?= $this->Html->link($child->title, ['_name' => 'forum-categories', 'id' => $child->id, 'slug' => $child->title]) ?>
                                                </li>

                                                <?php
                                                //Add to the thread counter.
                                                $threadCount += $child->thread_count;

                                                //Process the last post.
                                                if (!is_null($child->last_post)) {
                                                    if (!is_null($lastPost)) {
                                                        if ($lastPost->id < $child->last_post->id) {
                                                            $lastPost = $child->last_post;
                                                        }
                                                    } else {
                                                        $lastPost = $child->last_post;
                                                    }
                                                }
                                                ?>

                                                <?php if (is_array($child->children) && !empty($child->children)): ?>
                                                    <?php
                                                        $result = $this->Forum->generateCategories($child->children, true);
                                                        echo $result['html'];

                                                        //Add to the thread counter.
                                                        $threadCount += $result['thread_count'];
                                                    ?>
                                                <?php endif; ?>

                                                <?php
                                                //Process the last post.
                                                if (isset($result['last_post'])) {
                                                    if (!is_null($lastPost)) {
                                                        if ($lastPost->id < $result['last_post']->id) {
                                                            $lastPost = $result['last_post'];
                                                        }
                                                    } else {
                                                        $lastPost = $result['last_post'];
                                                    }
                                                }
                                                ?>
                                            <?php endforeach; ?>

                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="forumStats hidden-xs">
                            <span class="stats-wrapper">
                                <?= __n('{0} Thread', '{0} Threads', $threadCount, $threadCount) ?><br>
                            </span>
                        </td>

                        <td class="forumLastPost hidden-xs">
                            <?php if (($lastPost === null)): ?>
                                <span class="noMessages muted">
                                    <?= __('(Contains no threads)') ?>
                                </span>
                            <?php else: ?>
                                <span class="lastMessage">
                                    <?= __('By') ?>
                                    <?= $this->Html->link($lastPost->user->full_name, ['_name' => 'users-profile', 'slug' => $lastPost->user->slug, 'prefix' => false], ['class' => 'text-primary']) ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-sign-out"></i>',
                                        [
                                            'controller' => 'posts',
                                            'action' => 'go',
                                            $lastPost->id
                                        ],
                                        [
                                            'escape' => false,
                                            'class' => 'text-primary'
                                        ]
                                    )?>
                                    <br>
                                    <span class="lastMessagetime">
                                        <?= $lastPost->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT]) ?>
                                    </span>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="forumLastPost-phone visible-xs">
                            <i class="fa fa-plus fa-2x"></i>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>
