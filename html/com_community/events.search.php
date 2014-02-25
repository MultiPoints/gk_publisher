<?php
defined('_JEXEC') or die();
?>
<div class="cLayout cSearch Events">

	<?php 
	if($posted)
	{
	?>
	<div class="cSearch-Result">
		<p id="cResult-nav">
			<span><strong>
				<?php 
					$location = JRequest::getVar('location');
					$radius = JRequest::getVar('radius');
					$unit = JRequest::getVar('unit');
					
					if ($location) $search = JText::_('COM_COMMUNITY_EVENTS_NEARBY') . ' ' . $location  . ', ' . JText::_('COM_COMMUNITY_EVENTS_WITHIN') . ' ' . $radius . ' ' . $unit;
					
					$active = JRequest::getVar('active');
					if ($active) {
						switch ($active) {
							case 'today':
								$search = JText::_('COMMUNITY_EVENTS_SEARCH_TODAY');
								break;
							case 'tomorrow':
								$search = JText::_('COMMUNITY_EVENTS_SEARCH_TOMORROW');
								break;
							case 'thisweek':
								$search = JText::_('COMMUNITY_EVENTS_SEARCH_THIS_WEEK');
								break;
							case 'nextweek':
								$search = JText::_('COMMUNITY_EVENTS_SEARCH_NEXT_WEEK');
								break;
							case 'thismonth':
								$search = JText::_('COMMUNITY_EVENTS_SEARCH_THIS_MONTH');
								break;
							case 'nextmonth':
								$search = JText::_('COMMUNITY_EVENTS_SEARCH_NEXT_MONTH');
								break;
							case 'thisyear':
								$search = JText::_('COMMUNITY_EVENTS_SEARCH_THIS_YEAR');
								break;
							case 'nextyear':
								$search = JText::_('COMMUNITY_EVENTS_SEARCH_NEXT_YEAR');
								break;
						}
					} else {
						$startdate = JRequest::getVar('startdate');
						$enddate = JRequest::getVar('enddate');
						if(strpos($enddate, $startdate) !== false) $enddate = '';
						
						if ($startdate) $search = JHtml::_('date', $startdate, 'd.m.Y');
						if ($enddate) $search = JText::_('COM_COMMUNITY_EVENTS_FROM') . ' ' . JHtml::_('date', $startdate, 'd.m.Y') . ' ' . JText::_('COM_COMMUNITY_EVENTS_TO') . ' ' . JHtml::_('date', $enddate, 'd.m.Y');
						if (date('d.m.Y') == JHtml::_('date', $startdate, 'd.m.Y') && !$enddate && $startdate) $search = JText::_('COMMUNITY_EVENTS_SEARCH_TODAY');
					}
					
					echo $search;
				?>
			</strong></span>
			<span class="cFloat-R">
				<?php echo JText::sprintf( (CStringHelper::isPlural($eventsCount)) ? 'COM_COMMUNITY_EVENTS_SEARCH_RESULT_TOTAL_MANY' : 'COM_COMMUNITY_EVENTS_SEARCH_RESULT_TOTAL' , $eventsCount ); ?>
			</span>
		</p>
		<?php echo $eventsHTML; ?>
	</div>
	<?php
	}
	?>