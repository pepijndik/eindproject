<html lang="en"><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Camping La Rustique | Nieuws | <?php echo $new['id']?></title>
	<!--Font awsome css-->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/public/fontawesome.css') ?>"> 
	<link rel="icon" type="image/png" href="<?php echo base_url('assets/images/favicon.png') ?>">
	<!--Main style css-->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/public/main.css') ?>"> 
	<!--Responsive style css-->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/public/responsive.css') ?>"> 
</head>
<body data-gr-c-s-loaded="true">
	<!-- main navigation mobile -->
	<div class="main_nav_mobile" id="topNavMobile">
		<div class="main_nav_mobile_inner">
			<div class="navbar_nav_over_wrapp">
				<ul class="navbar-nav">
					<li><a href="/camping_systeem">Home</a></li>
					<li><a href="/camping_systeem#over_ons">Over de camping</a></li>
					<li class="has-child">
							<a href="services-category.html">Onze voorzieningen</a>
							<ul class="sub-menu">
								<li><a href="/public/voorzieningen#sanitair">sanitair</a></li>
								<li><a href="/public/voorzieningen#staanplaatsen">staan plaatsen</a></li>
								<li class="has-child">
									<a href="#">Account</a>
									<ul class="sub-menu">
										<li><a href="#">Test item</a></li>
										<li><a href="#">Test item</a></li>
									</ul>
								</li>
						
							</ul>
						</li>
						<li >
							<a href="/camping_systeem#reseveren">Reseveren</a>
							
						</li>
						<li><a href="/camping_systeem#fotos">Foto´s</a></li>
					
						
				</ul>
			</div>
			<button class="close_mobile_menu" type="button" data-target="#topNavMobile">
				<span class="navbar-toggler-icon"><i class="fas fa-times"></i></span>
			</button>
		</div>
		<div class="cover_mobile_menu" data-target="#topNavMobile"></div>
	</div>
	<!-- END main navigation mobile -->

	<!-- main header -->
	<header class="main_header fixed_header transparen_bg_head">
		<div class="container clearfix">
			<div class="logo_head">
				<a href="index.html"><img src="<?php echo base_url('assets/images/public/logo_head.png') ?>" alt=""></a>
			</div>
			<div class="navbar-expand-lg nav_btn_toggle">
				<button class="navbar-toggler open_mobile_menu" type="button" data-target="#topNavMobile">
					<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
				</button>
			</div>
			<nav class="top_nav_links navbar navbar-expand-lg">
				<div class="collapse navbar-collapse" id="topNav">
					<ul class="navbar-nav mr-auto">
						<li><a href="/camping_systeem">Home</a></li>
						<li><a href="/camping_systeem#over_ons">Over de camping</a></li>
						<li class="has-child">
							<a href="services-category.html">Onze voorzieningen</a>
							<ul class="sub-menu">
								<li><a href="/public/voorzieningen#sanitair">sanitair</a></li>
								<li><a href="/public/voorzieningen#staanplaatsen">staan plaatsen</a></li>
								<li class="has-child">
									<a href="#">Account</a>
									<ul class="sub-menu">
										<li><a href="#">Test item</a></li>
										<li><a href="#">Test item</a></li>
									</ul>
								</li>
						
							</ul>
						</li>
						<li class="has-child">
							<a href="/camping_systeem#reseveren">Reseveren</a>
							
						</li>
						<li><a href="/camping_systeem#fotos">Foto´s</a></li>
					
						
					</ul>
				</div>
			</nav>
		</div>
	</header><!--END main header -->
	<!--Page headet title-->
	<div class="header_title pade_bg6 d-flex justify_content_center align_items_center bg_overlay1">
		<div class="container">
			<h1 class="page_title">Nieuws pagina</h1>
			<ul class="page-list">
				<li><a href="index.html">Home</a></li>
				<li>-</li>
				<li><a href="news-category.html">Nieuws</a></li>
				<li>-</li>
				<li><?php echo $new['title']?></li>
			</ul>
		</div>
	</div><!--END Page headet title-->
	
	
	<!--type page wrapper-->
	<div class="type_page_wrapper section_padding_60_60">

		<!--Start container-->
		<div class="container">
		
			<div class="row">
			
				<div class="col-xs-12 col-md-12 col-lg-8">
					
					<div class="post_preview_image">				
						<a href="assets/images/newsbg.jpg" class="see_big_pic hover_link_effect">
							<i class="fas fa-search"></i>
							<img src="assets/images/newsbg.jpg" alt="">
						</a>
					</div>	
					
					<div class="item_content">

						<h2 class="entry-title"><?php echo $new['title']?></h2>

						<p>
							<?php echo $new['beschrijving']?></p>
						<br>
		
						<br>
						<blockquote>
							Dit nieuws articel is fake.
						</blockquote>
						<br>

					</div>
					
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
					<div class="sidebar_right">
						<!-- sidebar-block -->
						<div class="sidebar_block light_area">
							<div class="widget_recent_post">
								<h4 class="widget_title">Ander nieuws</h4>
								
								<ul>

                                <?php 
                                foreach($other_news as $news){
                                    ?>
                                    <li>
										<div class="post_thumb">
											<a href="<?php echo $news['post_url']?>" class="hover_link_effect">
												<i class="fas fa-ellipsis-h"></i>
												<img src="assets/images/news2.jpg" alt="">
											</a>
										</div>
										<div class="post_date"><i class="far fa-calendar-alt"></i><?php echo $news['datum']?></div>
										<h6 class="post_name"><a href="single-team.html"><?php echo $news['title']?></a></h6>
										
									</li>
							
                                    <?php
                                }
                                ?>
								
								</ul>
								
							</div>
						</div><!-- END sidebar-block -->
						
						<!-- sidebar-block -->
						<div class="sidebar_block light_area">
							<div class="widget_tag">
								<h4 class="widget_title">Nieuws tags</h4>
								<a href="#">Camping</a>
								<a href="#">Fishing</a>
								<a href="#">Cycling</a>
								<a href="#">Kayaking</a>
								<a href="#">Fishing</a>
								<a href="#">Photo</a>
								<a href="#">Modern</a>
								<a href="#">Fresh</a>
								<a href="#">Responsive</a>
								<a href="#">Forest</a>
								<a href="#">House In the Woods</a>
							</div>
						</div><!-- END sidebar-block -->
						
					</div>
				</div>
				
			</div>
	
			
		</div><!--END Start container-->
		
	</div><!--END type page wrapper-->

<!-- subscribe_line -->
<div class="subscribe_line">
		<div class="container">
			<div class="row">
				<div class="col-md-12 d-flex bg_img align_items_center">
					<h2 class="subscribe_title">
						Camping La <span class="col_filed_yel">Rastique</span>
					</h2>
				</div>
			
			</div>
		</div>
	</div><!-- END subscribe_line -->
	<!-- main_footer -->
	<footer class="main_footer">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-3 footer_block">
					<a href="index.html"><img src="assets/images/footer_logo.png" alt=""></a>
					<p class="copy">
						Copyrights 2020,<br>
						Pdik systems <br>
						Alle rechten gereseveerd
					</p>
				</div>
				<div class="col-md-6 col-lg-3 footer_block">
						<h6 class="footer_block_title">Over ons</h6>
						<p>Lorem Ipsum is simply dummy<br>
						text of the printing and<br>
						typesetting industry.</p>
				</div>
				<div class="col-md-6 col-lg-3 footer_block">
						<h6 class="footer_block_title">Neem contact op</h6>
						<p>1600 Amphitheatre Parkway<br>
						Mountain View, CA 94043<br>
						Phone: +1 650-253-0000</p>
				</div>
				<div class="col-md-6 col-lg-3 footer_block">
					<div class="social_wg">
						<h6 class="footer_block_title">Sociale media</h6>
						<p><a href="#"><i class="fab fa-twitter-square"></i></a>
						<a href="#"><i class="fab fa-facebook-square"></i></a>
						<a href="#"><i class="fab fa-youtube"></i></a>
						<a href="#"><i class="fab fa-instagram"></i></a></p>
					</div>
				</div>
			</div>
		</div>
	</footer><!-- END main_footer -->
	
	<!-- JS -->
	<!--jQuery 1.12.4 google link-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!--Bootstrap 4.1.0-->
	<script src="<?php echo base_url('assets/js/bootstrap_4.1.0.js') ?>"></script>
	<!--shuffle-->
	<script src="<?php echo base_url('assets/js/shuffle.min.js') ?>"></script>
	<!--jquery.magnific-popup-->
	<script src="<?php echo base_url('assets/js/magnific_popup.js') ?>"></script>
	<!--OwlCarousel2-2.3.4-->
	<script src="<?php echo base_url('assets/js/owl_carousel.js')?>"></script>
	<!--Custom js-->
	<script src="<?php echo base_url('assets/js/camping.js') ?>"></script>

</body></html>