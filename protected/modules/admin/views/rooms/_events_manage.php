<?php 
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
    <tr>
        <th>Room Number</th>
        <th>Device Description</th>
        <th>Call Type</th>
        <th>Global Event</th>
        <th>Action</th>
    </tr>
<?php foreach($model as $n=>$event): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::decode($event->nb_room); ?></td>
    <td><?php echo CHtml::decode($event->device_description); ?>&nbsp;</td>
    <td><?php echo CHtml::decode($event->call_type_desc); ?>&nbsp;</td>
    <td><?php echo CHtml::decode($event->eventMessages); ?></td>
    <td>
        <a href="#" onclick="javascript:openUpdateEventsForm(<?php echo $event->id_event;?>, <?php echo $event->id_room;?>); return false;"><i class="fa fa-pencil"></i></a>&nbsp;
        <a href="#"><i class="fa fa-trash-o" onclick="javascript:deleteEvent(<?php echo $event->id_event;?>, <?php echo $event->id_room;?>, '<?php echo Yii::t('admin/rooms', 'Are you sure you want to delete this item?');?>'); return false;"></i></a>&nbsp;
    </td>
  </tr>
<?php endforeach; ?>
</table>