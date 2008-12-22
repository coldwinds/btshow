<?php
echo $form->create('User', array('url' => array('controller' => 'users', 'action' =>'register')));
echo $form->input('User.username');
echo $form->input('User.password');
echo $form->input('User.password_confirm', array('type' => 'password'));
echo $form->input('User.email');
echo $form->end('Register');
?>