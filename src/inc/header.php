<!-- Header -->
<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-header">
			<span class="sr-only">Menü einblenden</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="/"><i class="fa fa-home"></i> Dreamis Webseite</a>
	</div>

	<div class="collapse navbar-collapse" id="navbar-header">
		<ul class="nav navbar-nav">
			<li><a href='/about/'><i class=" fa fa-male"></i> Über mich</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-code"></i> IT<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href='/it/software/'><i class="fa fa-hdd-o fa-fw"></i> Software</a></li>
					<li><a href='/it/systems/'><i class="fa fa-desktop fa-fw"></i> Systeme</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-terminal"></i> Apps<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href='/apps/dell-converter/'><i class="fa fa-exchange fa-fw"></i> Dell-Konverter</a></li>
					<li><a href='/apps/ip/'><i class="fa fa-info fa-fw"></i> IP</a></li>
					<li><a href='/apps/gallery/'><i class="fa fa-picture-o fa-fw"></i> Galerie</a></li>
					<li><a href='/apps/mac-lookup/'><i class="fa fa-barcode fa-fw"></i> MAC-Adresse &rarr; Hersteller</a></li>
					<li><a href='/apps/shuffle/'><i class="fa fa-random fa-fw"></i> Mischen</a></li>
					<li><a href='/apps/generate-password/'><i class="fa fa-credit-card fa-fw"></i> Passwort generieren</a></li>
					<li><a href='/apps/port-lookup/'><i class="fa fa-list-ol fa-fw"></i> Port &rarr; Dienst</a></li>
					<li><a href='/apps/unixtime/'><i class="fa fa-clock-o fa-fw"></i> Unixzeit</a></li>
					<li><a href='/apps/encrypt-decrypt/'><i class="fa fa-key fa-fw"></i> Ver- & Entschlüsselung</a></li>
					<li><a href='/apps/webpage-down/'><i class="fa fa-moon-o fa-fw"></i> Webseite ereichbar?</a></li>
					<li><a href='/apps/alarm/'><i class="fa fa-sun-o fa-fw"></i> Wecker</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gamepad"></i> Games<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href='/games/pairs/new'><i class="fa fa-puzzle-piece fa-fw"></i> Gedächtnisspiel</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-compass"></i> Im Internet<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href='//www.facebook.com/lukas.rollin.5' target='facebook'><i class="fa fa-facebook fa-fw"></i> Facebook</a></li>
					<li><a href='http://www.forumla.de/u2254/dreami/' target='forumla'><i class="fa fa-comments fa-fw"></i> Forumla</a></li>
					<li><a href='//plus.google.com/101050751786712497858?rel=author' target='google-plus'><i class="fa fa-google-plus fa-fw"></i> Google+</a></li>
					<li><a href='//stackexchange.com/users/3090072/dreami' target='stackexchange'><i class="fa fa-stack-exchange fa-fw"></i> StackExchange</a></li>
					<li><a href='//twitter.com/Dreamwalkerli' target='twitter'><i class="fa fa-twitter fa-fw"></i> Twitter</a></li>
				</ul>
			</li>
			<li><a href='http://blog.dreami.ch' target='blog'><i class="fa fa-comment"></i> Blog</a></li>
			<?
			if($user_accesslevel >= User_Accesslevel::Administrator)
			{
				echo "<li class='dropdown'>";
				echo "<a class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-cogs'></i> Verwaltung <b class='caret'></b></a>";
				echo "<ul class='dropdown-menu'>";
					echo "<li><a href='/mgmt/user'><i class='fa fa-user fa-fw'></i> Benutzer</a></li>";
					echo "<li><a href='/mgmt/gallery-read'><i class='fa fa-picture-o fa-fw'></i> Galerie</a></li>";
				echo "</ul>";
				echo "</li>";
			}
			?>
		</ul>
		
		<ul class="nav navbar-nav navbar-right">
		<?
		if($user_accesslevel >= User_Accesslevel::Registered)
		{
			echo "<li><span class='navbar-text'>Hallo, <a class='navbar-link' href='/user/profile'><strong>{$user_info['name']}</strong></a></span></li>";
			echo "<li><a href='/user/logoff' target='_self'><i class='fa fa-sign-out'></i> Abmelden</a></li>";
		}
		else
		{
			echo "<li><a href='/user/register'><i class='fa fa-fw fa-user'></i> Registrieren</a></li>";
			echo "<li><a href='/user/login'><i class='fa fa-fw fa-sign-in'></i> Anmelden</a></li>";
		}
		?>
		</ul>
	</div>
</nav>
