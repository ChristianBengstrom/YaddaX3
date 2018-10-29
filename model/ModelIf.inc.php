<?php
/**
 * model/ModelIf.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
interface ModelIf {
    public function create();
    public function update($id, $attr, $newValue);
    public function delete($id);
}
