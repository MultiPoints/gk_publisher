<?php die('here');
defined('_JEXEC') or die();
$document = JFactory::getDocument();
$limit = $pagination->limit;
$limitstart = JRequest::getVar('limitstart');
if (!$limitstart) $limitstart = 0;
$document	= JFactory::getDocument();
$document->setTitle(JText::_('activ50plus'));
$my = CFactory::getUser();
if( $events ) {
?>
<ul class="cIndexList forEvents cResetList">
<?php
	$db = JFactory::getDBO();
	for( $i = 0; $i < count( $events ); $i++ ) {
		$item = $i + $limitstart;
		$event =& $events[$i];
		
        $isMine	= ($my->id == $event->creator);

		$handler	= CEventHelper::getHandler($event);
		if (($i + 1) % 2) $class = 'eventItem odd';
		else $class = 'eventItem even';

//		if ($i > count($events) - 3) $class .= ' nomarginbottom';
		
		$query = "SELECT * FROM #__community_events_extra_fields WHERE event_id = " . $event->id;
		$db->setQuery($query);
		$res = $db->loadObjectlist();
		$extra_fields = $res[0];
		
		$link = $extra_fields->link;
		if(strpos($link, '@') !== false) { // email
			$link = 'mailto:' . $link;
		} else { // url
			if (strpos($link, 'http') === false)
				$link = 'http://' . $link;
		}
		
		if (!$extra_fields->image1) $extra_fields->image1 = 'images/default/default_' . $event->catid . '.jpg';
?>
	<li class="<?php echo $class;?>">
		<div class="cIndex-Box clearfix">
			<div id="event_detail_<?php echo $item;?>" class="event-detail-popup" style="display: none;">
            	<div class="event-detail-wrap">
                    <div class="event-header"><h3><?php echo $this->escape($event->title);?></h3><a href="#" class="event_detail_<?php echo $item;?>_close event-close"><?php echo JText::_('COM_COMMUNITY_EVENTS_CLOSE'); ?></a></div>
           			<div class="event-sum">
                        <div class="info">
                        	<h1><?php echo $this->escape($event->title);?></h1>
                            <hr />
                            <div><label><?php echo JText::_('COM_COMMUNITY_EVENTS_DATE'); ?>:</label><?php echo CEventHelper::formatStartDate($event, 'd.m.Y'); ?></div>
                            <div><label><?php echo JText::_('COM_COMMUNITY_EVENTS_TIME'); ?>:</label><?php if (CEventHelper::formatStartDate($event, 'H:i') != '00:00' || CTimeHelper::getFormattedTime($event->enddate, '%H:%M') != '23:59') echo CEventHelper::formatStartDate($event, 'H:i') . ' ' . JText::_('COM_COMMUNITY_EVENTS_TO') . ' ' . CTimeHelper::getFormattedTime($event->enddate, '%H:%M'); else echo JText::_('COM_COMMUNITY_EVENTS_WHOLE_DAY');?>
                            </div>
                            <div><label><?php echo JText::_('COM_COMMUNITY_EVENTS_LOCATION'); ?>:</label><?php echo $this->escape($event->location);?></div>                            
                            <div><label><?php echo JText::_('COM_COMMUNITY_EVENTS_CATEGORY'); ?>:</label><?php echo $event->getCategoryName();?></div>                            
                            <hr />
                            <div><strong><label><?php echo JText::_('COM_COMMUNITY_EVENTS_PRICE'); ?>:</label> <?php echo $extra_fields->cost;?> CHF</strong></div>
                            <div><strong><label><?php echo JText::_('COM_COMMUNITY_EVENTS_NO_SEAT'); ?>:</label> <?php echo $event->ticket;?></strong></div>
                            <div class="event-link">
                            	<a href="<?php echo $link;?>" target="_blank" class="red-btn"><?php echo JText::_('JLOGIN') ?></a>
                                <ul class="nav pull-right">
                                  <li class="dropup">
                                    <a href="#" class="js-navbar-options"><?php echo JText::_('COM_COMMUNITY_VIDEOS_OPTIONS')?></a>
                                    <ul class="dropdown-menu pull-right">
                                        <?php if($memberStatus != COMMUNITY_EVENT_STATUS_BLOCKED) { ?>
                                            <!-- Event Menu List -->
                                            <?php if( $handler->showPrint() ) { ?>
                                            <!-- Print Event -->
                                            <li><a tabindex="-1" href="javascript:void(0)" onclick="window.open('<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=printpopup&eventid='.$event->id); ?>','', 'menubar=no,width=600,height=700,toolbar=no');"><?php echo JText::_('COM_COMMUNITY_EVENTS_PRINT');?></a>
                                            </li>
                                            <?php } ?>
                
                                            <?php if( $handler->showExport() && $config->get('eventexportical') ) { ?>
                                            <!-- Export Event -->
                                            <li><a tabindex="-1" href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=export&format=raw&eventid=' . $event->id); ?>" ><?php echo JText::_('COM_COMMUNITY_EVENTS_EXPORT_ICAL');?></a>
                                            </li>
                                            <?php } ?>
                                            <?php if( (!$isEventGuest) && ($event->permission == COMMUNITY_PRIVATE_EVENT) && (!$waitingApproval)) { ?>
                                            <!-- Join Event -->
                                            <li><a tabindex="-1" href="javascript:void(0);" onclick="javascript:joms.events.join('<?php echo $event->id;?>');"><?php echo JText::_('COM_COMMUNITY_EVENTS_INVITE_REQUEST'); ?></a>
                                            </li>
                                            <?php } ?>
                                            <?php if( (!$isMine) && !($waitingRespond) && (COwnerHelper::isRegisteredUser()) ) { ?>
                                            <!-- Leave Event -->
                                            <li class="important"><a tabindex="-1" href="javascript:void(0);" onclick="joms.events.leave('<?php echo $event->id;?>');"><?php echo JText::_('COM_COMMUNITY_EVENTS_IGNORE');?></a>
                                            </li>
                                            <?php } ?>
                                            <li class="divider"></li>
                                            <!-- Event Menu List -->
                                        <?php } ?>
                
                                        <!-- event administration -->
                                        <?php if($isMine || $isCommunityAdmin || $isAdmin || $handler->manageable()) {?>
                                            <?php if( $isMine || $isCommunityAdmin || $isAdmin) {?>
                                                <!-- Edit Event -->
                                                <li>
                                                    <a tabindex="-1" href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=edit&eventid=' . $event->id );?>"><?php echo JText::_('COM_COMMUNITY_EVENTS_EDIT');?></a>
                                                </li>
                                            <?php } ?>
                
                                            <?php if( ($event->permission != COMMUNITY_PRIVATE_EVENT) && ($isMine || $isCommunityAdmin || $isAdmin) ){ ?>
                                                <!-- Copy Event -->
                                                <li>
                                                    <a tabindex="-1" href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=create&eventid=' . $event->id );?>"><?php echo JText::_('COM_COMMUNITY_EVENTS_DUPLICATE');?></a>
                                                </li>
                                            <?php } ?>
                                            <!-- Delete Event -->
                                            <li class="divider"></li>
                                            <?php if( $handler->manageable() ) { ?>
                                                <li><a tabindex="-1" class="event-delete" href="javascript:void(0);" onclick="javascript:joms.events.deleteEvent('<?php echo $event->id;?>');"><?php echo JText::_('COM_COMMUNITY_EVENTS_DELETE'); ?></a></li>
                                            <?php } ?>
                                        <?php } ?>
                                        <!-- event administration end -->
                
                                        <?php if( ( $isMine || $isAdmin || $isCommunityAdmin) && ( $unapproved > 0 ) ) { ?>
                                            <li class="divider"></li>
                                            <li>
                                                <a tabindex="-1" href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=viewguest&type='.COMMUNITY_EVENT_STATUS_REQUESTINVITE.'&eventid=' . $event->id);?>">
                                                    <?php echo JText::sprintf((CStringHelper::isPlural($unapproved)) ? 'COM_COMMUNITY_EVENTS_PENDING_INVITE_MANY'	 :'COM_COMMUNITY_EVENTS_PENDING_INVITE' , $unapproved ); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                
                                        </ul>
                                  </li>
                                </ul>
                            </div>
                            <div class="agree"><?php printf(JText::_('COM_COMMUNITY_AGREE'), '<a target="_blank" href="index.php?option=com_content&view=article&id=58&Itemid=549">AGB</a>');?></div>
                        </div>
                    	<div class="full-img"><img id="full-img-<?php echo $item;?>" src="<?php echo $extra_fields->image1;?>" alt="<?php echo $this->escape($event->title); ?>" width="450" /></div>
                    </div>
                    <div class="event-thumbs">
                    	<?php for($j = 1; $j <= 5; $j ++) : $img = 'image' . $j;?>
                        	<?php if ($extra_fields->$img != '') :?>
                            	<?php if ($j == 5) $imgcls = ' no-marginright'; else $imgcls = '';?>
                				<div class="thumb<?php echo $imgcls;?>" style="background-image: url(<?php echo $extra_fields->$img;?>);" data="<?php echo $extra_fields->$img;?>"></div>
                            <?php endif;?>
                        <?php endfor;?>
                    </div>
                    <div class="event-description">
                    	<div><?php echo $event->summary;?></div>
						<div><?php echo $event->description;?></div>
                    </div>
                    <div class="event-share">
                    	<?php
							$share_link = explode('index.php', $event->getLink());
							$share_link1 = JUri::base() . 'index.php' . $share_link[1];
							$share_link = urlencode($share_link1);
						?>
                    	<a href="http://www.facebook.com/sharer.php?u=<?php echo $share_link;?>" target="_blank"><img src="images/icons/fb.png" /></a>
                    	<a href="http://twitter.com/home?status=<?php echo $share_link;?>" target="_blank"><img src="images/icons/tw.png" /></a>
                    	<a href="https://plus.google.com/share?url=<?php echo $share_link;?>" target="_blank"><img src="images/icons/ggp.png" /></a>
                    	<a class="modal" rel="{handler: 'iframe', size: {x: 570, y: 440}}" href="index.php?option=com_chronoforms&tmpl=component&chronoform=event_share&tmpl=component&message=<?php echo base64_encode($share_link1);?>"><img src="images/icons/email.png" /></a>
                    </div>
                </div>
            </div>
			<script type="text/javascript">
                    jQuery(document).ready(function(e) {
                        jQuery("#event_detail_<?php echo $item;?>").popup();
                        jQuery("#event_detail_<?php echo $item;?> .event-thumbs .thumb").click(function(e) {
                            jQuery("#full-img-<?php echo $item;?>").attr("src", jQuery(this).attr("data"));
                        });
                    });
            </script>
			<a href="#" class="event_detail_<?php echo $item;?>_open nonmobile">
				<img src="<?php echo $extra_fields->image1;?>" alt="<?php echo $this->escape($event->title); ?>" width="240" height="180" class="event-img" />

				<?php if( $isExpired || CEventHelper::isPast($event) ) { ?>
					<b class="cStatus-Past"><?php echo JText::_('COM_COMMUNITY_EVENTS_PAST'); ?></b>
				<?php } else if(CEventHelper::isToday($event)) { ?>
					<b class="cStatus-OnGoing"><?php echo JText::_('COM_COMMUNITY_EVENTS_ONGOING'); ?></b>
				<?php } ?>
			</a>

			<a href="<?php echo $event->getLink();?>" class="mobile">
				<img src="<?php echo $extra_fields->image1;?>" alt="<?php echo $this->escape($event->title); ?>" width="240" height="180" class="event-img" />

				<?php if( $isExpired || CEventHelper::isPast($event) ) { ?>
					<b class="cStatus-Past"><?php echo JText::_('COM_COMMUNITY_EVENTS_PAST'); ?></b>
				<?php } else if(CEventHelper::isToday($event)) { ?>
					<b class="cStatus-OnGoing"><?php echo JText::_('COM_COMMUNITY_EVENTS_ONGOING'); ?></b>
				<?php } ?>
			</a>

			<div class="cIndex-Content">
				<h3 class="cIndex-Name cResetH">
					<a class="mobile" href="<?php echo $event->getLink();?>"><?php echo $this->escape($event->title); ?></a>
					<a href="#" class="event_detail_<?php echo $item;?>_open nonmobile"><?php echo $this->escape($event->title); ?></a>
				</h3>
				<div class="cIndex-Status">
					<div class="cIndex-Date"><label><?php echo JText::_('COM_COMMUNITY_EVENTS_DATE'); ?>:</label><?php echo CEventHelper::formatStartDate($event, 'd.m.Y'); ?></div>
                    <div class="cIndex-Time"><label><?php echo JText::_('COM_COMMUNITY_EVENTS_TIME'); ?>:</label><?php if (CEventHelper::formatStartDate($event, 'H:i') != '00:00' || CTimeHelper::getFormattedTime($event->enddate, '%H:%M') != '23:59') echo CEventHelper::formatStartDate($event, 'H:i') . ' ' . JText::_('COM_COMMUNITY_EVENTS_TO') . ' ' . CTimeHelper::getFormattedTime($event->enddate, '%H:%M'); else echo JText::_('COM_COMMUNITY_EVENTS_WHOLE_DAY');?>
					<div class="cIndex-Location"><label><?php echo JText::_('COM_COMMUNITY_EVENTS_LOCATION'); ?>:</label><?php echo $this->escape($event->location);?></div>
					<div class="cIndex-Summary"><?php echo substr($this->escape($event->summary), 0, 80);?>...</div>
				</div>
			</div>
		</div>
        <a class="wholelink mobile" href="<?php echo $event->getLink();?>"></a>
        <a class="wholelink event_detail_<?php echo $item;?>_open nonmobile" href="#"></a>
	</li>
 <?php 
	}
?>
</ul>
<?php
	if ($pagination->pagesTotal > 1) {
		$protocol = strpos($_SERVER['SERVER_PROTOCOL'], 'HTTPS') !== false ? 'https://' : 'http://';
		$current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
	<div id="loadmore"><a id="next" class="bigblackbutton" href="javascript: void(0);"><img width="24" height="24" alt="red-plus" src="images/icons/red-plus.png"> <?php echo JText::_('COM_COMMUNITY_EVENTS_MORE_EVENTS');?></a></div>
	<script type="text/javascript">
        jQuery('ul.forEvents').infinitescroll({
            navSelector  	: "#next:last",
            nextSelector 	: "a#next:last",
            itemSelector 	: "ul.forEvents li.eventItem",
            dataType	 	: 'html',
			animate			: true,
	        loading: {
				finishedMsg   : '<?php echo JText::_('COM_COMMUNITY_EVENTS_NO_MORE_EVENTS');?>',
				msgText   : '<?php echo JText::_('COM_COMMUNITY_EVENTS_LOADING');?>',
				img: '<?php echo JUri::base();?>/images/icons/loading.gif'
			},
            path: function(index) {
                return '<?php echo $current_url;?>&limitstart=' + (index - 1) * <?php echo $limit;?>;
            }
        }, function(arrayOfNewElems) {
				<?php
					$total = $pagination->limit * $pagination->pagesTotal;
				?>
				for (i = 0; i < <?php echo $total;?>; i ++) {
				 	jQuery('#event_detail_' + i).popup();
					jQuery('#event_detail_' + i + ' .event-thumbs img').click(function(e) {
						jQuery('#full-img-' + i).attr('src', jQuery(this).attr('src'));
					});
				}
		});
    </script>
<?php
	}
?>
<?php
} else {
?>
<div class="cEmpty cAlert"><?php echo JText::_('COM_COMMUNITY_EVENTS_NO_EVENTS_ERROR'); ?></div>
<?php } ?>
