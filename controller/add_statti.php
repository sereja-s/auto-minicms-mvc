<?php

class add_statti extends ACore_Admin
{

    protected function obr()
    {

        if (!empty($_FILES['img_src']['tmp_name'])) {
            if (!move_uploaded_file($_FILES['img_src']['tmp_name'], 'file/' . $_FILES['img_src']['name'])) {
                exit("Не удалось загрузить изображение");
            }
            $img_src = 'file/' . $_FILES['img_src']['name'];
        } else {
            exit("Необходимо загрузить изображение");
        }

        $title = $_POST['title'];
        $date = date("Y-m-d", time());
        $discription = $_POST['discription'];
        $text = $_POST['text'];
        $cat = $_POST['cat'];

        if (empty($title) || empty($text) || empty($discription)) {
            exit("Не заполнены обязательные поля");
        }

        $query = " INSERT INTO statti
						(title,img_src,date,text,discription,cat)
					VALUES ('$title','$img_src','$date','$text','$discription','$cat')";
        if (!mysqli_query($this->db, $query)) {
            exit(mysqli_error($this->db));
        } else {
            $_SESSION['res'] = "Изменения сохранены";
            header("Location:?option=add_statti");
            exit;
        }
    }

    public function get_content()
    {
        if (!empty($_POST)) {
            $this->obr();
        }
        echo "<div id='main'>";
        if (isset($_SESSION['res']) && !empty($_SESSION['res'])) {
            echo $_SESSION['res'];
            unset($_SESSION['res']);
        }
        $cat = $this->get_categories();
        print <<<HEREDOC
<form enctype='multipart/form-data' action='' method='POST'>
<p>Заголовок статьи:<br />
<input type='text' name='title' style='width:420px;'>
</p>
<p>Изображение:<br />
<input type='file' name='img_src'>
</p>
<p>Краткое описание:<br />
<textarea name='discription' cols='50' rows='7'></textarea>
</p>
<p>Текст:<br />
<textarea name='text' cols='50' rows='7'></textarea>
</p>
<select name='cat'>
HEREDOC;
        foreach ($cat as $item) {
            echo "<option value='" . $item['id_category'] . "'>" . $item['name_category'] . "</option>";
        }
        echo "</select><p><input type='submit' name='button' value='Сохраниться'></p></form></div>
			</div>";
    }
}
