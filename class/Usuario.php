<?php 

class Usuario {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function getIdusuario():int
	{
		return $this->idusuario;
	}

	public function getDeslogin():string
	{
		return $this->deslogin;
	}

	public function getDessenha():string
	{
		return $this->dessenha;
	}

	public function getDtcadastro()
	{
		return $this->dtcadastro;
	}

	public function setIdusuario($arg)
	{
		$this->idusuario = $arg;
	}

	public function setDeslogin($arg)
	{
		$this->deslogin = $arg;
	}

	public function setDessenha($arg)
	{
		$this->dessenha = $arg;
	}

	public function setDtcadastro($arg)
	{
		$this->dtcadastro = $arg;
	}

	public function loadById($id)
	{
		$sql = new Sql();

		$data = array(":ID" => $id);
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", $data);

		if (count($results) > 0) {
			$row = $results[0];

			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			$this->setDtcadastro(new DateTime($row['dtcadastro']));
		}
	}

	public function __toString()
	{
		return json_encode(array(
			'idusuario' 	=> 	$this->getIdusuario(),
			'deslogin' 		=> 	$this->getDeslogin(),
			'dessenha' 		=> 	$this->getDessenha(),
			'dtcadastro' 	=>  $this->getDtcadastro()->format("d/m/Y H:i")
		));
	}
}

?>