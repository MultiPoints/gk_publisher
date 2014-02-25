<?php

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$params = &$this->params;

?>

<?php foreach ($this->items as $i => $item) : ?>
<article>	
	<header>
		<h2>
			<?php if ($params->get('link_titles')): ?>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug)); ?>">
				<?php echo $this->escape($item->title); ?>
			</a>
			<?php else: ?>
				<?php echo $this->escape($item->title); ?>
			<?php endif; ?>
		</h2>
		
		<?php if ($params->get('show_create_date')) : ?>
		<ul>
			<li>
				<time pubdate="<?php echo JHtml::_('date', $item->created, DATE_W3C); ?>">
					<?php echo JHtml::_('date', $item->created, JText::_('F j, Y')); ?>
				</time>
			</li>
		</ul>
		<?php endif; ?>
	</header>

	<?php if ($params->get('show_intro')) :?>
	<div class="intro">
		<?php echo JString::substr(JHtml::_('string.truncate', $item->introtext, $params->get('introtext_limit')), 0, -3); ?>
	</div>
	<?php endif; ?>
</article>
<?php endforeach; ?>

<?php echo str_replace('</ul>', '<li class="counter">'.$this->pagination->getPagesCounter().'</li>', $this->pagination->getPagesLinks()); ?>