<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('map/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('map/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'map/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['pitch']->renderLabel() ?></th>
        <td>
          <?php echo $form['pitch']->renderError() ?>
          <?php echo $form['pitch'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['yaw']->renderLabel() ?></th>
        <td>
          <?php echo $form['yaw']->renderError() ?>
          <?php echo $form['yaw'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['roll']->renderLabel() ?></th>
        <td>
          <?php echo $form['roll']->renderError() ?>
          <?php echo $form['roll'] ?>
        </td>
      </tr>

      <tr>
        <th><?php echo $form['latitude']->renderLabel() ?></th>
        <td>
          <?php echo $form['latitude']->renderError() ?>
          <?php echo $form['latitude'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['longitude']->renderLabel() ?></th>
        <td>
          <?php echo $form['longitude']->renderError() ?>
          <?php echo $form['longitude'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
