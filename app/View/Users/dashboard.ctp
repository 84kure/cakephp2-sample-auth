<h2>Dashboard</h2>

<?php debug($loggedin); ?>

<?php echo $this->Html->link('Change password', array('controller' => 'users', 'action' => 'password')); ?>
<br />
<?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?>
