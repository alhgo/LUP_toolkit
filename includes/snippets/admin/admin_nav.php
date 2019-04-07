<?php
//$current = basename( $_SERVER[ 'PHP_SELF' ] );
$action = (isset($_GET['action'])) ? $_GET['action'] : '';
//Comprobamos que se le ha pasado un menú



?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<div class="container">
		<!--title/logo-->
		<a class="navbar-brand pt-0 pb-0" href="<?= $site->url ?>">
		<?php if(is_file(__DIR__ . '/../../images/logo_top.png')) : ?>
		<img src="<?= $site->url ?>images/logo_top.png" alt="<?= $site->title ?>" title="<?= $site->title ?>" height="42">
		<?php else : ?>
		<?= $site->title ?>
		<?php endif ?>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
		
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="<?= $site->url ?>" target="_blank"><i class="fa fa-external-link"></i>
              		</a>
				</li>
				<!--Array menu. Si se ha pasado un menú específico-->
				<?php if(isset($menu) && is_array($menu)) : ?>
					<?php foreach($menu AS $key => $val) : ?>
					<li class="nav-item<?= ($action == $val['action']) ? ' active' : '' ?>">
						<a class="nav-link" href="<?= create_link($val) ?>">
							<?= $val['text'] ?>
						</a>
					</li>
					<?php endforeach ?>
				<?php endif ?>
				
				<!-- Admin link. Hide in smal devices -->
					<li class="nav-item<?= ($action == '') ? ' active' : '' ?> d-none d-sm-none d-md-block">
						<a class="nav-link" href="admin.php"><i class="fa fa-home"></i>
						<?php if($action == '') : ?>
						<span class="sr-only">(current)</span>
						<?php endif ?>
						</a>
					</li>
				
				
				<?php if(isset($sidebar) && is_array($sidebar)) : ?>
				<!--Admin sidebar menu, show in small devices-->
				<?php foreach($sidebar AS $key => $val) : ?>
				

				  <?php if(isset($val['submenu']) && is_array($val['submenu'])) : ?>
				  <!--Submenú-->	
				  <li class="nav-item dropdown d-sm-block d-md-none">
					<a class="nav-link dropdown-toggle" href="#" id="smallerscreenmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-<?= $val['icon'] ?>"> </i>
					  <?= $val['text'] ?>
					</a>
					<div class="dropdown-menu" aria-labelledby="smallerscreenmenu">
						<?php foreach($val['submenu'] AS $sub) : ?>
						<a class="dropdown-item" href="<?= create_link($sub) ?>"><?= $sub['text'] ?></a>
						<?php endforeach ?>
					</div>
				  </li>
				
				  <?php else : ?>
				

					<li class="nav-item d-sm-block d-md-none">
						<a class="nav-link" href="<?= create_link($val) ?>">
						  <i class="fa fa-<?= $val['icon'] ?>"> </i> <?= $val['text'] ?>
							<?php if($action == $val['action']) : ?>
							<span class="sr-only">(current)</span>
							<?php endif ?>
						</a>
					</li>
				  <?php endif ?>
				<?php endforeach ?>
				<?php endif ?>
				

			</ul>
		</div>
	</div>
</nav>