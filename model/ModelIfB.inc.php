<?php
/**
 * model/ModelIf.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
interface ModelIfB {
    public function createYadda();
    public function update($uid, $content);
    public function delete($dateintime);
}
