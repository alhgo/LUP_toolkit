<?php
$current = basename( $_SERVER[ 'PHP_SELF' ] );
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
				<li class="nav-item<?= ($current == 'index.php') ? ' active' : '' ?>">
					<a class="nav-link" href="<?= $site->url ?>"><i class="fa fa-home"></i>
					<?php if($current == 'index.php') : ?>
					<span class="sr-only">(current)</span>
					<?php endif ?>
              		</a>
				</li>
				<!--Array menu-->
				<?php if(isset($menu) && is_array($menu)) : ?>
				<?php foreach($menu AS $key => $val) : ?>
				<li class="nav-item<?= ($current == $val['page']) ? ' active' : '' ?>">
					<a class="nav-link" href="<?= $val['page'] ?>">
						<?= $val['text'] ?>
					</a>
				</li>
				<?php endforeach ?>
				<?php endif ?>
				<?php if(c::get('use.database')) : ?>
					<!--User menu-->
					<?php if(isset($user) && $user->logged) : ?>
						<!-- Dropdown -->
						<li class="nav-item dropdown">
							<a class="nav-link <?= ($current == 'user.php' ? 'active' : '') ?> dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" title="<?= $user->user_data['username'] ?>">
						<i class="fa fa-user"></i>
							</a>

							<div class="dropdown-menu">
								<a class="dropdown-item" href="user.php">Mis datos</a>
								<a class="dropdown-item" href="logout.php">Logout</a>
							</div>
						</li>
						<?php if($user->is_admin) : ?>
                        <!-- Admin link. Hide in smal devices -->
						<li class="nav-item<?= ($current == 'admin.php') ? ' active' : '' ?> d-sm-none d-md-block">
							<a class="nav-link" href="admin.php"><i class="fa fa-wrench"></i>
							<?php if($current == 'admin.php') : ?>
							<span class="sr-only">(current)</span>
							<?php endif ?>
							</a>
						</li>
                            <?php if(isset($sidebar) && is_array($sidebar)) : ?>
                            <!--Admin sidebar menu, show in small devices-->
                            <li class="nav-item dropdown d-sm-block d-md-none">
                                <a class="nav-link dropdown-toggle" href="#" id="smallerscreenmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fa fa-wrench"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="smallerscreenmenu">
                            <?php foreach($sidebar AS $key => $val) : ?>
                                    <a class="dropdown-item" href="<?= $val['page'] ?>"><?= $val['text'] ?></a>

                            <?php endforeach ?>
                                </div>
                            </li><!-- Smaller devices menu END -->
                            <?php endif ?>
                        

						<?php endif ?>

					<?php else : ?>
					<li class="nav-item">
						<a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
					</li>
					<?php endif ?>
					<!--End User Menu-->
				<?php endif ?>
                <li class="nav-item<?= ($current == 'contact.php') ? ' active' : '' ?>">
					<a class="nav-link" href="<?= $site->url . '/contact.php' ?>" title="Contactar"><i class="fa fa-envelope"></i>
					<?php if($current == 'contact.php') : ?>
					<span class="sr-only">(current)</span>
					<?php endif ?>
              		</a>
				</li>
			</ul>
		</div>
	</div>
</nav>