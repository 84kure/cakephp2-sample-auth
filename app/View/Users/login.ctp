<h2>Login</h2>

<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'Username'));
echo $this->Form->input('password', array('label' => 'Password'));
echo $this->Form->end('Login');
?>

<?php echo $this->Html->link('Signup', array('controller' => 'users', 'action' => 'signup')); ?>
