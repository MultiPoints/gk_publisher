<?php

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<section class="registration<?php echo $this->pageclass_sfx?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<header>
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</header>
	<?php endif; ?>

	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
	<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
		<?php $fields = $this->form->getFieldset($fieldset->name);?>
		<?php if (count($fields)):?>
		<fieldset>
		<?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.?>
			<legend><?php echo JText::_($fieldset->label);?></legend>
		<?php endif;?>
			<dl>
		<?php foreach($fields as $field):// Iterate through the fields in the set and display them.?>
		  <?php if ($field->name!="jform[username]"): ?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
				<dt>
				<?php echo $field->label; ?>
				<?php if (!$field->required && $field->type != 'Spacer'): ?>
					<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL');?></span>
				<?php endif; ?>
				</dt>
				<dd><?php echo $field->input;?></dd>
			<?php endif;?>
          <?php endif;?>
		<?php endforeach;?>
            	<script type="text/javascript">jQuery(document).ready(function(e) {jQuery('#jform_username').val(jQuery('#jform_email1').val()); jQuery('#jform_email1').keyup(function(e) {jQuery('#jform_username').val(jQuery(this).val());});});</script>

        		   <input id="jform_username" type="hidden" value="" name="jform[username]">
			</dl>
		</fieldset>
		<?php endif;?>
	<?php endforeach;?>
		<div>
			<button type="submit" class="validate"><?php echo JText::_('JREGISTER');?></button>
			<?php echo JText::_('COM_USERS_OR');?>
			<a href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="registration.register" />
			<?php echo JHtml::_('form.token');?>
		</div>
	</form>
</section>