<?php
/**
 * @package      CrowdFunding
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

$items    = $displayData["items"];
$params   = $displayData["params"];
$currency = $displayData["currency"];
$socialProfiles = $displayData["socialProfiles"];
?>
<ul class="thumbnails">
    <?php foreach ($items as $item) {

        $projectStateCSS = JHtml::_("crowdfunding.styles", $item, $params);

        $raised = $currency->getAmountString($item->funded);

        // Prepare the value that I am going to display
        $fundedPercents = JHtml::_("crowdfunding.funded", $item->funded_percents);

        // Prepare social profile.
        if (!is_null($socialProfiles)) {
            $socialProfile = $socialProfiles->getLink($item->user_id);
            $profileName   = JHtml::_("crowdfunding.socialProfileLink", $socialProfile, $item->user_name);
        }
        ?>
        <li class="span<?php echo $displayData["span"]; ?>">
            <div class="thumbnail cf-project <?php echo $projectStateCSS; ?> ">
                <?php if($params->get("discover_include_badge_element", 0)) {?><div class="cf-badge"></div><?php } ?>
                <a href="<?php echo JRoute::_(CrowdFundingHelperRoute::getDetailsRoute($item->slug, $item->catslug)); ?>" class="cf-thumnails-thumb">
                    <?php if (!$item->image) { ?>
                        <img src="<?php echo "media/com_crowdfunding/images/no_image.png"; ?>"
                             alt="<?php echo $this->escape($item->title); ?>" width="<?php echo $params->get("image_width", 200); ?>"
                             height="<?php echo $params->get("image_height", 200); ?>" />
                    <?php } else { ?>
                        <img src="<?php echo $displayData["imageFolder"] . "/" . $item->image; ?>"
                             alt="<?php echo $this->escape($item->title); ?>" width="<?php echo $params->get("image_width", 200); ?>"
                             height="<?php echo $params->get("image_height", 200); ?>" />
                    <?php } ?>
                </a>

                <div class="caption">
                    <h3>
                        <a href="<?php echo JRoute::_(CrowdFundingHelperRoute::getDetailsRoute($item->slug, $item->catslug)); ?>">
                            <?php echo JHtmlString::truncate($item->title, $displayData["titleLength"], true, false); ?>
                        </a>
                    </h3>
                    <?php if (!is_null($socialProfiles)) { ?>
                        <div class="font-xxsmall">
                            <?php echo JText::sprintf("COM_CROWDFUNDING_BY_S", $profileName); ?>
                        </div>
                    <?php } ?>

                    <?php if ($params->get("discover_display_description", true)) { ?>
                        <p><?php echo JHtmlString::truncate($item->short_desc, $displayData["descriptionLength"], true, false); ?></p>
                    <?php } ?>
                </div>
                <div class="cf-caption-info absolute-bottom hidden-phone">
                    <?php echo JHtml::_("crowdfunding.progressbar", $fundedPercents, $item->days_left, $item->funding_type); ?>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="bolder"><?php echo $item->funded_percents; ?>%</div>
                            <div class="uppercase"><?php echo JText::_("COM_CROWDFUNDING_FUNDED"); ?></div>
                        </div>
                        <div class="span4">
                            <div class="bolder"><?php echo $raised; ?></div>
                            <div class="uppercase"><?php echo JText::_("COM_CROWDFUNDING_RAISED"); ?></div>
                        </div>
                        <div class="span4">
                            <div class="bolder"><?php echo $item->days_left; ?></div>
                            <div class="uppercase"><?php echo JText::_("COM_CROWDFUNDING_DAYS_LEFT"); ?></div>
                        </div>
                    </div>
                </div>

            </div>

        </li>
    <?php } ?>
</ul>
<div class="clearfix"></div>