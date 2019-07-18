<?php
/* @var $this MailDeliveryController */
/* @var $form CActiveForm  */
$this->pageTitle=Yii::app()->name .' - '.Yii::t('admin/delivery','title_delivery');
$this->breadcrumbs=array(
	'Delivery miALERT',
);
?>
<div id='ajax_loader' style="display: none;z-index:100000" class="ui-widget-overlay">
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" style="position: fixed; left: 50%; top: 50%; z-index:3000000"/>
</div>
<div class="row">
    <div id="messages"></div>
    <div id="tabs">
         <ul>
            <li><a href="#deliveryTab"><?php echo Yii::t('admin/delivery', 'E-mail');?></a></li>
            <li><a href="#smsTab"><?php echo Yii::t('admin/delivery', 'SMS Settings');?></a></li>
        </ul>
        <div id="deliveryTab">
            <div class="row">
                <?php $mailDelivery = $this->beginWidget('CActiveForm', array(
                    'id'=>'mail-form',
                    'enableAjaxValidation' => true,
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    'focus'=>array($modelMail,'host'),
                    'enableClientValidation'=>true,
                )); ?>
               <fieldset>
                    <legend><?php echo Yii::t('admin/delivery', 'SMTP Settings')?></legend>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="control-label" for="host"><?php echo $mailDelivery->label($modelMail,Yii::t('admin/delivery','Host name')); ?></label>
                                <div class="input-group date col-sm-4">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map-o"></i>
                                    </span>
                                    <?php echo $mailDelivery->textField($modelMail,'host', array('class'=>'form-control', 'style'=>'width:250px')) ?>
                                </div>
                                <?php echo $mailDelivery->error($modelMail,'host', array('class'=>'alert alert-danger', 'style'=>'margin-top:5px;')) ?>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="control-label" for="port"><?php echo $mailDelivery->label($modelMail,Yii::t('admin/delivery','Port')); ?></label>
                                <div class="input-group date col-sm-4">
                                    <span class="input-group-addon">
                                        <i class="fa  fa-map-marker"></i>
                                    </span>
                                    <?php echo $mailDelivery->textField($modelMail,'port', array('class'=>'form-control', 'style'=>'width:250px')) ?>
                                </div>
                                <?php echo $mailDelivery->error($modelMail,'port', array('class'=>'alert alert-danger', 'style'=>'margin-top:5px;')) ?>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="control-label" for="security_type"><?php echo $mailDelivery->label($modelMail,Yii::t('admin/delivery','Security')); ?></label>
                                    <div class="input-group date col-sm-4">
                                        <span class="input-group-addon">
                                            <i class="fa fa-key"></i>
                                        </span>
                                        <div class="controls">
                                        <?php
                                            echo $mailDelivery->dropDownList($modelMail, 'security_type',Yii::app()->params['mail_security'], array('class'=>'form-control',
                                                'style'=>'width:250px'));
                                        ?>
                                        </div>
                				    </div>
                                </div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="control-label" for="login_name"><?php echo $mailDelivery->label($modelMail,Yii::t('admin/delivery','User')); ?></label>
                                <div class="input-group date col-sm-4">
                                    <span class="input-group-addon">
                                        <i class="fa  fa-user"></i>
                                    </span>
                                    <?php echo $mailDelivery->textField($modelMail,'login_name', array('class'=>'form-control', 'style'=>'width:250px')) ?>
                                </div>
                                <?php echo $mailDelivery->error($modelMail,'login_name', array('class'=>'alert alert-danger', 'style'=>'margin-top:5px;')) ?>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="control-label" for="passwd"><?php echo $mailDelivery->label($modelMail,Yii::t('admin/delivery','Password')); ?></label>
                                <div class="input-group date col-sm-4">
                                    <span class="input-group-addon">
                                        <i class="fa  fa-user-secret"></i>
                                    </span>
                                    <?php echo $mailDelivery->textField($modelMail,'passwd', array('class'=>'form-control', 'style'=>'width:250px')) ?>
                                </div>
                                <?php echo $mailDelivery->error($modelMail,'passwd', array('class'=>'alert alert-danger', 'style'=>'margin-top:5px;')) ?>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="control-label" for="from_text"><?php echo $mailDelivery->label($modelMail,Yii::t('admin/delivery','From')); ?></label>
                                <div class="input-group date col-sm-4">
                                    <span class="input-group-addon">
                                        <i class="fa fa-street-view"></i>
                                    </span>
                                    <?php echo $mailDelivery->textField($modelMail,'from_text', array('class'=>'form-control', 'style'=>'width:250px')) ?>
                                </div>
                                <?php echo $mailDelivery->error($modelMail,'from_text', array('class'=>'alert alert-danger', 'style'=>'margin-top:5px;')) ?>
                            </div>   
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-lg-3">
                                <?php
                                    echo CHtml::submitButton(Yii::t('admin/delivery','Save changes'),
                                        array(
                                            'class'=>'btn btn-primary',
                                            'ajax'=>array(
                                                'type'=>'POST',
                                                'dataType'=>'json',
                                                'url'=>Yii::app()->createUrl('admin/delivery/mailSave'),
                                                'success'=>'function(data) {
                                                    if(data.success =="yes")
                                                    {
                                                       location.reload(); 
                                                    } else if (data.success == "update") {
                                                        $("#messages").html("'."<div class=\'alert alert-success\'><button data-dismiss=\'alert\' class=\'close\' type=\'button\'><i class=\'fa  fa-times\'></i></button><strong>".Yii::t('admin/delivery', 'Saved Successfuly')."</div>".'");
                                                        setTimeout(function(){ 
                                                            $(".alert").fadeOut("slow"); 
                                                        }, 5000 );
                                                    }
                                                    else
                                                    {
                                                        $.each(data, function(key, val) 
                                                        {
                                                          $("#mail-form #"+key+"_em_").text(val);
                                                          $("#mail-form #"+key+"_em_").show();
                                                          $("div[for="+key+"]").show();
                                                        });
                                                    }
                                                }',
                                            )
                                        )
                                    ); 
                                ?>
                                </div>
                                &nbsp;<br/><br/>
                                <div class="col-lg-5">
                                    <div id="messagesTestMail" class="col-lg-10"></div>
                                </div><br/>
                                <div class="clearfix"></div>
                                <div class="col-lg-4">
                                <label for="your_email">Your Email :</label>
                                <?php
                                echo CHtml::textField('your_email', '', array('class'=>'form-control'))."<br/>";
                                echo CHtml::submitButton(Yii::t('admin/delivery','Test Mail'),
                                    array(
                                        'class'=>'btn btn-primary',
                                        'id'=> 'testEmailButton',
                                        'ajax'=>array(
                                            'type'=>'POST',
                                            'dataType'=>'json',
                                            'data' => array("email_to_send"=>'js:$("#your_email").val()'),
                                            'url'=>Yii::app()->createUrl('admin/delivery/testEmail'),
                                            'success'=>'function(dd) {
                                                if (dd.success != "" && typeof(dd.success) != "undefined"){
                                                    $("#messagesTestMail").html(dd.success).show();
                                                    $("#messagesTestMail").addClass("alert alert-success");
                                                    setTimeout(function(){
                                                            $("#messagesTestMail").fadeOut("slow");
                                                            $("#messagesTestMail").removeClass("alert alert-success");
                                                        }, 5000
                                                    );
                                                } else if (dd.error != "") {
                                                    $("#messagesTestMail").html(dd.msg).show();
                                                    $("#messagesTestMail").addClass("alert alert-danger");
                                                    setTimeout(function(){
                                                            $("#messagesTestMail").fadeOut("slow");
                                                            $("#messagesTestMail").removeClass("alert alert-danger");
                                                        }, 8000
                                                    );
                                                }
                                                $("#ajax_loader").ajaxStop(function(){
                                                    $(this).hide();
                                                });
                                            }',
                                        )
                                    )
                                );
                                ?>
                                </div>
                        </div>
                    </div>
                </fieldset>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div id="smsTab">
            <div class="row">
                <?php $smsDelivery = $this->beginWidget('CActiveForm', array(
                    'id'=>'access-form',
                    'enableAjaxValidation' => true,
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    'focus'=>array($modelSms,'host'),
                    'enableClientValidation'=>true,
                )); ?>
                <?php echo $smsDelivery->hiddenField($modelSms,'id_settings'); ?>
                <fieldset>
                    <legend>SMS Settings</legend>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="control-label" for="sms_url"><?php echo $smsDelivery->label($modelSms,Yii::t('admin/delivery','SMS Url')); ?></label>
                                <div class="input-group date col-sm-4">
                                    <span class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                    <?php echo $smsDelivery->textField($modelSms,'sms_url', array('class'=>'form-control', 'style'=>'width:250px')) ?>
                                </div>
                                <?php echo $smsDelivery->error($modelSms,'sms_url', array('class'=>'alert alert-danger', 'style'=>'margin-top:5px;')) ?>
                            </div>   
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-3">
                            <?php
                                echo CHtml::submitButton(Yii::t('admin/delivery','Save changes'),
                                    array(
                                        'class'=>'btn btn-primary',
                                        'ajax'=>array(
                                            'type'=>'POST',
                                            'dataType'=>'json',
                                            'url'=>Yii::app()->createUrl('admin/delivery/smsSave'),
                                            'success'=>'function(data) {
                                                if(data.success =="yes")
                                                {
                                                   location.reload(); 
                                                } else if (data.success =="update"){
                                                    $("#messages").html("'."<div class=\'alert alert-success\'><button data-dismiss=\'alert\' class=\'close\' type=\'button\'><i class=\'fa  fa-times\'></i></button><strong>Well done!</strong>".Yii::t('admin/delivery', 'Saved Successfuly')."</div>".'");
                                                    setTimeout(function(){ 
                                                        $(".alert").fadeOut("slow"); 
                                                    }, 5000 );   
                                                }
                                                else
                                                {
                                                    $.each(data, function(key, val) 
                                                    {
                                                      $("#mail-form #"+key+"_em_").text(val);
                                                      $("#mail-form #"+key+"_em_").show();
                                                      $("div[for="+key+"]").show();
                                                    });
                                                }
                                            }',
                                        )
                                    )
                                ); 
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <br/><br/>
                        <div class="col-lg-5">
                            <div id="messagesTestSMS" class="col-lg-10"></div>
                        </div><br/>
                        <div class="clearfix"></div>
                        <div class="col-lg-4">
                            <label for="your_sms">Your SMS Number :</label>
                            <?php
                            echo CHtml::textField('your_sms', '', array('class'=>'form-control'))."<br/>";
                            echo CHtml::submitButton(Yii::t('admin/delivery','Test SMS'),
                                array(
                                    'class'=>'btn btn-primary',
                                    'id'=> 'testSMSButton',
                                    'ajax'=>array(
                                        'type'=>'POST',
                                        'dataType'=>'json',
                                        'data' => array("sms_to_send"=>'js:$("#your_sms").val()'),
                                        'url'=>Yii::app()->createUrl('admin/delivery/testSMS'),
                                        'success'=>'function(dl) {
                                                    console.log(dl)
                                                if (dl.success != "" && typeof(dl.success) != "undefined"){
                                                    $("#messagesTestSMS").html(dl.success).show();
                                                    $("#messagesTestSMS").addClass("alert alert-success");
                                                    setTimeout(function(){
                                                            $("#messagesTestSMS").fadeOut("slow");
                                                            $("#messagesTestSMS").removeClass("alert alert-success");
                                                        }, 5000
                                                    );
                                                } else if (dl.error != "") {
                                                    $("#messagesTestSMS").html(dl.msg).show();
                                                    $("#messagesTestSMS").addClass("alert alert-danger");
                                                    setTimeout(function(){
                                                            $("#messagesTestSMS").fadeOut("slow");
                                                            $("#messagesTestSMS").removeClass("alert alert-danger");
                                                        }, 8000
                                                    );
                                                }
                                                $("#ajax_loader").ajaxStop(function(){
                                                    $(this).hide();
                                                });
                                            }',
                                    )
                                )
                            );
                            ?>
                        </div>

                    </div>
                </fieldset>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>