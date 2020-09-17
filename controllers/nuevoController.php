<?php 

class Nuevo extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->mensaje = ""; //Mensaje para para mostrar an Views
    }

    function render() {
        $this->view->render('nuevo/index');

    }

    function sendMail() {
        $attach = [];

        isset($_POST['inpTo']) ? $to = $_POST['inpTo'] : $to = "";
        isset($_POST['inpSubject']) ? $subject = $_POST['inpSubject'] : $subject = "";

        // isset($_POST['txaBody']) ? $body = $_POST['txaBody'] : $body = "";
        isset($_POST['txaBody']) ? $body = explode("\n", $_POST['txaBody']) : $body = [];

        for ($i=0; $i<count($_FILES["inpFile"]['tmp_name']); $i++) {
            if(file_exists($_FILES['inpFile']['tmp_name'][$i])) {
                $item = array(
                    'name'     => $_FILES['inpFile']['name'][$i],
                    'tmp_name' => $_FILES['inpFile']['tmp_name'][$i],
                    'size'     => $_FILES['inpFile']['size'][$i],
                    'type'     => $_FILES['inpFile']['type'][$i]);

                array_push($attach, $item);
            }
        }
        
        // $hola = ['to'=>$to,'subject'=>$subject,'body'=>$body,'attach'=>$attach];
        // echo '<pre>';
        // print_r($hola);
        // echo '</pre>';

        if($this->model->send(['to'=>$to,'subject'=>$subject,'body'=>$body,'attach'=>$attach])) {
            $this->view->mensaje = "Mensaje enviado correctamente";
        } else {
            $this->view->mensaje = "Ocurrio un error al enviar el mensaje";
        }
        $this->view->render('nuevo/index');
    }
}

?>