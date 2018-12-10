<?php
/**
 * view/ViewLanguage.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */

require_once 'view/View.inc.php';

class YaddaOneView extends View {

    public function __construct($model) {
        parent::__construct($model);
    }

    private function displayOneYadda() {
        $yaddas = Yadda::retrieve2($this->model->getUid(), $this->model->getDateintime());
        $s = "<div class='haves'>";
        foreach ($yaddas as $yadda) {
            $s .=  sprintf("Date: %s | User: %s, Content: %s<br/><br/>\n"
                , $yadda->getDateintime(), $yadda->getUid(), $yadda->getContent()
                );
        }
        $s .= "</div>";
        return $s;
    }

    private function yaddaFormOne() {
          $y = sprintf(
                "
                <form action='%s?function=Oneyadda' method='post' id='yaddaform'> \n
                  <div class='gets'>\n
                        <p>
                              User:
                              <input type='text' name='uid'
                              value='%s'
                              required readonly/>
                        </p>\n
                        <p>
                        <p>
                              To User:
                              <input type='text' name='uid'
                              value='%s'
                              required readonly/>
                        </p>\n
                              Yadda reply: <br/>
                              <textarea name='content' form='yaddaform' rows='4' cols='50'></textarea>
                        </p>
                        <p><input type='submit' value='Go!'/></p>\n
                  </div>
                \n"
                , $_SERVER['PHP_SELF']
                , Authentication::getLoginId()
                , $this->model->getUid()
          );

          return $y;
   }

    private function displayYaddaOne() {
        $s = sprintf("<main class='main'></br> \n%s \n%s</main>\n"
                    , $this->displayOneYadda()
                    , $this->yaddaFormOne());
        return $s;
    }

    public function display(){
       $this->output($this->displayYaddaOne());
    }
}
