<div class="row tile_count">
	<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Заказов за все время</span>
		<div class="count"><?php echo $data['allOrders']?></div>
	</div>
	<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Не обработанных заказов за все время</span>
		<div class="count <?php echo ($data['allNotProcessedOrders'] != 0) ? 'red' : 'green'; ?>"><?php echo $data['allNotProcessedOrders']?></div>
	</div>
	<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Заказов за сегодня</span>
		<div class="count"><?php echo $data['todayOrders']?></div>
	</div>
	<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
		<span class="count_top"><i class="fa fa-user"></i> Не обработанных заказов за сегодня</span>
		<div class="count <?php echo ($data['todayNotProcessedOrders'] != 0) ? 'red' : 'green'; ?>"><?php echo $data['todayNotProcessedOrders']?></div>
	</div>
</div>