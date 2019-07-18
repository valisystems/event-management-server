<ul id="gn-menu" class="gn-menu-main">
    <li class="gn-trigger">
        <a class="gn-icon gn-icon-menu">&nbsp;</a>
        <nav class="gn-menu-wrapper">

            <div class="gn-scroller">
                <ul class="gn-menu">
                    <?php
                    if (Yii::app()->user->role == 'administrator' || Yii::app()->user->role == 'moderator'){
                        $url = '/admin';
                    } else {
                        $url = '/site/index';
                    }
                    echo "<li><a href='".Yii::app()->createUrl($url)."' ><i class='fa fa-home'></i><span class='hidden-sm text'>".Yii::t('admin/livepanel', 'Home')."</span></a></li>";
                    //print_r($this->buildingsRules);
                    foreach ($model as $k){
                        //print_r($k);
                        //echo CHtml::button($k->name, array('class'=>'btn btn-sm btn-primary', 'onClick' => 'javascript:getFloors('.$k->id_building.')'))."&nbsp;&nbsp;";
                        //if (array_search($k->id_building.'/', $this->buildingsRules, false)) {
                        if ($this->verifyArrayIfExist($k->id_building . '/', $this->buildingsRules)) {
                            echo "<li><a href='javascript:void(0);'  class='gn-icon dropmenu'><i class='fa  fa-building-o'></i>" . $k->name . "<span class='chevron closed'></span></a>";
                        }
                        if (count($k->maps)) {
                            echo "<ul>";
                            foreach ($k->maps as $lm) {
                                if (in_array($k->id_building . '/' . $lm->id_map, $this->buildingsRules, true))
                                    echo "<li><a href='javascript:void(0)' onClick='javascript:viewMaps(this, " . $k->id_building . ")' id_map='" . $lm->id_map . "' img_map='" . $lm->path_to_img . "'>" . $lm->name_map . "</a></li>";
                            }
                            echo "</ul>";
                        }
                        echo "</li>";
                        //}
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </li>
</ul>
<br />

<input type="hidden" name="id_building" id="id_building" value="6"/>
<input type="hidden" name="id_map" id="id_map" value="16"/>
<div id='ajax_loader' style="display: none;" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; "/>
</div>
<div class="row" id="mapsInfo" style='max-width:1700px;'></div>