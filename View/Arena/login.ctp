<h2>Login</h2>
<?php
echo $this->Form->create('Login');
echo $this->Form->input("Email");
echo $this->Form->input("Password");
echo $this->Form->end('Connexion');
?>
<a href='#'>Forgot your password?</a>