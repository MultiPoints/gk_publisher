<?php
defined('_JEXEC') or die();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title><?php echo $this->escape($event->title); ?></title>
  <?php echo $script; ?>

  <style type="text/css">
	h1{
		font-size:180%;
	}
	body {
		color:#333333;
		font-family:Helvetica,Arial,sans-serif;
		font-size:12px;
		line-height:1.3em;
	}

	td{
		font-size:12px;
	}
  </style>
  </head>
  <body>

  	<!-- Header -->
  	<table width="100%">
		<!-- title -->
		<tr>
			<td width="80%"><h1><?php echo $this->escape($event->title); ?></h1></td>
			<td width="20%" align="right"><a href="javascript:window.print();"><?php echo JText::_('COM_COMMUNITY_EVENTS_PRINT'); ?></a></td>
		</tr>
	</table>

  	<hr/>
	<table width="100%">
		<tr>
			<td><strong><?php echo JText::_('COM_COMMUNITY_EVENTS_DATE');?></strong></td>
			<td><?php echo CEventHelper::formatStartDate($event, 'd.m.Y'); ?></td>
		</tr>
		<!-- Time -->
		<tr>
			<td><strong><?php echo JText::_('COM_COMMUNITY_EVENTS_TIME');?></strong></td>
			<td><?php if (CEventHelper::formatStartDate($event, 'H:i') != '00:00' || CTimeHelper::getFormattedTime($event->enddate, '%H:%M') != '23:59') echo CEventHelper::formatStartDate($event, 'H:i') . ' ' . JText::_('COM_COMMUNITY_EVENTS_TO') . ' ' . CTimeHelper::getFormattedTime($event->enddate, '%H:%M'); else echo JText::_('COM_COMMUNITY_EVENTS_WHOLE_DAY');?>
				<br/>
				<?php
                                if( $config->get('eventshowtimezone') ) {
                                    echo $creatorUtcOffsetStr;
                                }
                                ?>
			</td>
		</tr>

		<!-- Location -->
		<tr>
			<td><strong><?php echo JText::_('COM_COMMUNITY_EVENTS_LOCATION');?></strong></td>
			<td><?php echo $this->escape($event->location); ?></td>
		</tr>

		<tr>
            <td><strong><?php echo JText::_('COM_COMMUNITY_EVENTS_CATEGORY'); ?>:</strong></td>
            <td><?php echo $event->getCategoryName();?></td>
        </tr>
		<tr>
			<td colspan="2"><hr/></td>
		</tr>
        <tr>
            <td><strong><?php echo JText::_('COM_COMMUNITY_EVENTS_PRICE'); ?></strong></td>
            <td><?php echo $extra_fields->cost;?> CHF</td>
        </tr>
        <tr>
            <td><strong><?php echo JText::_('COM_COMMUNITY_EVENTS_NO_SEAT'); ?></strong></td>
            <td><?php echo $event->ticket;?></td>
		</tr>

		<tr>
			<td colspan="2"><hr/></td>
		</tr>

        <tr>
            <td colspan="2"><?php echo $event->summary;?></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $event->description;?></td>
        </tr>
        
		<tr>
			<td colspan="2"><hr/></td>
		</tr>
		<?php

  		if(CMapping::validateAddress($event->location)){
  		?>
		<tr>
			<td colspan="2">
			<!-- begin: static map -->
          		<?php echo CMapping::drawStaticMap($event->location, 578, 500); ?>
          	<!-- end: static map -->
			</td>
		</tr>
		<?php } ?>
	</table>
	<script type="text/javascript">
		setTimeout('window.print();', 2000);
	</script>
  </body>
</html>