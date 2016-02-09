<?php
class UsersController extends AppController {

    /* コンポーネントをロード*/
    public $components = array(
        'Users'
    );

    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow('login', 'logout');

    }

    public function login() {

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {

                $user_data['User']['id']            = $this->Auth->user('id');
                $user_data['User']['company_id']    = $this->Auth->user('company_id');
                $user_data['User']['email']         = $this->Auth->user('email');
                $user_data['User']['group_id']      = $this->Auth->user('group_id');

                $user_data['Profile']['family_name']   = null;
                $user_data['Profile']['first_name']    = null;
                $user_data['Profile']['gender']        = null;
                $user_data['Profile']['group_id']      = null;

                $user_data['Company']['id']                 = null;
                $user_data['Company']['name']               = null;
                $user_data['Company']['basic_price']        = null;
                $user_data['Company']['monthly_coupon_num'] = null;

                $user_data['Departments']   = null;
                $user_data['Location']      = null;

                $this->Session->write('Auth', $user_data);

                $user = $this->Session->read('Auth');
                var_dump($user);
                exit;



                $this->redirect(array('controller' => 'Restaurants', 'action' => 'index'));
            } else {
                $this->redirect(array('controller' => 'Users', 'action' => 'login'));
            }
        }

    }

    public function logout() {

    }

    public function detail() {

    }

    public function password() {

    }

    public function edit() {

    }

}