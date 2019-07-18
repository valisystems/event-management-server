<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 3/17/16
 * Time: 14:57
 */
$staffInfo = Yii::app()->session['stafInfo'];
Yii::import('application.modules.admin.models.Maps');
Yii::import('application.modules.admin.models.Rooms');
Yii::import('application.modules.admin.models.Patients');
Yii::import('application.modules.admin.models.ResidentsOfRooms');

$rooms = Rooms::model()->findAllByAttributes(array('id_map'=>$staffInfo['id_map']));
?>
<div class="row" >
    <div class="col-xs-6 col-md-3">
        <a href="#" class="thumbnail">
            <img src="<?php echo $staffInfo['avatar'];?>" alt="<?php echo $staffInfo['name'];?>">
        </a>
    </div>
    <div class="col-xs-6 col-md-6">
        <h2><b><?php echo $staffInfo['name'];?></b></b></h2>
        <h4><?php echo $staffInfo['buildingName'];?></h4>
        <h4><?php echo $staffInfo['name_map'];?></h4>
        <h4><?php echo $staffInfo['ext_number'];?></h4>
    </div>
</div>
<div class="row">
    <div class="col-xs12 col-md-12 col-xs-12">
        <form id="staff-authentification" method="post" action="/site/staffCheckIn">
       <?php
       $cc = 0;

       foreach ($rooms as $v) {
           if ($cc == 0) {
               echo "<div class='row'>";
           }

       ?>
           <div class=" col-xs-3 col-md-3 col-xs-3">
               <div class="panel panel-primary">
                   <div class="panel-heading">
                       <div class="row">
                           <h3 class="panel-title">
                                   <div class="col-xs-2 col-md-2 col-xs-2">
                                    <input type="checkbox" name="staff_rooms[]" value="<?php echo $v['id_room']; ?>" class="icheckbox_polaris"/>
                                   </div>
                                   <div class="col-xs-10 col-md-10 col-xs-10">
                                       <?php echo Yii::t('site/loginstaff','Room ')?> - <?php echo $v['nb_room']?>
                                   </div>
                           </h3>
                       </div>

                   </div>
                   <div class="panel-body">
                       <ul class="list-group">
                           <li class='list-group-item  list-group-item-success'><?php echo Yii::t('site/loginstaff','Patients')?></li>
                       <?php
                       $patientInfo = Patients::model()->with(array('residentsOfRooms' => array('condition' => 'id_room = '.$v['id_room'])))->findAll();
                       foreach($patientInfo as $k) {
                       ?>
                           <li class="list-group-item"><?php echo $k['first_name'].' '.$k['last_name'];?></li>
                       <?php
                       }
                       ?>
                       </ul>
                   </div>
               </div>
           </div>
       <?php
           //echo $cc;
           if ($cc == 3) {
               echo "</div>";
               $cc = 0;
           } else $cc++;
       }
       if ($cc > 0 && $cc < 4) {
           echo "</div>";
       }
       ?>
            <div class="row buttons">
                <?php echo CHtml::SubmitButton('Finish', array('class' => 'btn btn-primary','onclick'=>'return selectRoom(event);')); ?>
            </div>
        </form>
    </div>
</div>
