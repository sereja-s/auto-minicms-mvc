<?php

class delete_statti extends ACore_Admin
{
	public function obr()
	{
		if ($_GET['del']) {
			$id_text = (int)$_GET['del'];

			$query = "DELETE FROM statti WHERE id='$id_text'";

			if (mysqli_query($this->db, $query)) {
				$_SESSION['res'] = "Статья удалена";
				header("Location:?option=admin");
				exit();
			} else {
				exit("Ошибка удаления страницы");
			}
		} else {
			exit("Не верные данные для этой страницы");
		}
	}

	public function get_content()
	{
		if (!empty($_POST)) {

			$this->obr();
		}
	}
}
