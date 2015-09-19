<?php

App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('signup', 'activate', 'login'));
    }
    
    // Signup (store info in DB then send an email for activation)
    public function signup() {
        if ($this->request->is('post')) {
            if ($this->User->save($this->data)) {
                // Create an activation link.
                $url = 'activate/' . $this->User->id . '/' . $this->User->getActivationHash();
                $url = Router::url($url, true);
                //--------------------------------------------------------------
                // Send an email.
                $email = new CakeEmail();
                $email->from(array('sender@domain.com' => 'Sender'));
                $email->to($this->data['User']['email']);
                $email->subject('User Activation');
                $email->send($url);
                //--------------------------------------------------------------
                $this->Session->setFlash('Email sent for activation.');
            } else {
                $this->Session->setFlash('Input error.');
            }
        }
    }
    
    // Activation
    public function activate($user_id = null, $in_hash = null) {
        $this->User->id = $user_id;
        if ($this->User->exists() && $in_hash == $this->User->getActivationHash()) {
            $this->User->saveField('active', 1);
            $this->Session->setFlash('Your account has been activated.');
        } else {
            $this->Session->setFlash('Invalid access.');
        }
    }
    
    // Login
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->User->id = $this->Auth->user('id');
                $this->User->saveField('logins', $this->Auth->user('logins') + 1);  // total login count
                $this->User->saveField('lastlogin', date('Y-m-d H:i:s'));           // last login date/time
                return $this->redirect($this->Auth->redirect());
            } else {
                $active = $this->User->field('active', array('username' => $this->data['User']['username']));
                if ($active === 0) {
                    $this->Session->setFlash('Please activate your account.');
                } else {
                    $this->Session->setFlash('Invalid username or password.');
                }
            }
        }
    }
    
    // Logout
    public function logout() {
        $this->Session->setFlash('Logged out.');
        return $this->redirect($this->Auth->logout());
    }
    
    // Dashboard (page to be shown after logging-in)
    public function dashboard() {
        
    }

    // Change password
    public function password() {
        $id = $this->Auth->user('id');
        
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Unknown user.');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            debug($this->request->data);
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Your password has been updated.');
                $this->redirect(array('action' => 'dashboard'));
            } else {
                $this->Session->setFlash('You password could not be updated.');
            }
        }
        $this->request->data = $this->User->read(null, $id);
    }
}
