<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/configuration/conf.php";
$region = $config["region"];
$realmName = $config["realm"];
$guildName = $config["guild"];
?>
<nav class="navbar-default navbar-fixed-top">
	<div class="container">
		<div class="row">
			<div class="col-xs-6">
				<a class="navbar-brand" href="/">Psyala Guild Tracker</a>
			</div>
			<div class="col-xs-6 h4 current-view">
				Currently Viewing <?php echo $guildName . "@" . $realmName; ?>
			</div>
		</div>
		<div id="navigation" class="container-fluid">
			<div class="container">
				<div id="navbar">
					<ul class="nav navbar-nav">
						<li><a href="/">Class Overview</a></li>
						<li><a href="/html/pages/detail.php">Member Detail</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</nav>