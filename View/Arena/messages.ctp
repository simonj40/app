<?php $this->assign('title', 'messages');
$this->layout = 'bootstrap';
echo $this->Html->script('messages'); 
?>
<h1>My Messages</h1>
<div id='myMessages'>
    <button type="button" class="btn btn-default" aria-label="Left Align" action="refresh" >
       <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
       Refresh
    </button>
    <table id='messagesTable'>
        
    </table>
</div>

<div id='new_message'>
    <form class="form-horizontal">
        <fieldset>
        <!-- Form Name -->
        <h2>Send a Message</h2>
        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="selectbasic">To : </label>
          <div class="col-md-4">
            <select id="fighters_select" name="selectbasic" class="form-control">
              <?php foreach ($fighters as $fighter):?>
                    <?php 
                        if($fighter['Fighter']['id'] != $fighterId){
                            echo '<option value="'.$fighter['Fighter']['id'].'" >'.$fighter['Fighter']['name'].'</option>';
                        }
                    ?>    
                <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textinput"></label>  
          <div class="col-md-4">
          <input id="message_title" name="textinput" type="text" placeholder="Title" class="form-control input-md">

          </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textarea"></label>
          <div class="col-md-4">                     
            <textarea class="form-control" id="message_text" name="textarea" placeholder="My message..."></textarea>
          </div>
        </div>
        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="singlebutton"></label>
          <div class="col-md-4">
            <button type="button" class="btn btn-default" aria-label="Left Align" action="send" >
            <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
            Send
            </button>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 control-label" for="singlebutton"></label>
          <div class="col-md-4" id='send_notification'>
            
          </div>
        </div>

        </fieldset>
    </form>
    
</div>
