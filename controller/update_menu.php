<?php
class update_menu extends ACore_Admin {
	
	protected function obr() {
		
		$id = $_POST['id'];
		$title = $_POST['title'];
		$text = $_POST['text'];
		
		if(empty($title) || empty($text)) {
			exit("Не заполнены обязательные поля");
		}
		
		$query = "UPDATE  menu SET name_menu='$title',text_menu='$text' WHERE id_menu='$id'";
		if(!mysql_query($query)) {
			exit(mysql_error());
		}
		else {
			$_SESSION['res'] = "Изменения сохранены";
			header("Location:?option=edit_menu");
			exit;
		}			
	}
	
	public function get_content() {
	
		if($_GET['id_text']) {
			$id_text = (int)$_GET['id_text'];
		}
		else {
			exit('НЕ правильные данные для этой страницы');
		}
		
		$menu = $this->get_text_menu($id_text);
		echo "<div id='main'>";
		if (isset($_SESSION['res']) && !empty($_SESSION['res'])) {
			echo $_SESSION['res'];
			unset($_SESSION['res']);
		}
		$cat = $this->get_categories();
print <<<HEREDOC
<form action='' method='POST'>
<p>Заголовок меню:<br />
<input type='text' name='title' style='width:420px;' value='$menu[name_menu]'>
<input type='hidden' name='id' style='width:420px;' value='$menu[id_menu]'>
</p>
<p>Текст:<br />
<textarea name='text' cols='50' rows='7'>$menu[text_menu]</textarea>
</p>
<p><input type='submit' name='button' value='Сохранить'></p></form></div></div>
HEREDOC;
	}
}
?>