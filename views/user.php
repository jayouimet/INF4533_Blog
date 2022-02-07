<?php
require_once "../src/Form/Form.php";

$form = Form::begin('', 'post');
?>
<table style="margin-left:auto;margin-right:auto">
    <?php echo $form->field($model, 'firstname'); ?>
    <?php echo $form->field($model, 'lastname'); ?>
    <?php echo $form->field($model, 'age', Types::NUMBER); ?>
    <?php echo $form->field($model, 'password', Types::PASSWORD); ?>
    <?php echo $form->field($model, 'passwordConfirm', Types::PASSWORD); ?>
    <tr>
        <td>
            <button type="submit">Submit</button>
        </td>
    </tr>
</table>
<?php Form::end(); ?>