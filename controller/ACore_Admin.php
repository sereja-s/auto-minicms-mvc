<?php
abstract class ACore_Admin
{


	protected $db;

	public function __construct()
	{

		if (!$_SESSION['user']) {
			header("Location:?option=login");
		}

		$this->db = mysqli_connect(HOST, USER, PASSWORD);
		if (!$this->db) {
			exit("Ошибка соединения с базой данных" . mysqli_error($this->db));
		}
		if (!mysqli_select_db($this->db, DB,)) {
			exit("Нет такой базы данных" . mysqli_error($this->db));
		}
		mysqli_query($this->db, "SET NAMES 'UTF8'");
	}

	protected function get_header()
	{
		include "tpl/header.php";
	}

	protected function get_left_bar()
	{

		echo '<div class="quick-bg">
				<div id="spacer" style="margin-bottom:25px;">
					<div id="rc-bg">Разделы админки</div>
				</div>';

		echo "<div class='quick-links'>
					» <a href='?option=admin'>Статьи</a>
					</div>";

		echo "<div class='quick-links'>
					» <a href='?option=edit_menu'>Меню</a>
					</div>";
		echo "<div class='quick-links'>
					» <a href='?option=edit_category'>Категории</a>
					</div>";
		echo "</div>";
	}

	protected function get_menu()
	{

		echo '<div id="mainarea">
			<div class="heading"></div>';
	}

	protected function get_footer()
	{

		echo "<div id='bottom'>";
		$i = 1;
		echo '</div>
		            <div class="copy"><span class="style1"> Copyright 2023 | Сайт построен </span>

		</div>
	</div>
</center></body></html>';
	}


	public function get_body()
	{
		// по условию
		if ($_POST || (isset($_GET['del']) && !empty($_GET['del']))) {
			// запускается функция для обработки данных (здесь- форм), отправленных методом POST Метод описан в 
			// соответствующих классах админки(добавления, редактирования, удаления)
			$this->obr();
		}
		$this->get_header();
		$this->get_left_bar();
		$this->get_menu();
		$this->get_content();
		$this->get_footer();
	}

	abstract function get_content();

	/** 
	 * Метод получает все категории
	 */
	protected function get_categories()
	{
		$query = "SELECT id_category, name_category FROM category";

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

	/** 
	 * Метод получает необходимые данные статьи по идентификатору
	 */
	protected function get_text_statti($id)
	{
		$query = "SELECT id,title,img_src,discription,text,cat FROM statti WHERE id='$id'";

		$result = mysqli_query($this->db, $query);
		if (!$result) {
			exit(mysqli_error($this->db));
		}
		$row = array();
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		return $row;
	}

	protected function get_text_menu($id)
	{
		$query = "SELECT id_menu,name_menu,text_menu FROM menu WHERE id_menu = '$id'";
		$result = mysqli_query($this->db, $query);
		if (!$result) {
			exit(mysqli_error($this->db));
		}
		$row = array();
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}

	protected function get_text_category($id)
	{
		$query = "SELECT id_category,name_category FROM category WHERE id_category = '$id'";
		$result = mysqli_query($this->db, $query);
		if (!$result) {
			exit(mysqli_error($this->db));
		}
		$row = array();
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}
}
