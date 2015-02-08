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
									<?= $forum->description ?>
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

												<?php if (is_array($child->children) && !empty($child->children)) : ?>
													<?php echo $this->Forum->generateCategories($child->children) ?>
												<?php endif; ?>
											<?php endforeach; ?>

										</ul>
									<?php endif; ?>
								</div>
							</div>
						</td>
						<td class="forumStats hidden-xs">
							<span class="stats-wrapper">
								0 Topics <br>
								0 Posts
							</span>
						</td>
						<td class="forumLastPost hidden-xs">
							<!--<span class="noMessages muted">(Contains no messages)</span>-->
							<span class="lastMessage">
								By <a title="" data-original-title="" href="./memberlist.php?mode=viewprofile&amp;u=2" style="color: #26BCB5;" class="username-coloured">
										Xeta
									</a>
								<a data-original-title="View the latest post" class="moderator-item" href="./viewtopic.php?f=6&amp;p=17#p17" title="">
									<i class="mobile-post fa fa-sign-out"></i>
								</a>
								<br>
								<span class="lastMessagetime">10 Aug 2014, 21:41</span>
							</span>
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
