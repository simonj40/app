<?php

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <?php echo $this->Html->charset(); ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>
    <?php echo $cakeDescription ?>:
    <?php echo $this->fetch('title'); ?>
        </title>
    <?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array ('bootstrap.min', 'custom', 'jquery.dataTables','dataTables.bootstrap', 'carousel', 'jquery.jqplot'));
                echo $this->Html->script(array('/js/jquery-2.1.1.min.js'));
                echo $this->Html->script(array('/js/bootstrap.min.js'));
                echo $this->Html->script('jquery.dataTables');
                echo $this->Html->script('dataTables.bootstrap');
                
                
                //echo $this->Html->script(array('/js/ie10-viewport-bug-workaround'));
                echo $this->fetch('script');
		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
           <?php echo $this->Html->link('Login', array('controller' => 'Arena', 'action' => 'login'), array('class' => 'navbar-brand')); ?>
            <?php echo $this->Html->link('Index', array('controller' => 'Arena', 'action' => '/'), array('class' => 'navbar-brand')); ?>
           <?php echo $this->Html->link('Sight', array('controller' => 'Arena', 'action' => 'sight'), array('class' => 'navbar-brand')); ?>
            <?php echo $this->Html->link('Fighter', array('controller' => 'Arena', 'action' => 'fighter'), array('class' => 'navbar-brand')); ?>
            <?php echo $this->Html->link('Diary', array('controller' => 'Arena', 'action' => 'diary'), array('class' => 'navbar-brand')); ?>
            <?php echo $this->Html->link('Messages', array('controller' => 'Arena', 'action' => 'messages'), array('class' => 'navbar-brand')); ?>
            <?php echo $this->Html->link('Sign In', array('controller' => 'Arena', 'action' => 'signin'), array('class' => 'navbar-brand')); ?>
            <?php echo $this->Html->link('Sign Out', array('controller' => 'Arena', 'action' => 'logout'), array('class' => 'navbar-brand btn btn-primary btn-lg')); ?>
                </div>
                <div id="navbar" class="navbar-collapse collapse">

                </div><!--/.navbar-collapse -->
            </div>
        </nav>
        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron bkgimagex">
            <div class="container text-primary">
                <h3><?php echo $this->Session->flash(); ?></h3>
                <?php echo $this->fetch('content'); ?>
            </div>
        </div>


        <footer class="bkgimagef" id="footer">
             <div class="container">
            <div class="row text-primary">
                <div class="col-md-4">
                    <h4>Group</h4>
                    <p>SI1-04-BE</p>
                </div>
                <div class="col-md-4">
                    <h4>Authors</h4>
                    <ul>
                        <li>Simon JASPAR</li>
                        <li>Sterling COLEMAN</li>
                        <li>Japheth KOSGEI</li>
                        <li>Kevin EID</li>
                    </ul>

                    <p></p>
                </div>
                <div class="col-md-4">
                    <h4>Options (B/E/F)</h4>
                    <p><a href="https://github.com/simonj40/app.git">GitHub</a></p>
                </div>

            </div>
             </div>
        </footer>
        <div class="container">
      <?php echo $this->element('sql_dump_bootstrap'); ?>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php echo $this->fetch('scriptBottom');?>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

    </body>
</html>
