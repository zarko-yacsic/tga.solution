<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Evaluaciones extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('user_agent');
        $this->load->library('spreadsheet_reader');
        $this->load->database('evaluaciones');
        $this->load->helper('cookie');
        session_start();
        date_default_timezone_set('UTC');
        $this->load->model('Tgasolutions');
        $this->Tgasolutions->usuario();
        $this->Tgasolutions->permisos();
    }


    public function listar_evaluaciones(){
        $sql = "SELECT idEvaluacion, idInmobiliaria, idProyecto, idTipoC, evaluacion, 
          if(fechaInicioCampo IS NULL, '', fechaInicioCampo) as fechaInicioCampo, 
          if(fechaFinCampo IS NULL, '', fechaFinCampo) as fechaFinCampo, 
          if(fechaEvaluacion IS NULL, '', fechaEvaluacion) as fechaEvaluacion FROM data_evaluaciones ORDER BY idEvaluacion ASC;";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        for($r = 0; $r < count($result); $r++){
            $result[$r]['fechaInicioCampo'] = $this->convertir_fecha($result[$r]['fechaInicioCampo'], 'leer_fecha');
            $result[$r]['fechaFinCampo'] = $this->convertir_fecha($result[$r]['fechaFinCampo'], 'leer_fecha');
            $result[$r]['fechaEvaluacion'] = $this->convertir_fecha($result[$r]['fechaEvaluacion'], 'leer_fecha');
            if($result[$r]['fechaInicioCampo'] == ''){ $result[$r]['fechaInicioCampo'] = '--';}
            if($result[$r]['fechaFinCampo'] == ''){ $result[$r]['fechaFinCampo'] = '--';}
            if($result[$r]['fechaEvaluacion'] == ''){ $result[$r]['fechaEvaluacion'] = '--';}
        }
        $data['result'] = $result;
        $this->load->view('productos/administrador_evaluaciones/evaluaciones/listar_evaluaciones', $data);
    }


    public function agregar_evaluacion(){
        $this->load->view('productos/administrador_evaluaciones/evaluaciones/form_agregar');
    }


    public function agregar_evaluacion_guardar(){
        $id_tipo_cuestionario = $_POST['hf_idTipoCuestionario'];
        $id_inmobiliaria = $_POST['hf_idInmobiliaria'];
        $id_proyecto = $_POST['id_proyecto'];
        $evaluacion = $_POST['evaluacion'];
        $sql = "INSERT INTO data_evaluaciones (idInmobiliaria, idProyecto, idTipoC, evaluacion, numColumna, avance, estado) ";
        $sql .= "VALUES (" . $id_inmobiliaria . ", " . $id_proyecto . ", " . $id_tipo_cuestionario . ", '" . $evaluacion . "', 0, 1, 2);";
        $result = $this->db->query($sql);
        if($result){
            $mensaje = 'Se ha guardado correctamente una nueva evaluación.';
            $status = 'SUCCESS';
        }
        else{
            $mensaje = 'Error al crear una nueva evaluación.';
            $status = 'ERROR';
        }
        $data = array('status' => $status, 'mensaje' => $mensaje);
        $output = json_encode($data);
        echo $output;
    }

    
    public function editar_evaluacion($id_evaluacion){
        $sql = "SELECT idEvaluacion, idInmobiliaria, idProyecto, idTipoC, evaluacion, 
          if(fechaInicioCampo IS NULL, '', fechaInicioCampo) as fechaInicioCampo, 
          if(fechaFinCampo IS NULL, '', fechaFinCampo) as fechaFinCampo, 
          if(fechaEvaluacion IS NULL, '', fechaEvaluacion) as fechaEvaluacion FROM data_evaluaciones WHERE idEvaluacion=" . $id_evaluacion . " LIMIT 1;";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        $data['fechaInicioCampo'] = $this->convertir_fecha($data['fechaInicioCampo'], 'leer_fecha');
        $data['fechaFinCampo'] = $this->convertir_fecha($data['fechaFinCampo'], 'leer_fecha');
        $data['fechaEvaluacion'] = $this->convertir_fecha($data['fechaEvaluacion'], 'leer_fecha');
        if(isset($data)){
            $this->load->view('productos/administrador_evaluaciones/evaluaciones/form_editar', $data);
        }
    }


    public function editar_evaluacion_guardar(){
        $id_tipo_cuestionario = $_POST['hf_idTipoCuestionario'];
        $id_inmobiliaria = $_POST['hf_idInmobiliaria'];
        $id_proyecto = $_POST['id_proyecto'];
        $id_evaluacion = $_POST['hf_idEvaluacion'];
        $evaluacion = $_POST['evaluacion'];
        $fecha_inicio = $this->convertir_fecha($_POST['fecha_inicio'], 'guardar_fecha');
        $fecha_fin = $this->convertir_fecha($_POST['fecha_fin'], 'guardar_fecha');
        $fecha_evaluacion = $this->convertir_fecha($_POST['fecha_evaluacion'], 'guardar_fecha');
        $sql = "UPDATE data_evaluaciones SET idInmobiliaria=" . $id_inmobiliaria . ", idProyecto=" . $id_proyecto . ", idTipoC=" . $id_tipo_cuestionario;
        $sql .= ", evaluacion='" . $evaluacion . "', fechaInicioCampo='" . $fecha_inicio . "', fechaFinCampo='" . $fecha_fin . "', fechaEvaluacion='";
        $sql .= $fecha_evaluacion . "' WHERE idEvaluacion=" . $id_evaluacion . " LIMIT 1;";
        $result = $this->db->query($sql);
        if($result){
            $mensaje = 'Se ha editado correctamente la evaluación seleccionada.';
            $status = 'SUCCESS';
        }
        else{
            $mensaje = 'Error al editar la evaluación seleccionada.';
            $status = 'ERROR';
        }
        $data = array('status' => $status, 'mensaje' => $mensaje);
        $output = json_encode($data);
        echo $output;
    }


    public function convertir_fecha($fecha, $accion){
        if($fecha != ''){
            if($accion == 'leer_fecha'){    /* 2018-12-31 ---> 31-12-2019 */
                $fecha = substr($fecha, 8, 2) . '-' . substr($fecha, 5, 2) . '-' . substr($fecha, 0, 4);
            }
            if($accion == 'guardar_fecha'){ /* 31-12-2019 ---> 2018-12-31 */
                $fecha = substr($fecha, 6, 4) . '-' . substr($fecha, 3, 2) . '-' . substr($fecha, 0, 2);
            }
        }
        if(($fecha == '00-00-0000') || (!isset($fecha))){
            $fecha = '';
        }
        return $fecha;
    }

}