<h2>Change Password</h2>

Username: <?php echo $this->Form->value('User.username'); ?>

<?php
echo $this->Form->create('User');
echo $this->Form->input('id');
echo $this->Form->input('password', array('label' => 'New Password', 'value' => ''));
echo $this->Form->end('Update');
?>
