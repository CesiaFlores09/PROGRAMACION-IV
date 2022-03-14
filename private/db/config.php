<?php
class  DB{
    private $conexion, $result;

    public function DB($server, $user, $pass){
        $this->conxion = new PDO($server, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES => false,
           PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)) or die('Error al conectar con la base de datos');
    
    }
    public function consultas($sql =''){
        try{
            $parametros= func_get_args();
            array_shift($parametros);
            $this->preparado = $this->conxion->prepare($sql);
            $this->result = $this->preparado->execute($parametros);

        }catch(PDOException $e){
            echo 'Error '.$e->getMessage();

        }

    }
    public function obtener_datos(){
        return $this->preparado->fetchAll(PDO::FETCH_ASSOC);

    }
    public function obtener_respuestas(){
        return $this->result;
    }
    public function obtener_UltimoId(){
        return $this->conxion->lasInsertId();
    }
}
?>
