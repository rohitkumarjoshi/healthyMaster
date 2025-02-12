<!DOCTYPE html>
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<head>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i&display=swap" rel="stylesheet">
		<meta charset="utf-8"/>
		<?php echo $this->Html->meta(
				'favicon.png',
				'/img/favicon.png',
				['type' => 'icon']
			); ?>
		<title><?= $this->fetch('title') ?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta content="" name="description"/>
		<meta content="" name="author"/>
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
		<?php echo $this->Html->script('/assets/global/plugins/pace/pace.min.js'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/pace/themes/pace-theme-flash.css'); ?>
		<?php //echo $this->Html->css('/assets/global/css/print.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/uniform/css/uniform.default.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN PAGE LEVEL STYLES -->
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap-toastr/toastr.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/select2/select2.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap-select/bootstrap-select.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/jquery-multi-select/css/multi-select.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>
		<!-- BEGIN THEME STYLES -->
		<!-- BEGIN THEME STYLES -->
		<?php echo $this->Html->css('/assets/global/css/components.css'); ?>
		<?php echo $this->Html->css('/assets/global/css/plugins.css'); ?>
		<?php echo $this->Html->css('/assets/admin/layout/css/layout.css'); ?>
		<?php echo $this->Html->css('/assets/admin/layout/css/themes/default.css'); ?>
		<?php echo $this->Html->css('/assets/admin/layout/css/custom.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/jquery-notific8/jquery.notific8.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/icheck/skins/all.css'); ?>
		<!-- BEGIN PAGE LEVEL STYLES -->
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/jquery-tags-input/jquery.tagsinput.css'); ?>

			<!-- END PAGE LEVEL STYLES -->
		<style media="print">
			.hide_at_print {
				display:none !important;
			}
		</style>
		<style>
			.error-message {
				color: red;
				font-style: inherit;
			}
			.help-block-error{
				color: #a94442;
				font-size: 10px;
			}
		</style>
		<style>
			.self-table > tbody > tr > td, .self-table > tr > td
			{
				border-top:none !important;
			}
			.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
			 
				vertical-align:middle !important;
			}
			option 
			{
				border-top:1px solid #CACACA;
				padding:4px;
				cursor:pointer;
			}
			select 
			{
				cursor:pointer;
			}
			.myshortlogo
			{
				font: 15px "Open Sans",sans-serif;
				text-transform: uppercase !important;
				box-sizing:border-box;
			}
			.toast_success_notify{
				margin: 0px 0px 6px;
				border-radius: 3px;
				background-position: 15px center;
				background-repeat: no-repeat;
				box-shadow: 0px 0px 12px ;
				color: #FFF;
				opacity: 0.8;
				background-color: #42893D;
			}
			.tost_edit_notify{
				margin: 0px 0px 6px;
				border-radius: 3px;
				background-position: 15px center;
				background-repeat: no-repeat;
				box-shadow: 0px 0px 12px #999;
				color: #FFF;
				opacity: 0.8;
				background-color: #B0B343;	
			}
			.tost_delete_notify{
				margin: 0px 0px 6px;
				border-radius: 3px;
				background-position: 15px center;
				background-repeat: no-repeat;
				box-shadow: 0px 0px 12px #999;
				color: #FFF;
				opacity: 0.8;
				background-color: #D75C48;
			}
		</style>
		<!-- END THEME STYLES -->
		<!--<link rel="shortcut icon" href="/img/favicon.png"/>
	</head>
	<!-- END HEAD -->
	<!-- BEGIN BODY -->
	<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
	<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
	<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
	<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
	<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
	<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
	<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
	<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
	<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
	
	<body class="page-header-fixed page-quick-sidebar-over-content page-style-square">
		<!-- BEGIN HEADER -->
		<div class="page-header navbar navbar-fixed-top">
			<!-- BEGIN HEADER INNER -->
			<div class="page-header-inner">
				<!-- BEGIN LOGO -->
				<div class="page-logo" style="padding-top:2px;padding-bottom:2px; width: auto;">
					<!-- <?php echo $this->Html->image('/img/jainthela.png', ['height' => '40px']); ?> -->
					<span><?php echo $this->Html->image('/img/a.png', ['height' => '40px']); ?></span>
				</div>
				<!-- End LOGO -->
				<div class="hor-menu hidden-sm hidden-xs">
					<ul class="nav navbar-nav " style="margin-left:100px;">
						<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover -->
						
						<!-- <li class="classic-menu-dropdown" >
							<a data-toggle="dropdown" href="javascript:;" aria-expanded="false">
								Masters & Setup <i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu" >
								<li>
								<?php echo $this->Html->link('<i class="fa fa-user"></i> Customers','/Customers',['escape'=>false]) ?>
								</li>
								<li>
								<?php echo $this->Html->link('<i class="fa fa-user"></i> FAQ','/Faqs',['escape'=>false]) ?>
								</li>
								<li>
								<?php echo $this->Html->link('<i class="fa fa-user"></i> Pincodes','/Pincodes',['escape'=>false]) ?>
								</li>
								<li>
									<?php echo $this->Html->link('<i class="fa fa-users"></i> Vendors','/Vendors',['escape'=>false]) ?>
								</li>
								<li>
								<?php echo $this->Html->link('<i class="fa fa-magnet"></i> UnitVariations','/UnitVariations',['escape'=>false]) ?>
								</li>
								<li>
									<?php echo $this->Html->link('<i class="fa fa-sitemap"></i> Item Categories','/Item-Categories',['escape'=>false]) ?>
								</li>
								<li>
									<?php echo $this->Html->link('<i class="fa fa-info"></i> Items','/Items',['escape'=>false]) ?>
								</li>
								<li>
									<?php echo $this->Html->link('<i class="fa fa-cubes"></i> Sales Rate Update','/ItemVariations/define_sale_rate',['escape'=>false]) ?>
								</li>
								
							</ul>
						</li> -->
						
					</ul>
				</div>				 
				<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
				</a>
				<!-- END RESPONSIVE MENU TOGGLER -->
				<!-- BEGIN TOP NAVIGATION MENU -->
				<div class="top-menu">
					<ul class="nav navbar-nav pull-right">

						<!-- BEGIN NOTIFICATION DROPDOWN -->						 
						<li class="dropdown dropdown-user">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
								<!--img alt="" class="img-circle" src="../../assets/admin/layout/img/avatar3_small.jpg"/-->
								<span class="username username-hide-on-mobile">
									<?php echo $this->request->session()->read('Config.language'); ?>							
									<?php echo $jain_thela_admin_id=$this->request->session()->read('Config.language'); ?>							
								</span>
								<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-menu-default">
								<li>									 
									 <?php echo $this->Html->link('<i class="fa fa-key"></i> Log Out', array('controller' => 'Users', 'action' => 'logout'),['escape'=>false]);  ?>
								</li>
								<li>									 
									 <?php echo $this->Html->link('<i class="fa fa-lock"></i> Change Password', array('controller' => 'Users', 'action' => 'changePassword'),['escape'=>false]);  ?>
								</li>
								<li>									 
									 <?php echo $jain_thela_admin_id;  ?>
								</li>
							</ul>
						</li>
						<!-- END USER LOGIN DROPDOWN -->						 
					</ul>
				</div>
				<!-- END TOP NAVIGATION MENU -->
			</div>
			<!-- END HEADER INNER -->
		</div>
		<!-- END HEADER -->
		<div class="clearfix">
		</div>
		<!-- BEGIN CONTAINER -->
		<?php if($login_user_id==1){ ?>
		<div class="page-container">
				<!-- BEGIN SIDEBAR -->
				<div class="page-sidebar-wrapper">
					<div class="page-sidebar navbar-collapse collapse">
						<!-- BEGIN SIDEBAR MENU -->
						<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
						<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
						<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
						<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
						<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
						<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
						<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">


							<li>
								<?php echo $this->Html->link('<i class="fa fa-dashboard" ></i> <span >Dashboard</span>',array('controller'=>'Orders','action'=>'dashboard'),['escape'=>false]); ?>
							</li>
							<li class="classic-menu-dropdown" >
								<a data-toggle="dropdown" href="javascript:;" aria-expanded="false">
									<i class="fa fa-reorder" ></i>Masters & Setup <i class="fa fa-angle-down"></i>
								</a>
								<ul class="sub-menu" >
									<li>
									<?php echo $this->Html->link('<i class="fa fa-user"></i> Customers','/Customers',['escape'=>false]) ?>
									</li>
									
									<li>
									<?php echo $this->Html->link('<i class="fa fa-user"></i> Pincodes','/Pincodes',['escape'=>false]) ?>
									</li>
									<!--<li>
										<?php echo $this->Html->link('<i class="fa fa-users"></i> Vendors','/Vendors',['escape'=>false]) ?>
									</li>-->
									<li>
									<?php echo $this->Html->link('<i class="fa fa-user"></i> Referal','/ReferalMasters',['escape'=>false]) ?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-magnet"></i> Unit Variations','/UnitVariations',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-sitemap"></i> Item Categories','/Item-Categories',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-info"></i> Items','/Items',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-cubes"></i> Sales Rate Update','/ItemVariations/define_sale_rate',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-cubes"></i> Home Screen','/home-screens/add',['escape'=>false]) ?>
									</li>
								</ul>
							</li>
							<li class="classic-menu-dropdown" >
								<a data-toggle="dropdown" href="javascript:;" aria-expanded="false">
									<i class="fa fa-reorder" ></i>Reports <i class="fa fa-angle-down"></i>
								</a>
								<ul class="sub-menu" >
									<!--<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Stock Report','/itemLedgers/report_show',['escape'=>false]) ?>
									</li>-->
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Push Notification','/AppNotifications/notification_report',['escape'=>false]) ?>
									</li>
									<!--<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Purchase Report','/PurchaseBookings/purchase_report',['escape'=>false]) ?>
									</li>-->
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Items Report','/Items/item_report',['escape'=>false]) ?>
									</li>
									<!--<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Variation Stock','/ItemLedgers/stockReport',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Material Stock','/ItemLedgers/stockReportVarWise',['escape'=>false]) ?>
									</li>-->
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Stock Report','/ItemLedgers/NewReportStock',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> ThresHold Report','/ItemLedgers/ThresHoldReport',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Wallet Report','/Customers/wallet_report',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> GST Report','/Orders/gst_reports',['escape'=>false]) ?>
									</li>

									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Order Report','/Orders/oreport',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Feedback Report','/Feedbacks/report',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Top Selling Item Report','/ItemCategories/top_selling',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> WishList Report','/Wishlists/wishlist_report',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Cart Report','/Carts/cart_report',['escape'=>false]) ?>
									</li>
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Customer Wallet','/JainCashPoints/point_report',['escape'=>false]) ?>
									</li> -->
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Promo Code Report','/PromoCodes/promo_code_report',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Used Promo Code','/Orders/used_promo_code_report',['escape'=>false]) ?>
									</li>
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-database"></i> Product Report','/itemLedgers/driver_report',['escape'=>false]) ?>
									</li> -->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-bar-chart-o"></i> Cash Back Details','/CashBacks/Index',['escape'=>false]) ?>
									</li> -->
									<?php if($login_user_id==3){ ?>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-trophy"></i> Cash Back Winner','/CashBacks/CashBackWinner',['escape'=>false]) ?>
									</li>
									<?php } ?>
									<!--<li>
										<?php 
										$t_date = date('d-m-Y');
										echo $this->Html->link('<i class="fa fa-book"></i> Invoice Report','/WalkinSales/invoiceReports?warehouse=&drivers=&From='.$t_date.'&To='.$t_date,['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-life-ring"></i> Issue Return Report','/ItemLedgers/itemIssueReport',['escape'=>false]) ?>
									</li>
									
									<li>
										<?php echo $this->Html->link('<i class="fa fa-puzzle-piece"></i> Account Statement','/Ledgers/AccountStatements',['escape'=>false]) ?>
									</li>
									-->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-tag"></i> Item Wise Sales Report','/itemLedgers/itemSaleReports',['escape'=>false]) ?>
									</li> -->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-puzzle-piece"></i> Wastage Item Report','/itemLedgers/wastageReport?From='.$t_date.'&To='.$t_date,['escape'=>false]) ?>
									</li> -->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-globe"></i> Weight Variation Report','/itemLedgers/weightVariationReport?From='.$t_date.'&To='.$t_date,['escape'=>false]) ?>
									</li> -->
										<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-info"></i> Item Indent Report','/itemLedgers/orderEstimate',['escape'=>false]) ?>
									</li> 
									<li>
										<?php echo $this->Html->link('<i class="fa fa-cubes"></i> Driver Location Report','/Drivers/driver_location',['escape'=>false]) ?>
									</li>
									 <li>
										<?php echo $this->Html->link('<i class="fa fa-edit"></i> Consolidate Report','/itemLedgers/averageReport?From='.$t_date.'&To='.$t_date,['escape'=>false]) ?>
									</li> -->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-trophy"></i> First Order Discount Report','/Orders/newCustomer',['escape'=>false]) ?>
									</li> -->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-database"></i> Stock Return Voucher Report','/StockReturnVouchers/',['escape'=>false]) ?>
									</li> -->
								</ul>
						</li>
							<li>
								<?php echo $this->Html->link('<i class="fa fa-reorder"></i> <span>Manage Orders</span>',array('controller'=>'Orders','action'=>'index'),['escape'=>false]); ?>
							</li>
							<li>
								<?php echo $this->Html->link('<i class="fa fa-reorder"></i> <span>Order List</span>',array('controller'=>'Orders','action'=>'orderList?status=process'),['escape'=>false]); ?>
							</li>
							<li>
								<?php echo $this->Html->link('<i class="fa fa-bell"></i> <span>Push Notification</span>',array('controller'=>'AppNotifications','action'=>'index'),['escape'=>false]); ?>
							</li>
							<!--<li>
								<?php echo $this->Html->link('<i class="fa fa-bell"></i> <span>Stock Conversion</span>',array('controller'=>'TransferInventoryVouchers','action'=>'add'),['escape'=>false]); ?>
							</li>-->
							<!-- <li>
								<?php echo $this->Html->link('<i class=" fa-file-text"></i> <span>Feedback</span>',array('controller'=>'Feedbacks/add'),['escape'=>false]); ?>
							</li> -->
							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-chain "></i> <span>Bulk Lead</span>',array('controller'=>'BulkBookingLeads/index/open'),['escape'=>false]); ?>
							</li> -->


							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-ticket"></i> GRNs','/Grns',['escape'=>false]) ?>
							</li> 
							<li>
								<?php echo $this->Html->link('<i class="fa  fa-book"></i> Purchase Booking','/PurchaseBookings',['escape'=>false]) ?>
							</li>-->
							<li>
								<?php echo $this->Html->link('<i class="fa  fa-book"></i> Wastage Reuse','/WastageReuseVouchers/add',['escape'=>false]) ?>
							</li>
							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-puzzle-piece"></i> Transfer Inventory','/TransferInventoryVouchers/',['escape'=>false]) ?>
							</li> -->
							<!--			
							<li>
								<?php echo $this->Html->link('<i class="fa fa-gear"></i> Purchase Outward','/PurchaseOutwards/',['escape'=>false]) ?>
							</li>-->
						
							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-sitemap"></i> Stock Issue','/itemLedgers/add',['escape'=>false]) ?>
							</li> -->
							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-retweet"></i> Stock Return','/itemLedgers/stock_return',['escape'=>false]) ?>
							</li> -->
							<li>
								<?php echo $this->Html->link('<i class="fa fa-asterisk"></i> WalkinSales','/Orders/add/Offline',['escape'=>false]) ?>
							</li>
							<!--<li>
								<?php echo $this->Html->link('<i class="fa fa-tasks"></i> Bulk Order','/Orders/add/Bulkorder',['escape'=>false]) ?>
							</li>
							 <li>
								<?php echo $this->Html->link('<i class="fa fa-life-ring"></i> Walkin Sales','/WalkinSales/index',['escape'=>false]) ?>
							</li> -->
							
							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-gear"></i> Wastage Vouchers','/itemLedgers/wastageVouchers',['escape'=>false]) ?>
							</li> 
							<li>
								<?php echo $this->Html->link('<i class="fa fa-tree"></i> Combo Offer','/ComboOffers',['escape'=>false]) ?>
							</li>

							<li>
								<?php echo $this->Html->link('<i class="fa fa-star"></i> Leads','/Leads/index/open',['escape'=>false]) ?>
							</li>

							<li>
								<?php echo $this->Html->link('<i class="fa fa-road"></i> Plans','/Plans',['escape'=>false]) ?>
							</li> -->
							<li>
								<?php echo $this->Html->link('<i class="fa fa-rocket"></i> Promo Code','/PromoCodes',['escape'=>false]) ?>
							</li>
							
							<!-- <li>
								<a href="javascript:;"><i class="fa fa-puzzle-piece"></i><span class="title">Wallets</span>
								<span class="arrow "></span>
								</a>
								<ul class="sub-menu">
									<?php 
									echo '<li>'.$this->Html->link('<i class="icon-home"></i> Add','/Wallets/Add',array('escape'=>false)).'</li>';
									?>
									<?php 
									echo '<li>'.$this->Html->link('<i class="icon-home"></i> Subtract','/Wallets/remove',array('escape'=>false)).'</li>';
									 ?>
								</ul>
							</li> -->
							
							

						</ul>
						<!-- END SIDEBAR MENU -->
					</div>
				</div>
				<!-- END SIDEBAR -->
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div  class="page-spinner-bar hide">
						<div class="bounce1"></div>
						<div class="bounce2"></div>
						<div class="bounce3"></div>
					</div>
					<!-- BEGIN PAGE HEADER-->					
					<!-- END PAGE HEADER-->
					<!-- BEGIN PAGE CONTENT-->					 
					<div class="row">
						<div class="col-md-12">
							<div id="toast-container" class="toast-top-right" aria-live="polite" role="alert">
								
									<?= $this->Flash->render() ?>
								
							</div>
							<?php echo $this->fetch('content'); ?>
							<!--here is page content--->
						</div>
					</div>
						<!-- END PAGE CONTENT-->
				</div>
			</div>
			<!-- END CONTENT -->
			<!-- BEGIN QUICK SIDEBAR -->
			<!-- END QUICK SIDEBAR -->
		</div>
		<?php }else{ ?>
		<div class="page-container">
				<!-- BEGIN SIDEBAR -->
				<div class="page-sidebar-wrapper">
					<div class="page-sidebar navbar-collapse collapse">
						<!-- BEGIN SIDEBAR MENU -->
						<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
						<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
						<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
						<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
						<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
						<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
						<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">


							<li>
								<?php echo $this->Html->link('<i class="fa fa-dashboard" ></i> <span >Dashboard</span>',array('controller'=>'Orders','action'=>'dashboard'),['escape'=>false]); ?>
							</li>
							<li class="classic-menu-dropdown" >
								<a data-toggle="dropdown" href="javascript:;" aria-expanded="false">
									<i class="fa fa-reorder" ></i>Masters & Setup <i class="fa fa-angle-down"></i>
								</a>
								<ul class="sub-menu" >
									<li>
									<?php echo $this->Html->link('<i class="fa fa-user"></i> Customers','/Customers',['escape'=>false]) ?>
									</li>
									
									<li>
									<?php echo $this->Html->link('<i class="fa fa-user"></i> Pincodes','/Pincodes',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-users"></i> Vendors','/Vendors',['escape'=>false]) ?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-user"></i> Referal','/ReferalMasters',['escape'=>false]) ?>
									</li>
									<li>
									<?php echo $this->Html->link('<i class="fa fa-magnet"></i> Unit Variations','/UnitVariations',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-sitemap"></i> Item Categories','/Item-Categories',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-info"></i> Items','/Items',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-cubes"></i> Sales Rate Update','/ItemVariations/define_sale_rate',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-cubes"></i> Home Screen','/home-screens/add',['escape'=>false]) ?>
									</li>
								</ul>
							</li>
							<li class="classic-menu-dropdown" >
								<a data-toggle="dropdown" href="javascript:;" aria-expanded="false">
									<i class="fa fa-reorder" ></i>Reports <i class="fa fa-angle-down"></i>
								</a>
								<ul class="sub-menu" >
									<!--<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Stock Report','/itemLedgers/report_show',['escape'=>false]) ?>
									</li>-->
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Push Notification','/AppNotifications/notification_report',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Purchase Report','/PurchaseBookings/purchase_report',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Items Report','/Items/item_report',['escape'=>false]) ?>
									</li>
									<!--<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Variation Stock','/ItemLedgers/stockReport',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Material Stock','/ItemLedgers/stockReportVarWise',['escape'=>false]) ?>
									</li>-->
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Stock Report','/ItemLedgers/NewReportStock',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> ThresHold Report','/ItemLedgers/ThresHoldReport',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Wallet Report','/Customers/wallet_report',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> GST Report','/Orders/gst_reports',['escape'=>false]) ?>
									</li>

									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Order Report','/Orders/oreport',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Feedback Report','/Feedbacks/report',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Top Selling Item Report','/ItemCategories/top_selling',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> WishList Report','/Wishlists/wishlist_report',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Cart Report','/Carts/cart_report',['escape'=>false]) ?>
									</li>
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Customer Wallet','/JainCashPoints/point_report',['escape'=>false]) ?>
									</li> -->
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Promo Code Report','/PromoCodes/promo_code_report',['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa  fa-file"></i> Used Promo Code','/Orders/used_promo_code_report',['escape'=>false]) ?>
									</li>
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-database"></i> Product Report','/itemLedgers/driver_report',['escape'=>false]) ?>
									</li> -->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-bar-chart-o"></i> Cash Back Details','/CashBacks/Index',['escape'=>false]) ?>
									</li> -->
									<?php if($login_user_id==3){ ?>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-trophy"></i> Cash Back Winner','/CashBacks/CashBackWinner',['escape'=>false]) ?>
									</li>
									<?php } ?>
									<!--<li>
										<?php 
										$t_date = date('d-m-Y');
										echo $this->Html->link('<i class="fa fa-book"></i> Invoice Report','/WalkinSales/invoiceReports?warehouse=&drivers=&From='.$t_date.'&To='.$t_date,['escape'=>false]) ?>
									</li>
									<li>
										<?php echo $this->Html->link('<i class="fa fa-life-ring"></i> Issue Return Report','/ItemLedgers/itemIssueReport',['escape'=>false]) ?>
									</li>
									
									<li>
										<?php echo $this->Html->link('<i class="fa fa-puzzle-piece"></i> Account Statement','/Ledgers/AccountStatements',['escape'=>false]) ?>
									</li>
									-->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-tag"></i> Item Wise Sales Report','/itemLedgers/itemSaleReports',['escape'=>false]) ?>
									</li> -->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-puzzle-piece"></i> Wastage Item Report','/itemLedgers/wastageReport?From='.$t_date.'&To='.$t_date,['escape'=>false]) ?>
									</li> -->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-globe"></i> Weight Variation Report','/itemLedgers/weightVariationReport?From='.$t_date.'&To='.$t_date,['escape'=>false]) ?>
									</li> -->
										<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-info"></i> Item Indent Report','/itemLedgers/orderEstimate',['escape'=>false]) ?>
									</li> 
									<li>
										<?php echo $this->Html->link('<i class="fa fa-cubes"></i> Driver Location Report','/Drivers/driver_location',['escape'=>false]) ?>
									</li>
									 <li>
										<?php echo $this->Html->link('<i class="fa fa-edit"></i> Consolidate Report','/itemLedgers/averageReport?From='.$t_date.'&To='.$t_date,['escape'=>false]) ?>
									</li> -->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-trophy"></i> First Order Discount Report','/Orders/newCustomer',['escape'=>false]) ?>
									</li> -->
									<!-- <li>
										<?php echo $this->Html->link('<i class="fa fa-database"></i> Stock Return Voucher Report','/StockReturnVouchers/',['escape'=>false]) ?>
									</li> -->
								</ul>
						</li>
							<li>
								<?php echo $this->Html->link('<i class="fa fa-reorder"></i> <span>Manage Orders</span>',array('controller'=>'Orders','action'=>'index'),['escape'=>false]); ?>
							</li>
							<li>
								<?php echo $this->Html->link('<i class="fa fa-reorder"></i> <span>Order List</span>',array('controller'=>'Orders','action'=>'orderList?status=process'),['escape'=>false]); ?>
							</li>
							<li>
								<?php echo $this->Html->link('<i class="fa fa-bell"></i> <span>Push Notification</span>',array('controller'=>'AppNotifications','action'=>'index'),['escape'=>false]); ?>
							</li>
							<!--<li>
								<?php echo $this->Html->link('<i class="fa fa-bell"></i> <span>Stock Conversion</span>',array('controller'=>'TransferInventoryVouchers','action'=>'add'),['escape'=>false]); ?>
							</li>-->
							<!-- <li>
								<?php echo $this->Html->link('<i class=" fa-file-text"></i> <span>Feedback</span>',array('controller'=>'Feedbacks/add'),['escape'=>false]); ?>
							</li> -->
							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-chain "></i> <span>Bulk Lead</span>',array('controller'=>'BulkBookingLeads/index/open'),['escape'=>false]); ?>
							</li> -->


							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-ticket"></i> GRNs','/Grns',['escape'=>false]) ?>
							</li> -->
							<li>
								<?php echo $this->Html->link('<i class="fa  fa-book"></i> Purchase Booking','/PurchaseBookings',['escape'=>false]) ?>
							</li>
							<li>
								<?php echo $this->Html->link('<i class="fa  fa-book"></i> Wastage Reuse','/WastageReuseVouchers/add',['escape'=>false]) ?>
							</li>
							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-puzzle-piece"></i> Transfer Inventory','/TransferInventoryVouchers/',['escape'=>false]) ?>
							</li> -->
							<!--			
							<li>
								<?php echo $this->Html->link('<i class="fa fa-gear"></i> Purchase Outward','/PurchaseOutwards/',['escape'=>false]) ?>
							</li>-->
						
							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-sitemap"></i> Stock Issue','/itemLedgers/add',['escape'=>false]) ?>
							</li> -->
							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-retweet"></i> Stock Return','/itemLedgers/stock_return',['escape'=>false]) ?>
							</li> -->
							<li>
								<?php echo $this->Html->link('<i class="fa fa-asterisk"></i> WalkinSales','/Orders/add/Offline',['escape'=>false]) ?>
							</li>
							<!--<li>
								<?php echo $this->Html->link('<i class="fa fa-tasks"></i> Bulk Order','/Orders/add/Bulkorder',['escape'=>false]) ?>
							</li>
							 <li>
								<?php echo $this->Html->link('<i class="fa fa-life-ring"></i> Walkin Sales','/WalkinSales/index',['escape'=>false]) ?>
							</li> -->
							
							<!-- <li>
								<?php echo $this->Html->link('<i class="fa fa-gear"></i> Wastage Vouchers','/itemLedgers/wastageVouchers',['escape'=>false]) ?>
							</li> 
							<li>
								<?php echo $this->Html->link('<i class="fa fa-tree"></i> Combo Offer','/ComboOffers',['escape'=>false]) ?>
							</li>

							<li>
								<?php echo $this->Html->link('<i class="fa fa-star"></i> Leads','/Leads/index/open',['escape'=>false]) ?>
							</li>

							<li>
								<?php echo $this->Html->link('<i class="fa fa-road"></i> Plans','/Plans',['escape'=>false]) ?>
							</li> -->
							<li>
								<?php echo $this->Html->link('<i class="fa fa-rocket"></i> Promo Code','/PromoCodes',['escape'=>false]) ?>
							</li>
							
							<!-- <li>
								<a href="javascript:;"><i class="fa fa-puzzle-piece"></i><span class="title">Wallets</span>
								<span class="arrow "></span>
								</a>
								<ul class="sub-menu">
									<?php 
									echo '<li>'.$this->Html->link('<i class="icon-home"></i> Add','/Wallets/Add',array('escape'=>false)).'</li>';
									?>
									<?php 
									echo '<li>'.$this->Html->link('<i class="icon-home"></i> Subtract','/Wallets/remove',array('escape'=>false)).'</li>';
									 ?>
								</ul>
							</li> -->
							
							

						</ul>
						<!-- END SIDEBAR MENU -->
					</div>
				</div>
				<!-- END SIDEBAR -->
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div  class="page-spinner-bar hide">
						<div class="bounce1"></div>
						<div class="bounce2"></div>
						<div class="bounce3"></div>
					</div>
					<!-- BEGIN PAGE HEADER-->					
					<!-- END PAGE HEADER-->
					<!-- BEGIN PAGE CONTENT-->					 
					<div class="row">
						<div class="col-md-12">
							<div id="toast-container" class="toast-top-right" aria-live="polite" role="alert">
								
									<?= $this->Flash->render() ?>
								
							</div>
							<?php echo $this->fetch('content'); ?>
							<!--here is page content--->
						</div>
					</div>
						<!-- END PAGE CONTENT-->
				</div>
			</div>
			<!-- END CONTENT -->
			<!-- BEGIN QUICK SIDEBAR -->
			<!-- END QUICK SIDEBAR -->
		</div>
		
		<?php } ?>
		<!-- END CONTAINER -->
		<!-- BEGIN FOOTER -->
		<div class="page-footer">
			<div class="page-footer-inner">
				 <a href="http://phppoets.com/" target="_blank" style="color:#FFF;">2017 &copy; PHPPOETS IT SOLUTION PVT LTD.</a>
			</div>
			<div class="scroll-to-top">
				<i class="icon-arrow-up"></i>
			</div>
		</div>
		<!-- END FOOTER -->
			<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
		
		<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-migrate.min.js'); ?>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<?php echo $this->Html->script('/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap/js/bootstrap.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.blockui.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.cokie.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/uniform/jquery.uniform.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/icheck/icheck.min.js'); ?>
<!-- END CORE PLUGINS -->
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/clockface/js/clockface.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/moment.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-notific8/jquery.notific8.min.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/ui-notific8.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-toastr/toastr.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/select2/select2.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-select/bootstrap-select.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js'); ?>
<?php //echo $this->Html->script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js'); ?>
<?php //echo $this->Html->script('/assets/global/scripts/metronic.js'); ?>
<?php ///echo $this->Html->script('/assets/admin/layout/scripts/layout.js'); ?>
<?php //echo $this->Html->script('/assets/admin/layout/scripts/quick-sidebar.js'); ?>
<?php //echo $this->Html->script('/assets/admin/layout/scripts/demo.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/form-icheck.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.pulsate.min.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/table-managed.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/components-pickers.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-validation/js/jquery.validate.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-validation/js/additional-methods.min.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/form-validation.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/ui-general.js'); ?>
<?php //echo $this->Html->script('/assets/global/plugins/icheck/icheck.min.js'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<?php echo $this->Html->script('/assets/global/plugins/fuelux/js/spinner.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.input-ip-address-control-1.0.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js'); ?>
<?php //echo $this->Html->script('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/typeahead/handlebars.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/typeahead/typeahead.bundle.min.js'); ?>
<?php //echo $this->Html->script('/assets/global/plugins/icheck/icheck.min.js'); ?>
<?php //echo $this->Html->script('/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js'); ?>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php echo $this->Html->script('/assets/global/scripts/metronic.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/layout.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/quick-sidebar.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/demo.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/components-form-tools.js'); ?>
<?php //echo $this->Html->script('/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-markdown/lib/markdown.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-summernote/summernote.min.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/components-editors.js'); ?>




		<!-- END PAGE LEVEL SCRIPTS -->
		<script>
		jQuery(document).ready(function() {    
			Metronic.init(); // init metronic core components
			Layout.init(); // init current layout
			QuickSidebar.init(); // init quick sidebar
			Demo.init(); // init demo features
			FormValidation.init();
			TableManaged.init();
			ComponentsPickers.init();
			ComponentsDropdowns.init();
			
		});
		</script>	
		<script>
			$("a[role='button']").live('click',function(e){
					e.preventDefault();
			});

			$('a[role="button"]').live('click',function(e){
				e.preventDefault();
			});
			$('.firstupercase').die().live('blur',function(e){
				var str=$(this).val();
				var str2=touppercase(str);
				$(this).val(str2);
			});
			function touppercase(str){
				str = str.replace(/\b[a-z]/g, function(letter) {
					return letter.toUpperCase();
				});
				return str;
			}
			$(".nospace").live("keypress",function(e){
				 if(e.which === 32) 
				 return false;
			})
			
		</script>
		<script>
		//300000
		//10000
			var myVar = setInterval(function(){ myTimer() }, 300000);
			function myTimer() {
				var d = new Date();
				var t = d.toLocaleTimeString();
				document.getElementById("toast-container").innerHTML = t;
				var notification_id=1;
				//$('#popup').find('div.modal-body').html('Loading...');
				var url="<?php echo $this->Url->build(["controller" => "Orders", "action" => "alert_notification"]); ?>";
				url=url+'/'+notification_id;
				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'text'
				}).done(function(response) {
					var count = (response);
					if(count>0){
						$('#popup').show();
						var inner_div=$('#push').html();
						$('#popup').find('div.modal-body').html(inner_div);
						$('#txt').html(count+' New Order Push on Server');
					}
				});
				$('.close').die().live('click',function() {
					$('#popup').hide();
					update_notification();
				});
			}
			
			$('.updt').die().live('click',function() {
				var notification_id=1;
				var url="<?php echo $this->Url->build(["controller" => "Orders", "action" => "update_notification"]); ?>";
				url=url+'/'+notification_id;
				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'text'
				});
			});
		</script>
		</div>
		<!-- END JAVASCRIPTS -->
	</body>

	<!-- END BODY -->
</html>
<div  class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="false" style="display: none;border:0px;" id="popup">
<div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="border:0px;">
			<div class="modal-body flip-scroll" style="height: auto;
    overflow-y: auto;" >
				
			
			</div>
		</div>
	</div>
</div>

<div style="display:none;" id="push">
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding:10px;margin-top: -10px;width: 100%;font-size:14px;" class="maindiv">	
			<button type="button" class="close hidden-print" data-dismiss="modal" aria-hidden="true"></button>
			<div align="center" style="color:#F98630; font-size: 16px;font-weight: bold;">ORDERS</div>
					<div align="center">
						<span id="txt" ></span>
						<?= $this->Html->link('Click Here',['controller'=>'Orders','action' => 'index?status=process'],['escape'=>false,'class'=>'btn btn-xs blue updt']); ?>
					</div>
					<!--button type="button" class="btn btn-xs blue updt" onclick="update();" >Order List</button-->
					
			</div>	
</div>