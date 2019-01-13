<?php
/** @var $placement string */
/** @var $cssClass string */
/** @var $dismissible boolean */

$dismissible = isset($dismissible)?$dismissible:false;

if(isset($_GET['debug']) && $ad = Advertises::GetInPlacement($placement)):
    if($ad && $ad->banner && is_file(Yii::getPathOfAlias('webroot')."/uploads/advertises/$ad->banner")):?>
        <div class="advertise <?= $cssClass ?>">
            <?php if($dismissible):?><strong class="advertise-close"></strong><?php endif; ?>
            <a href="<?= $ad->link ?>" rel="nofollow" target="_blank">
                <div class="advertise-image" style="background-image: url('<?= Yii::app()->getBaseUrl(true)."/uploads/advertises/$ad->banner" ?>');"></div>
            </a>
        </div>
    <?php
    endif;
endif; ?>