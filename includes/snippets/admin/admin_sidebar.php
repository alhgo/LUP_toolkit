<?php
//https://www.codeply.com/go/LFd2SEMECH

?>

	<!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-md-block"><!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group">
      
            <a href="#" data-toggle="sidebar-colapse" class="bg-dark list-group-item list-group-item-action d-flex align-items-center">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span id="collapse-icon" class="fa fa-2x mr-3"></span>
                    <span id="collapse-text" class="menu-collapsed">Cerrar</span>
                </div>
            </a>

            <!--Sidebar menu-->
            
            <?php if(isset($sidebar) && is_array($sidebar)) : ?>
				<?php foreach($sidebar AS $key => $val) : ?>
				
					<?php if(isset($val['submenu']) && is_array($val['submenu'])) : ?>
					
					<!--Submenus-->
					<a href="#submenu<?= $key ?>" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
						<div class="d-flex w-100 justify-content-start align-items-center">
							<span class="fa fa-<?= $val['icon'] ?> fa-fw mr-3"></span> 
							<span class="menu-collapsed"><?= $val['text'] ?></span>
							<span class="submenu-icon ml-auto"></span>
						</div>
					</a>
					
					<!-- Submenu content -->
					<div id='submenu<?= $key ?>' class="collapse sidebar-submenu">
						<?php foreach($val['submenu'] AS $sub) : ?>
						<a href="<?= create_link($sub) ?>" class="list-group-item list-group-item-action bg-dark text-white">
							<span class="menu-collapsed"><?= $sub['text'] ?></span>
						</a>
						<?php endforeach ?>
					</div>


					<?php else : ?>
					<a href="<?= create_link($val) ?>" class="bg-dark list-group-item list-group-item-action">
						<div class="d-flex w-100 justify-content-start align-items-center">
							<span class="fa fa-<?= $val['icon'] ?> fa-fw mr-3"></span>
							<span class="menu-collapsed">
								<?= $val['text'] ?>
							</span>   

						</div>
					</a>
					<?php endif ?>

				<?php endforeach ?>
            <?php endif ?>
            <!--End Sidebar menu-->
			<p ></p>
  
        </ul><!-- List Group END-->
		
		<!--SIDE BAR MARKS -->
		<ul id="side_bar">
			
		</ul>
		
    </div><!-- sidebar-container END -->