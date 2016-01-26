<?php
  App::uses('ExceptionRenderer', 'Error');
 
  class MyExceptionRenderer extends ExceptionRenderer {

        public function notFound($error) {
            $this->controller->redirect(array('controller' => 'Restaurants', 'action' => 'index'));
        }

        public function missingController($error) {
            $this->controller->redirect(array('controller' => 'Restaurants', 'action' => 'index'));
        }

        public function missingAction($error) {
            $this->controller->redirect(array('controller' => 'Restaurants', 'action' => 'index'));
        }
        
        public function missingWidget($error) {
            $this->controller->redirect(array('controller' => 'Restaurants', 'action' => 'index'));
        }
  }
?>