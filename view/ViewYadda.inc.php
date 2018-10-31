<?php
/**
 * view/ViewLanguage.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */

require_once 'view/View.inc.php';

class YaddaView extends View {

    public function __construct($model) {
        parent::__construct($model);
    }

    private function displayManyLanguages() {
        $yaddas = Yadda::retrievem($this->model->getUid());
        $s = "<div class='haves'>";
        foreach ($yaddas as $yadda) {
            $s .=  sprintf("Date: %s | User: %s, Content: %s<br/><br/>\n"
                , $yadda->getDateintime(), $yadda->getUid(), $yadda->getContent());
        }
        $s .= "</div>";
        return $s;
    }

    private function yaddaForm() {
          $y = sprintf(
                "
                <form action='%s?function=Yadda' method='post' id='yaddaform'> \n
                  <div class='gets'>\n
                        <p>
                              User<br/>
                              <input type='text' name='uid'
                              value='%s'
                              required readonly/>
                        </p>\n
                        <p>
                              Yadda: <br/>
                              <textarea name='content' form='yaddaform' rows='4' cols='50'></textarea>
                        </p>
                        <p><input type='submit' value='Go!'/></p>\n
                  </div>
                \n"
                , $_SERVER['PHP_SELF']
                , Authentication::getLoginId()
          );

          return $y;
   }

    private function displayLanguage() {
        $s = sprintf("<main class='main'>\n%s\n%s</main>\n"
                    , $this->displayManyLanguages()
                    , $this->yaddaForm());
        return $s;
    }

    public function display(){
       $this->output($this->displayLanguage());
    }
}
