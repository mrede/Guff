<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('post/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  
  <?php echo $form->renderGlobalErrors() ?>

  <?php echo $form['text']->renderLabel() ?><br />
      
          <?php echo $form['text']->renderError() ?>
          <?php echo $form['text'] ?>
<input id='submit_but' class='button' type="submit" value="guff »" disabled='true'/>
					<?php echo $form->renderHiddenFields()?>
          
      
</form>
<div id='dump'>Locating you</div>
