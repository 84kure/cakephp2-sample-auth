<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $components = array('Session', 'Auth', 'DebugKit.Toolbar');
    
    public function beforeFilter() {
        // Login action.
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        
        // Post login action.
        $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard');
        
        // Post logout action.
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        
        // Use controller's isAuthorization() to check authorization.
        $this->Auth->authorize = array('Controller');
        
        // Specify the array of authentication object.
        $this->Auth->authenticate = array(
            'Form' => array(
                'userModel' => 'User',
                'fields' => array(
                    'username' => 'username',
                    'password' => 'password'
                ),
                'scope' => array('User.active' => 1)    // activated users only
            )
        );
        
        if ($this->Session->check('Auth.User')) {   // logged-in
            $loggedin = $this->Session->read('Auth.User');
            $this->set(compact('loggedin'));
        }
    }
    
    // Check authorization.
    public function isAuthorized($user) {
        // Check authorization here if necessary
        return true;    //authorized
    }
}

