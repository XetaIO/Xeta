<?= $this->assign('title', __("Dashboard")); ?>

<?= $this->Html->script(['jquery.flot.min'], ['block' => 'scriptBottom']) ?>
<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Session->flash(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-newspaper-o"></i> <?= __("Dashboard");?>
			</h1>
			<ol class="breadcrumb">
				<li class="active">
					<i class="fa fa-dashboard"></i> <?= __("Dashboard");?>
				</li>
			</ol>
		</div>
		
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3">
					<div class="info-box">
						<div class="title">
							<h5>
								<?= __("Members");?>
								<i class="fa fa-users pull-right"></i>
							</h5>
						</div>
						<div class="body">
							<h1 class="number">
								<?= $usersCount ?>
							</h1>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="info-box">
						<div class="title">
							<h5>
								<?= __("Articles");?>
								<i class="fa fa-newspaper-o pull-right"></i>
							</h5>
						</div>
						<div class="body">
							<h1 class="number">
								<?= $articlesCount ?>
							</h1>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="info-box">
						<div class="title">
							<h5>
								<?= __("Comments");?>
								<i class="fa fa-comments-o pull-right"></i>
							</h5>
						</div>
						<div class="body">
							<h1 class="number">
								<?= $commentsCount ?>
							</h1>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="info-box">
						<div class="title">
							<h5>
								<?= __("Categories");?>
								<i class="fa fa-tag pull-right"></i>
							</h5>
						</div>
						<div class="body">
							<h1 class="number">
								<?= $categoriesCount ?>
							</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="space-30"></div>
		
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<?= __("Members"); ?>
				</div>
				<div class="panel-body">
					<div id="stats-members" style="width: 100%; height:250px;"></div>
					
					<?php $this->append('scriptBottom');?>
					<script type="text/javascript">

						var data = [];

						<?php foreach($usersGraph as $date => $count):?>
							data.push([
								<?= strtotime($date) * 1000;?>,
								<?= $count;?>]);
						<?php endforeach;?>

						$(function() {

							for (var d = data[0][0], e = data[7][0], f = [1, "day"], g = "%d/%m/%y", h = 0, c = 0; 8 > c; c++) {

								h = data[c][1] + h;
							}

							var i = {
								grid: {
									show: !0,
									aboveData: !0,
									labelMargin: 20,
									axisMargin: 0,
									borderWidth: 0,
									borderColor: null,
									minBorderMargin: 5,
									clickable: !0,
									hoverable: !0,
									autoHighlight: !0,
									mouseActiveRadius: 100
								},
								series: {
									grow: {
										active: !0,
										duration: 1500
									},
									lines: {
										show: !0,
										fill: !1,
										lineWidth: 2.5
									},
									points: {
										show: !0,
										radius: 4,
										lineWidth: 2.5,
										fill: !0,
										fillColor: "#f68484"
									}
								},
								colors: ["#1abc9c"],
								legend: {
									show: false
								},
								shadowSize: 0,
								tooltip: !0,
								tooltipOpts: {
									content: "%y members",
									xDateFormat: "%d/%m/%Y",
									shifts: {
										x: -30,
										y: -50
									},
									theme: "dark",
									defaultTheme: !1
								},
								yaxis: {
									min: 0
								},
								xaxis: {
									mode: "time",
									minTickSize: f,
									timeformat: g,
									min: d,
									max: e,
									tickLength: 0
								}
							};
							$.plot($("#stats-members"), [{
								label: "Members",
								data: data
							}], i)

						});
					</script>
					<?php $this->end();?>
				</div>
			</div>
		</div>
		
		<?php if (\Cake\Core\Configure::read('Analytics.enabled') === true): ?>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?= __("Visitors"); ?>
					</div>
					<div class="panel-body">
						<div id="stats-pageviews" style="width: 100%; height:250px;"></div>
						
						<?php $this->append('scriptBottom') ?>
						<script type="text/javascript">

							var Visits = [];
							
							var PageViews = [];

							<?php foreach($graphVisitors->getRows() as $result): ?>
								Visits.push([
									<?= strtotime($result[0]) * 1000;?>,
									<?= $result[1];?>
								]);
								
								PageViews.push([
									<?= strtotime($result[0]) * 1000;?>,
									<?= $result[2];?>
								]);
							<?php endforeach;?>


							$(function() {

								var d = {
										grid: {
											show: !0,
											labelMargin: 20,
											axisMargin: 40,
											borderWidth: 0,
											borderColor: null,
											minBorderMargin: 20,
											clickable: !0,
											hoverable: !0,
											autoHighlight: !0,
											mouseActiveRadius: 100
										},
										series: {
											grow: {
												active: !0,
												duration: 1e3
											},
											lines: {
												show: !0,
												fill: !1,
												lineWidth: 2.5
											},
											points: {
												show: !0,
												radius: 5,
												lineWidth: 3,
												fill: !0,
												fillColor: "#f68484",
												strokeColor: "#fff"
											}
										},
										colors: ["#768399", "#1abc9c"],
										legend: {
											show: !0,
											position: "ne",
											margin: [0, -25],
											noColumns: 0,
											labelBoxBorderColor: null,
											labelFormatter: function(z) {
												return "&nbsp;" + z + "&nbsp;&nbsp;"
											},
											width: 40,
											height: 1
										},
										shadowSize: 0,
										tooltip: !0,
										tooltipOpts: {
											content: "%y",
											xDateFormat: "%d/%m",
											shifts: {
												x: -45,
												y: -50
											},
											defaultTheme: !1
										},
										yaxis: {
											min: 0
										},
										xaxis: {
											mode: "time",
											timeformat: "%d/%m/%y",
											tickLength: 0
										}
									};

								$.plot($("#stats-pageviews"), [{
									label: "Visitors",
									data: Visits
								}, {
									label: "Page Views",
									data: PageViews
								}], d)
							});
						</script>
						<?php $this->end() ?>
					</div>
				</div>
			</div>
			
			<div class="space-30"></div>
			
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?= __("Browsers"); ?>
					</div>
					<div class="panel-body">
						<?php foreach(array_reverse($browsers->getRows()) as $browser): ?>
							<?php
							$poucent = ($browser[1] * 100) / $browsers->getTotalsForAllResults()['ga:pageviews'];
							?>
							<div class="col-md-4">
								<?= $this->Html->image(
									'browsers/' . h($browser[0]) . '.png',
									[
										'class' => 'img-responsive',
										'alt' => h($browser[0]),
										'data-toggle' => 'tooltip',
										'data-container' => 'body',
										'title' => __("Pages views : {0}", $browser[1])
									]
								);?>
								<div class="text-center"><?= round($poucent) . "%" ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-default">

					<div class="panel-heading">
						<?= __("Statistics"); ?>
					</div>

					<div class="panel-body" style="padding:0">
						<table class="table table-striped">
							<thead>
								<tr>
									<th><?= __("Type"); ?></th>
									<th><?= __("Value"); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<?= __("Pages Views"); ?>
									</td>
									<td>
										<?= $this->Number->format($statistics->getTotalsForAllResults()['ga:pageviews'],
										['locale' => 'fr_FR']) ?>
									</td>
								</tr>
								<tr>
									<td>
										<?= __("Pages/Visit"); ?>
									</td>
									<td>
										<?= $this->Number->format($statistics->getTotalsForAllResults()['ga:pageviewsPerVisit'],
										['locale' => 'fr_FR', 'precision' => 2]) ?>
									</td>
								</tr>
								<tr>
									<td>
										<?= __("Average length/Visit"); ?>
									</td>
									<td>
										<?= gmdate("H:i:s", $statistics->getTotalsForAllResults()['ga:avgtimeOnSite']); ?>
									</td>
								</tr>
								<tr>
									<td>
										<?= __("Bounce Rate"); ?>
									</td>
									<td>
										<?= $this->Number->format($statistics->getTotalsForAllResults()['ga:visitBounceRate'],
										['locale' => 'fr_FR', 'precision' => 2]) ?>%
									</td>
								</tr>
								<tr>
									<td>
										<?= __("Visits"); ?>
									</td>
									<td>
										<?= $this->Number->format($statistics->getTotalsForAllResults()['ga:visits'],
										['locale' => 'fr_FR']) ?>
									</td>
								</tr>
								<tr>
									<td>
										<?= __("Unique Visitors"); ?>
									</td>
									<td>
										<?= $this->Number->format($statistics->getTotalsForAllResults()['ga:visitors'],
										['locale' => 'fr_FR']) ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?= __("Continents"); ?>
					</div>
					<div class="panel-body">
						<div id="stats-continents" style="height:218px"></div>

						<?php $this->append('scriptBottom');?>
						<script type="text/javascript">
							var contients = <?= json_encode($continents) ?>;
							
							$(function () {
								$.plot('#stats-continents', contients, {
									series: {
										pie: {
											show: true,
											label: {
												show: false
											},
											innerRadius: .65,
											highlight: {
												opacity: .1
											},
											radius: 1,
											stroke: {
												width: 5
											},
											startAngle: 2.15
										}
									},
									legend: {
										show: !0,
										labelFormatter: function(a) {
											return '<div style="font-weight:bold;font-size:13px;">' + a + "</div>"
										},
										labelBoxBorderColor: null,
										margin: 50,
										width: 20,
										padding: 1
									},
									grid: {
										hoverable: true
									},
									tooltip: true,
									tooltipOpts: {
										content: "%p.0%, %s",
										shifts: {
											x: 20,
											y: 0
										},
										defaultTheme: false
									}
								});
							});
						</script>
						<?php $this->end();?>
					</div>
				</div>
			</div>
			
		<?php endif; ?>


	</div>
</div>
