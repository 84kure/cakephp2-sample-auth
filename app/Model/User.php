<?php

class User extends AppModel {
    
    public $validate = array(
        'username' => array(
            'length' => array(
                'rule' => array('minLength', 5),
                'message' => 'You must enter at least 5 chars.',
            ),
            'alphanum' => array(
                'rule' => 'alphanumeric',
                'message' => 'You can enter letters and numbers only.',
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Already used.',
            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => 'Invalid email address.',
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Already used.',
            ),
        ),
        'password' => array(
            'empty' => array(
                'rule' => 'notBlank',
                'message' => 'You must enter the password.',
            ),
        ),
        'password_confirm' => array(
            'compare' => array(
                'rule' => array('password_match', 'password'),
                'message' => 'Passwords unmatched.',
            ),
            'length' => array(
                'rule' => array('between', 6, 20),
                'message' => 'Password must be between 6 and 20 chars.',
            ),
            'empty' => array(
                'rule' => 'notBlank',
                'message' => 'You must enter the password.',
            ),
        ),
    );

    //--------------------------------------------------------------------------
    // Helper functions.
    // Check if the password match with the confirmation.
    public function password_match($field, $password) {
        return ($field['password_confirm'] === $this->data[$this->name][$password]);
    }
    // Generate a hash for activation.
    public function getActivationHash() {
        if (!isset($this->id)) {
            return false;
        } else {
            return Security::hash($this->field('modified'), 'md5', true);
        }
    }

    //--------------------------------------------------------------------------
    // Callbacks.
    // Called before saving the data.
    public function beforeSave($options = array()) {
        // Encrypt (hash) the password.
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
}
