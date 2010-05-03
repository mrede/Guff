<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('post/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table id='form_div'>
    <tfoot>
      <tr>
        <td colspan="2">
					<?php echo $form->renderHiddenFields()?>
          <input id='submit_but' type="submit" value="Post" disabled='true'/>
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['text']->renderLabel() ?></th>
        <td>
          <?php echo $form['text']->renderError() ?>
          <?php echo $form['text'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
