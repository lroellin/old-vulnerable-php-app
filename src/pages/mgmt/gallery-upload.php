<?php $title = "Galerie"; ?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_upper.php") ?>
<?
	$accesslevel = User_Accesslevel::Administrator;
	
	if(dr_checkaccesslevel($accesslevel, $user_info))
	{	
		// Move it
		$dir = "/media/img/apps/gallery/";
		$dir = "{$_SERVER['DOCUMENT_ROOT']}{$dir}";
		$file = $_FILES['file'];
		$target = "{$dir}{$file['name']}";
		move_uploaded_file($file['tmp_name'], $target);

		// Insert into database
		$stmt = $db->prepare
		("
			INSERT INTO gallery_images (name, source, image)
			VALUES (:name, :source, :image);
		");
		$stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
		$stmt->bindValue(':source', $_POST['source'], PDO::PARAM_STR);
		$stmt->bindValue(':image', $file['name'], PDO::PARAM_STR);
		$stmt->execute();
		
		echo "Hochgeladen!";
	}
	else
	{
		dr_print_notpermitted("", "");
	}
?>
<?php require("{$_SERVER['DOCUMENT_ROOT']}/inc/template_lower.php"); ?>

