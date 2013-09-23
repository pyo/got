<header>
	<div class="row">
		<div class="tweventyfour columns">
			<div align="center" style="margin-left:10px;margin-top:15px;">
				<script type="text/javascript" language="javascript" src="http://www2.glam.com/app/site/affiliate/viewChannelModule.act?mName=viewAdJs&affiliateId=348475431&adSize=970x66"></script>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="six columns">
			<div class="hide-text bg_h1_GoT"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></div>
		</div>
		<div class="eighteen columns">
			<div class="row">
				<div class="twentyfour columns">
					<?php get_template_part('/parts/shared/homepage/trending_topics'); ?>
				</div>
			</div>
			<div class="row">
				<div class="twentyfour columns">
					<?php get_template_part('/parts/shared/ads/header_banner_ad'); ?>
				</div>
			</div>
		</div>
	</div>
	<nav>
		<div class="row">
			<div class="twentyfour columns cf">
				<div class="got hide-text alignleft "><a href="<?php echo home_url('/'); ?>">GossipOnThis.com</a></div>

				<?php get_template_part('/parts/shared/header_navigation'); ?>
	
				<ul class="inline-block alignright no-list social-icons">
					<li><a class="facebook_icon" href="https://www.facebook.com/gossiponthis" target="_blank"></a></li><li>
						<a class="twitter_icon" href="https://twitter.com/GossipOnThis" target="_blank"></a></li><li>
						<a class="google_icon" href="https://plus.google.com/110561108536789001375/posts" target="_blank"></a></li><li>
						<a class="pinterest_icon" href="http://pinterest.com/gossiponthis/" target="_blank"></a></li><li>
						<a class="rss_icon" href="<?php echo home_url('/rssfeeds'); ?>" target="_blank"></a></li><li id="search_form">
							<?php get_search_form(); ?>
						</li><li class="search">
						<a class="search_icon" href="#"></a></li>
				</ul>
			</div>
		</div>	
	</nav>
</header>

<div role="main" id="main">