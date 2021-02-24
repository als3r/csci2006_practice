<?php
require_once 'Page.php';

/**
 * Class PageHome
 *
 * Homepage
 */
class PageHome extends Page
{
    /**
     * Title of the page
     *
     * @var string
     */
    public $title = 'ArtWork Store';

    /**
     * Name of the page
     */
    public const NAME = 'Home';


    /**
     * Get <head> tag
     *
     * @return string
     */
    public function getHead()
    {
        $output = '
          <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <title>' . $this->getTitle() . '</title>
              <link rel="stylesheet" href="_aux/default.css">
              <!-- Fonts -->              
              <link href="http://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet" type="text/css">
              <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
              <link rel="stylesheet" href="css/homepage.css">
          </head>';
        return $output;
    }

    /**
     * Get contents of the body tag
     */
    public function getBody()
    {
        $output = '<body>';
        $output .= $this->getHeader();
        $output .= $this->getMain();
        $output .= $this->getFooter();
        $output .= '</body>';
        return $output;
    }

    /**
     * Get contents of the main block
     *
     * @return string
     */
    public function getMain()
    {
        // First version of the homepage based on one of the assignments from CS2005 course
        $output = '
                    <header class="homepage-banner">
                        <img src="images/veermeer-view-of-house--background.jpg" class="banner" alt="Background Picture of Veermeer\'s \'View of House\'" title="Background Picture of Veermeer\'s \'View of House\'">
                        <div class="banner--title">
                            <h1>Dutch Portraits of the Golden Age</h1>
                            <h2>From the Rijks Museum</h2>
                            <span><a href="#start">Start</a></span>
                        </div>
                
                    </header>
                
                    <article>
                        <a name="start"></a>
                        <div class="highlights">
                            <h2>Latest Additions</h2>
                            <div class="highlights--container">
                                <div class="highlights--media">
                                    <img src="images/mosaic-f.jpg" alt="...">
                                </div>
                                <div class="highlights--text">
                                    <h4>Portrait of Maritge Claesdr Vooght</h4>
                                    <p><em>Frans Hals, 1639</em></p>
                                    <p>Maritge Vooght is here portrayed in a traditional pose, proudly sitting upright and looking straight out at the viewer</p>
                                    <a href="#" class="highlights--button">Read More</a>
                                </div>
                            </div>
                            <div class="highlights--container">
                                <div class="highlights--media">
                                    <img src="images/mosaic-g.jpg" alt="...">
                                </div>
                                <div class="highlights--text">
                                    <h4>Portrait of Johannes Wtenbogaert</h4>
                                    <p><em>Rembrandt, 1633</em></p>
                                    <p>Wtenbogaert’s face is more realistically modelled than his hands, which may have been done by a pupil in Rembrandt’s workshop</p>
                                    <a href="#" class="highlights--button">Read More</a>
                                </div>
                            </div>
                        </div>
                
                        <div class="mosaic">
                            <div class="mosaic-item mosaic--a"><img src="images/mosaic-a.jpg" alt="..."></div>
                            <div class="mosaic-item mosaic--b"><img src="images/mosaic-b.jpg" alt="..."></div>
                            <div class="mosaic-item mosaic--c"><img src="images/mosaic-c.jpg" alt="..."></div>
                            <div class="mosaic-item mosaic--d"><img src="images/mosaic-d.jpg" alt="..."></div>
                            <div class="mosaic-item mosaic--e"><img src="images/mosaic-e.jpg" alt="..."></div>
                            <div class="mosaic-item mosaic--f"><img src="images/mosaic-f.jpg" alt="..."></div>
                            <div class="mosaic-item mosaic--g"><img src="images/mosaic-g.jpg" alt="..."></div>
                            <div class="mosaic-item mosaic--h"><img src="images/mosaic-h.jpg" alt="..."></div>
                            <div class="mosaic-item mosaic--i"><img src="images/mosaic-i.jpg" alt="..."></div>
                            <div class="mosaic-item mosaic--j"><img src="images/mosaic-j.jpg" alt="..."></div>
                            <div class="mosaic-item mosaic--k"><img src="images/mosaic-k.jpg" alt="..."></div>
                        </div>
                    </article>';
        return $output;
    }
}