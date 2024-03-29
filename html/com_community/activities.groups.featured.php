<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/
defined('_JEXEC') or die();

$param = new CParameter($this->act->params);

$user = CFactory::getUser($this->act->actor);
?>
<a class="cStream-Avatar cFloat-L" href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$this->act->actor) ?>">
	<img src="<?php echo $user->getThumbAvatar()?>" data-author="<?php echo $this->act->actor ?>" class="cAvatar">
</a>

<div class="cStream-Content">
	<div class="cStream-Headline">
		<b>
			<?php echo $this->act->title; ?>
		</b>
	</div>

	<?php $this->load('activities.actions'); ?>

</div>