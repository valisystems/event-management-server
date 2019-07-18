<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 16.02.15
 * Time: 22:57
 */
?>
<br/>
<table class="hover display" id="resultEvent" data-page-length='25'>
    <thead>
        <tr>
            <th data-sortable="true">Time</th>
            <th data-sortable="true" data-field="device_description">Device Description</th>
            <th data-sortable="true">Room #</th>
            <th data-sortable="true">Receiver</th>
            <th data-sortable="true">Serial Number</th>
            <th data-sortable="true">Code</th>
            <th data-sortable="true">Type Notification</th>
        </tr>
    </thead>
    <tbody>
<?php foreach($model as $n=>$event){

//        foreach($eventLogs as $event){
//            print_r($event);
    $code = (isset($listCallType[$event['code']])) ? CHtml::decode($listCallType[$event['code']]) : CHtml::decode($event['code']).' <span class="label label-important">('.Yii::t('admin/eventsreports', 'Wrong Call Type').')</span>';
            ?>
            <tr class="<?php echo $n%2?'even':'odd';?>">
                <td><?php echo CHtml::decode($event['current_time']); ?></td>
                <td><?php echo CHtml::decode($event['device_description']); ?></td>
                <td><?php echo CHtml::decode($event['nb_room']); ?></td>
                <td><?php echo CHtml::decode($event['receiver']); ?>&nbsp;</td>
                <td><?php echo CHtml::decode($event['serial_number']); ?>&nbsp;</td>
                <td><?php echo $code; ?>&nbsp;</td>
                <td><?php echo CHtml::decode(Yii::app()->params['pick_event_type'][$event['type_notification']]); ?></td>
            </tr>
<?php } ?>
    </tbody>
</table>