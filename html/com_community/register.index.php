<?php
defined('_JEXEC') or die();
?>
<form action="<?php echo CRoute::getURI(); ?>" method="post" id="jomsForm" name="jomsForm" class="community-form-validate">
<div class="ctitle">
	<h2><?php echo JText::_( 'COM_COMMUNITY_REGISTER_TITLE_USER_INFO' ); ?></h2>
</div>
<ul class="cFormList cFormHorizontal cResetList">
	<li class="reminder">
		<div class="form-field">
			<?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?>
		</div>
	</li>
<?php if ($isUseFirstLastName) { ; ?>
	<li>
		<label id="jsfirstnamemsg" for="jsfirstname" class="form-label"><?php echo JText::_( 'COM_COMMUNITY_FIRST_NAME' ); ?><span class="required-sign">&nbsp;*</span></label>

		<div class="form-field">
		    <input type="text" id="jsfirstnamemsg" name="jsfirstname"
					value="<?php echo $data['html_field']['jsfirstname']; ?>"
					class="input text required validate-firstname" style="width: 70%" />
			<span id="errjsfirstnamemsg" style="display:none;">&nbsp;</span>
		</div>
	</li>
	<li>
		<label id="jslastnamemsg" for="jslastname" class="form-label"><?php echo JText::_( 'COM_COMMUNITY_LAST_NAME' ); ?><span class="required-sign">&nbsp;*</span></label>

		<div class="form-field">
		    <input type="text" id="jslastnamemsg" name="jslastname"
					value="<?php echo $data['html_field']['jslastname']; ?>"
					class="input text required validate-jslastname" style="width: 70%" />
			<span id="errjslastnamemsg" style="display:none;">&nbsp;</span>
		</div>
	</li>
<?php } else { ?>
	<li>
		<label id="jsnamemsg" for="jsname" class="form-label"><?php echo JText::_( 'COM_COMMUNITY_NAME' ); ?><span class="required-sign">&nbsp;*</span></label>

		<div class="form-field">
		    <input type="text" name="jsname" id="jsname" value="<?php echo $data['html_field']['jsname']; ?>" class="input text required validate-name" style="width: 70%" />
			<span id="errjsnamemsg" style="display:none;">&nbsp;</span>
		</div>
	</li>
<?php } ?>
	<li>
    	<script type="text/javascript">jQuery(document).ready(function(e) {jQuery('#jsusername').val(jQuery('#jsemail').val()); jQuery('#jsemail').keyup(function(e) {jQuery('#jsusername').val(jQuery(this).val());});});</script>
		<label id="jsemailmsg" for="jsemail" class="form-label"><?php echo JText::_( 'COM_COMMUNITY_EMAIL' ); ?><span class="required-sign">&nbsp;*</span></label>

		<div class="form-field">
		    <input type="hidden" id="jsusername" name="jsusername" value="<?php echo $data['html_field']['jsusername']; ?>" />
		    <input type="text" id="jsemail" name="jsemail" value="<?php echo $data['html_field']['jsemail']; ?>" class="input text required validate-email"  style="width: 70%" />
		    <input type="hidden" name="emailpass" id="emailpass" value="N"/>
		    <span id="errjsemailmsg" style="display:none;">&nbsp;</span>
		</div>
	</li>
	<li>
		<label id="pwmsg" for="jspassword" class="form-label"><?php echo JText::_( 'COM_COMMUNITY_PASSWORD' ); ?><span class="required-sign">&nbsp;*</span></label>

		<div class="form-field">
		    <input class="input password required validate-password" type="password" id="jspassword" name="jspassword" style="width: 50%" />
		</div>
	</li>
	<li>
		<label id="pw2msg" for="jspassword2" class="form-label"><?php echo JText::_( 'COM_COMMUNITY_VERIFY_PASSWORD' ); ?><span class="required-sign">&nbsp;*</span></label>

		<div class="form-field">
		    <input class="input password  required validate-passverify" type="password" id="jspassword2" name="jspassword2" style="width: 50%" />
		    <span id="errjspassword2msg" style="display:none;">&nbsp;</span>
		</div>
	</li>
	<?php
	if(!empty($recaptchaHTML))
	{
	?>
	<li>
		<div class="form-field">
			<div class="cRecaptcha">
				<?php echo $recaptchaHTML;?>
			</div>
		</div>
	</li>
	<?php
	}
	if( $config->get('enableterms') )
	{
	?>
	<li class="has-seperator">
		<div class="form-field" id="agb">
			<label class="label-checkbox">
				<input type="checkbox" name="tnc" id="tnc" value="Y" data-message="<?php echo JText::_('COM_COMMUNITY_REGISTER_ACCEPT_TNC')?>" class="input checkbox required validate-tnc" />
				<?php echo '<a href="index.php?option=com_content&view=article&id=58&Itemid=549" target="_blank">'.JText::_('COM_COMMUNITY_TERMS_AND_CONDITION').'</a> ' . JText::_('COM_COMMUNITY_I_HAVE_READ');?><span class="required-sign">&nbsp;*</span>
			</label>
		</div>
	</li>
	<?php }?>
	<li class="form-action has-seperator">
		<div class="form-field">
			<input class="btn btn-primary validateSubmit" type="submit" id="btnSubmit" value="<?php echo JText::_('COM_COMMUNITY_NEXT'); ?>" name="submit" onclick="if (!jQuery('#tnc').is(':checked')) jQuery('#agb').addClass('invalid');"  />
			<?php if ( $fbHtml ) { ?>
			<div class="auth-facebook">
				<?php echo $fbHtml;?>
			</div>
			<?php } ?>
		</div>
	</li>
</ul>
<?php
if( $config->get('enableterms') )
{
?>

<?php
}
?>



<input type="hidden" name="isUseFirstLastName" value="<?php echo $isUseFirstLastName; ?>" />
<input type="hidden" name="task" value="register_save" />
<input type="hidden" name="id" value="0" />
<input type="hidden" name="gid" value="0" />
<input type="hidden" id="authenticate" name="authenticate" value="0" />
<input type="hidden" id="authkey" name="authkey" value="" />
</form>

<script type="text/javascript">
	cvalidate.init();
	cvalidate.noticeTitle	= '<?php echo addslashes(JText::_('COM_COMMUNITY_NOTICE') );?>';
	cvalidate.setSystemText('REM','<?php echo addslashes(JText::_("COM_COMMUNITY_ENTRY_MISSING")); ?>');
	cvalidate.setSystemText('JOINTEXT','<?php echo addslashes(JText::_("COM_COMMUNITY_AND")); ?>');

joms.jQuery( '#jomsForm' ).submit( function(){
    joms.jQuery('#btnSubmit').hide();
	joms.jQuery('#cwin-wait').show();
	joms.jQuery('#jomsForm input').attr('readonly', true);

	if(joms.jQuery('#authenticate').val() != '1')
	{
		joms.registrations.authenticate();
		return false;
	}
});

// Password strenght indicator
var password_strength_settings = {
	'texts' : {
		1 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L1')); ?>',
		2 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L2')); ?>',
		3 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L3')); ?>',
		4 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L4')); ?>',
		5 : '<?php echo addslashes(JText::_('COM_COMMUNITY_PASSWORD_STRENGHT_L5')); ?>'
	}
}

joms.jQuery('#jspassword').password_strength(password_strength_settings);

</script>