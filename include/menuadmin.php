<tr>
	<td>Administrador:</td>
	<td><input type="radio" name="admini" class="chkbox" value="No" <?php echo ($admini == 'No') ?  "checked" : ""; ?> />No <br>
		<input type="radio" name="admini" class="chkbox" value="Si" <?php echo ($admini == 'Si') ?  "checked" : ""; ?> />Si</td>
</tr>
<tr>
	<td>Estado:</td>
	<td><input type="radio" name="desha" class="chkbox" value="No" <?php echo ($estado == 'No') ?  "checked" : ""; ?> />Deshabilitado <br>
		<input type="radio" name="desha" class="chkbox" value="Si" <?php echo ($estado == 'Si') ?  "checked" : ""; ?> />Habilitado</td>
</tr>
<tr>
	<td>Huella:</td>
	<td><input name="huella" value="<?php echo $huella; ?>"></td>
</tr>
<tr>
	<td>Añadido en: <?php echo $row['fecha']; ?></td>
</tr>
<tr>
	<td style="font-weight: bold;">Si se elimina se borran todos los registros.</td>
	<td style="
align-items: left;
text-align: end;
">
		<a href="delete_task.php?id=<?php echo $row['id'] ?>" style="background-color: transparent; 
border-color:transparent;color: red; padding:1rem; border-radius: 12px 12px 12px 12px;">
			<img style="width: 5rem;" class="icons" src="../img/Trash.svg" alt="">
		</a>
	</td>
</tr>