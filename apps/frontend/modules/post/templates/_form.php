<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form id='msg-post' action="/message" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  
  <?php echo $form->renderGlobalErrors() ?>

  <?php echo $form['text']->renderLabel('Post a message [<span id="counter">148</span> characters]') ?><br/>
  
          <?php echo $form['text']->renderError() ?>
          <?php echo $form['text'] ?><br/>
		  <input id='submit_but' data-inline="true" data-ajax="false" data-theme="b" class='button' type="submit" value="send"/>
		  <em>Your message will be visible within a 200m range of here for 2hrs</em> <!-- / Accuracy: <span id="accuracy"> --></span><br/>
		  <?php echo $form->renderHiddenFields()?>
          
      
</form>
