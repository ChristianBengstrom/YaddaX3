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

    private function displayAllYaddas() {
        $yaddas = Yadda::retrievem($this->model->getUid());
        $s = "<h2>Timeline</h2>";
        $s .= "<div class='haves'>";
        foreach ($yaddas as $yadda) {
            $s .=  sprintf("User: %s | Date: %s <br />\n
                            <img src='getYaddaImg.inc.php?uid=%s&amp;type=YaddaIMG&amp;dateintime=%s' width='300' height='200' alt='Kilroy was here'/> <br /> \n
                            - %s <br /> \n
                            <a href='%s?function=Oneyadda&amp;tid=%s&amp;uid=%s'>View more</a><br/><br/>\n"
                , $yadda->getUid(), $yadda->getDateintime(), $yadda->getUid(), $yadda->getDateintime(), $yadda->getContent(), $_SERVER['PHP_SELF'], $yadda->getDateintime(), $yadda->getUid()
                );
        }
        $s .= "</div>";
        return $s;
    }

    private function yaddaForm() {
          $y = sprintf(
                "
                <form action='%s?function=Yadda' method='post' id='yaddaform' enctype='multipart/form-data'> \n
                  <div class='gets'>\n
                        <p>
                              <input type='hidden' name='uid'
                              value='%s'
                              required readonly/>
                        </p>\n
                        <p>
                              Yadda: <br/>
                              <textarea name='content' form='yaddaform' rows='4' cols='50'></textarea>
                        </p>
                        <p>\n
                            Prifile Image:<br/>
                            <input type='hidden' name='MAX_FILE_SIZE' value='131072'/> required readonly <!-- Remember max file size! -->
                            <input type='file' id='bild' name='img'/>
                        </p>\n
                        <p><input type='submit' value='Go!'/></p>\n
                  </div>
                \n"
                , $_SERVER['PHP_SELF']
                , Authentication::getLoginId()
          );

          return $y;
   }

   private function sidebar() {
       $s = sprintf("
       <aside class='sidebar' style='background-color: #f1f1f1;'>
         <div class='this_user'>
           <h3>%s</h3>
           <img src='getProfileImg.inc.php?uid=%s&amp;type=%s' width='300' height='200' alt='Kilroy was here'/>
         </div>
       </aside><br />", $_SESSION['uid'], $_SESSION['uid'], 'ProfileIMG');

       return $s;
       }

    private function displayLanguage() {
        $s = sprintf("<main class='main'>\n%s\n%s\n%s</main>\n"
                     , $this->sidebar()
                     , $this->displayAllYaddas()
                     , $this->yaddaForm());
        return $s;
    }

    public function display(){
       $this->output($this->displayLanguage());
    }
}
