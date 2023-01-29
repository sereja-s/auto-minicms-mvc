<?php

class model
{

	protected $db;

	public function __construct()
	{
		$this->db = mysqli_connect(HOST, USER, PASSWORD);
		if (!$this->db) {
			exit("Ошибка соединения с базой данных" . mysqli_error($this->db));
		}
		if (!mysqli_select_db($this->db, DB,)) {
			exit("Нет такой базы данных" . mysqli_error($this->db));
		}
		mysqli_query($this->db, "SET NAMES 'UTF8'");
	}

	public function get_left_bar()
	{
		$query = "SELECT id_category,name_category FROM category";

		$result = mysqli_query($this->db, $query);
		if (!$result) {
			exit(mysqli_error($this->db));
		}

		for ($i = 0; $i < mysqli_num_rows($result); $i++) {
			$row[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
		}

		return $row;
	}

	public function menu_array()
	{
		$query = "SELECT id_menu,name_menu FROM menu";

		$result = mysqli_query($this->db, $query);
		if (!$result) {
			exit(mysqli_error($this->db));
		}

		$row = array();

		for ($i = 0; $i < mysqli_num_rows($result); $i++) {
			$row[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
		}
		return $row;
	}

	public function get_main_content()
	{

		$query = "SELECT id,title,discription,date,img_src FROM statti ORDER BY date DESC";
		$result = mysqli_query($this->db, $query);
		if (!$result) {
			exit(mysqli_error($this->db));
		}

		for ($i = 0; $i < mysqli_num_rows($result); $i++) {
			$row[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
		}

		return $row;
	}

	public function get_cat($id_cat)
	{

		$query = "SELECT id,title,discription,date,img_src
							FROM statti 
							WHERE cat='$id_cat' 
							ORDER BY date DESC";
		$result = mysqli_query($this->db, $query);
		if (!$result) {
			exit(mysqli_error($this->db));
		}

		$row = array();
		for ($i = 0; $i < mysqli_num_rows($result); $i++) {
			$row[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
		}
		return $row;
	}

	public function get_menu($id_menu)
	{
		$query = "SELECT id_menu,name_menu,text_menu FROM menu WHERE id_menu='$id_menu'";
		$result = mysqli_query($this->db, $query);
		if (!$result) {
			exit(mysqli_error($this->db));
		}
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}

	public function get_content_view()
	{
		if (!$_GET['id_text']) {
			echo 'Не правильные данные для вывода статьи';
		} else {
			$id_text = (int)$_GET['id_text'];
			if (!$id_text) {
				echo 'Не правильные данные для вывода статьи';
			} else {
				$query = "SELECT title,text,date,id,img_src FROM statti WHERE id='$id_text'";
				$result = mysqli_query($this->db, $query);
				if (!$result) {
					exit(mysqli_error($this->db));
				}
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				return $row;
			}
		}
	}

	/** 
	 * Метод обезопасит логин и пароль полученные методом POST со страницы авторизации и проверит есть ли такой пользователь Если есть, то перенаправит в админку
	 */
	public function get_clear_pass_and_log()
	{
		$login = strip_tags(mysqli_real_escape_string($this->db, $_POST['login']));
		$password = strip_tags(mysqli_real_escape_string($this->db, $_POST['password']));

		if (!empty($login) && !empty($password)) {
			$password = md5($password);

			$query = "SELECT id FROM users WHERE login='$login' AND password = '$password'";

			$result = mysqli_query($this->db, $query);

			if (!$result) {
				exit(mysqli_error($this->db)); //exit - выводит сообщение и прекращает выполнение текущего скрипта.
			}

			// проверим что пользователь с таким логином и паролем единственный
			if (mysqli_num_rows($result) == 1) {
				$_SESSION['user'] = true;
				// перенаправим пользователя на главную страницу админки
				header("Location:?option=admin");
				exit();
			} else {

				exit("Такого пользователя нет");
			}
		} else {

			exit("Заполните обязательные поля");
		}
	}
}
