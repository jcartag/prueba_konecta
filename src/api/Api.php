<?php

//Api.php

class API
{
	private $connect = '';

	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=prueba_konecta", "root", "");
		
	}

	function fetch_all()
	{
		$query = "SELECT * FROM productos ORDER BY id";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function insert()
	{
		if(isset($_POST["nombre"]))
		{
			$form_data = array(
				':nombre'		=>	$_POST["nombre"],
				':referencia'		=>	$_POST["referencia"],
				':precio'		=>	$_POST["precio"],
				':peso'		=>	$_POST["peso"],
				':categoria'		=>	$_POST["categoria"],
				':stock'		=>	$_POST["stock"],
				':fecha_inicial'		=>	$_POST["fecha_inicial"],
				':fecha_final'		=>	$_POST["fecha_final"]
			);
			$query = "
			INSERT INTO productos 
			(nombre, referencia, precio, peso, categoria, stock, fecha_inicial, fecha_final) VALUES 
			(:nombre, :referencia, :precio, :peso, :categoria, :stock, :fecha_inicial, :fecha_final)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}

	function fetch_single($id)
	{
		$query = "SELECT * FROM productos WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$data['nombre'] = $row['nombre'];
				$data['referencia'] = $row['referencia'];
				$data['precio'] = $row['precio'];
				$data['peso'] = $row['peso'];
				$data['categoria'] = $row['categoria'];
				$data['stock'] = $row['stock'];
				$data['fecha_inicial'] = $row['fecha_inicial'];
				$data['fecha_final'] = $row['fecha_final'];
			}
			return $data;
		}
	}

	function update()
	{
		if(isset($_POST["id"]))
		{
			$form_data = array(
				':nombre'	=>	$_POST['nombre'],
				':referencia'	=>	$_POST['referencia'],
				':precio'	=>	$_POST['precio'],
				':peso'	=>	$_POST['peso'],
				':categoria'	=>	$_POST['categoria'],
				':stock'	=>	$_POST['stock'],
				':fecha_inicial'	=>	$_POST['fecha_inicial'],
				':fecha_final'	=>	$_POST['fecha_final'],
				':id'			=>	$_POST['id']
			);
			$query = "
			UPDATE productos
			SET nombre = :nombre, referencia = :referencia, precio = :precio, peso = :peso,
			categoria = :categoria, stock = :stock, fecha_inicial = :fecha_inicial, fecha_final = :fecha_final, 
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
	function delete($id)
	{
		$query = "DELETE FROM productos WHERE id = '".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
}

?>