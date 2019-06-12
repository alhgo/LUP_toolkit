<?php
$nl = new Newsletter;

$newsletters = $nl->getNewsletters();

$user = new Users;
$user_cats = $user->getUsersType();
$user_cats[0] = "Sin definir";

?>

<h3>Newsletter creados</h3>
<hr>
<p>Listado de newsletter creados y su estado</p>
<div style="padding-bottom: 70px">
<table id="users_table" class="table table-striped table-bordered table-sm " style="width:100%">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Título</th>
                <th>Dest.</th>
				<th>Enviados</th>
				<th></th>
				<th></th>
				<th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($newsletters AS $newsletter) : ?>
			
			<?php
			
			//Obtenemos los datos denl enviados
			$sent = $nl->getNewsletterSent($newsletter['id_nl']);
			
			//Categorías enviadas
			if($newsletter['id_cats'] == NULL)
			{
				$cats = "Administradores";
			}
			else
			{
				$cats = '';
				$cats_array = explode( ',', $newsletter['id_cats']);
				$names_array = [];
				foreach($cats_array AS $cat)
				{
					if($cat == 0 || $cat == NULL)
					{
						$names_array[] = 'Sin definir';
					}
					else
					{
						$names_array[] = $user_cats[$cat]['name'];
					}
					
				}
				$cats = implode($names_array,', ');
			}
			
			$style = '';
			/*
			if($user['admin'] == 1)
			{
				$style = 'class="table-danger"';
			}
			*/
			?>
			<tr <?= $style ?>>
				<td><?= date('d/m/Y',$newsletter['time']) ?></td>
				<td><?= $newsletter['title'] ?></td>
				<td><?= $cats ?></td>
				<td><?= $sent['sent'] . " de " . $sent['dest'] ?></td>
				<td><a href="newsletter.php?id=<?= $newsletter['id_nl'] ?>" target="_blank"><i class="fa fa-eye"></i></a></td>
				<td align="center"><a href="admin.php?action=newsletter&sub=send&id=<?= $newsletter['id_nl'] ?>" class="no-underline" title="enviar"><i class="fa fa-paper-plane"></i></td>
				<td align="center"><a onclick="return confirm('¿Seguro que desea borrar el newsletter con ID <?= $newsletter['id_nl'] ?>?')" href="admin.php?action=newsletter&sub=delete&id=<?= $newsletter['id_nl'] ?>" class="no-underline"><i class="fa fa-trash"></i></a></td>
			</tr>
		<?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Fecha</th>
                <th>Título</th>
                <th>Dest.</th>
				<th>Enviados</th>
				<th></th>
				<th></th>
            </tr>
        </tfoot>
    </table>
</div>
<p align="center"><a href="admin.php?action=newsletter&sub=newsletter_create" type="button" class="btn btn-primary">Crear newsletter</a></p>
<p></p>
<p></p>
