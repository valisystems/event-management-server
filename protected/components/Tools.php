<?php
class Tools {
   static public function inlineEdit($data, $field, $type='text') {
        return '<div class="inlineEdit" id="' . $data['id_map'] . '" field="'.$field.'" type="'.$type.'">' . $data[$field] . '</div>';
    }
}
?>