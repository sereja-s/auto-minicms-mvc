<?php
class view extends ACore
{

    public function get_content()
    {
        $result = $this->m->get_content_view();
        return $result;
    }
}

?>