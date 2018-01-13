<?php 

class Usuario {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function __construct($user = "", $pass = "")
	{
		$this->setDeslogin($user);
		$this->setDessenha($pass);
	}

	public function getIdusuario():int {
		return $this->idusuario;
	}

	public function getDeslogin():string {
		return $this->deslogin;
	}

	public function getDessenha():string {
		return $this->dessenha;
	}

	public function getDtcadastro() {
		return $this->dtcadastro;
	}

	public function setIdusuario($arg) {
		$this->idusuario = $arg;
	}

	public function setDeslogin($arg) {
		$this->deslogin = $arg;
	}

	public function setDessenha($arg) {
		$this->dessenha = $arg;
	}

	public function setDtcadastro($arg) {
		$this->dtcadastro = $arg;
	}

	public function login($login, $password) {
		$sql = new Sql();

		$data = array(":LOGIN" => $login, ":PASS" => $password);
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASS", $data);

		if (count($results) > 0) {
			$row = $results[0];

			$this->setData($row);
		} else {
			throw new Exception("Login e/ou senha inválidos.");
		}
	}

	public function loadById($id) {
		$sql = new Sql();

		$data = array(":ID" => $id);
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", $data);

		if (count($results) > 0) {
			$row = $results[0];

			$this->setData($row);

		}
	}

	private function setData($data) {

		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));
	}

	public function insert() {
		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN' => $this->getDeslogin(),
			':PASSWORD' => $this->getDessenha()
		));

		if (count($results) > 0)
		{
			$this->setData($results[0]);
		}
	}

	public function update() {

		$sql = new Sql();

		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			":LOGIN" => $this->getDeslogin(),
			":PASSWORD" => $this->getDessenha(),
			":ID" => $this->getIdusuario()
		));
	}

	public function delete() {
		$sql = new Sql();

		$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
			':ID' => $this->getIdusuario()
		));

		$this->setIdusuario(0);
		$this->setDeslogin("");
		$this->setDessenha("");
		$this->setDtcadastro(new DateTime());
	}

	public static function getList():array {
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
	}

	public static function search($login) {
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :QUERY ORDER BY deslogin", array(
			":QUERY" => "%$login%"
		));
	}

	public function __toString() {
		return json_encode(array(
			'idusuario' 	=> 	$this->getIdusuario(),
			'deslogin' 		=> 	$this->getDeslogin(),
			'dessenha' 		=> 	$this->getDessenha(),
			'dtcadastro' 	=>  $this->getDtcadastro()->format("d/m/Y H:i")
		));
	}
}

?>