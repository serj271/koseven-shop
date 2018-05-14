<div id='result' >
    <table>
<?php if($files->count() ===0) : ?>
	<tr colspan="4">Uploads not found</tr>
<?php else : ?> 
    <?php foreach($files as $file) : ?>
	<tr>
	    <td><td>
	    <td><td>
	    <td><?php Text::bytes($files->size) ?><td>
	    <td><?php HTML::chars($files->description)  ?><td>

	</tr>

    <?php endforeach; ?>
<?php endif; ?>

    </table>

</div>