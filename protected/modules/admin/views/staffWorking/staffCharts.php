<?php
/**
 * Created by PhpStorm.
 * User: iurik
 * Date: 4/1/16
 * Time: 14:41
 */

?>
<div class="row">
    <div id='container'>
    </div>
</div>
    <br/>
<div class="row  buttons">
    <?php echo CHtml::link('Back',Yii::app()->request->urlReferrer,array('class' => 'btn btn-primary',)); ?>
</div><br/>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Staff Working Information</h3>
        </div>
        <div class="panel-body">
            <table id="staffTable" class="display table  table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Time Start</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Direction</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Time Start</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Direction</th>
                        <th>Duration</th>
                    </tr>
                </tfoot>
                <tbody>
                <?php
                if (count($staff)) {
                    foreach ($staff as $k) {
                        echo "<tr>
                                <td>".$k['timestart']."</td>
                                <td>".htmlspecialchars($k['cid_from'])."</td>
                                <td>".htmlspecialchars($k['cid_to'])."</td>
                                <td>".$k['direction']."</td>
                                <td>".$k['durationhhmmss']."</td>
                            </tr>";

                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>