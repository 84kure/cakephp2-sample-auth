<h2>Signup</h2>

<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'Username'));
echo $this->Form->input('email', array('label' => 'E-mail'));
echo $this->Form->input('password', array('label' => 'Password'));
echo $this->Form->input('password_confirm', array('label' => 'Password Again', 'type' => 'password'));
echo $this->Form->end('Signup');
?>
