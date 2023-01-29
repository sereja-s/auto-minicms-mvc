<?php

class login extends ACore
{

	protected function obr()
	{
		$res = $this->m->get_clear_pass_and_log();
		return $res;
	}



	public function get_content()
	{
	}
}
