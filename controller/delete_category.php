<?php
class delete_category extends ACore_Admin
{
	public function obr()
	{
		if ($_GET['del']) {
			$id_cat = (int)$_GET['del'];

			$query = "DELETE FROM category WHERE id_category='$id_cat'";

			if (mysqli_query($this->db, $query)) {
				$_SESSION['res'] = "Категория удалена";
				header("Location:?option=edit_category");
				exit();
			} else {
				exit("Ошибка удаления");
			}
		} else {
			exit("Не верные данные для этой страницы");
		}
	}

	public function get_content()
	{
	}
}
