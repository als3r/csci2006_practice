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
     * Get Main section
     *
     * @return string
     */
    public function getMain()
    {
        $output = '';
        $output .= '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sodales molestie erat a convallis. Cras id blandit purus. Aliquam eu nisl non ante sagittis tristique. Suspendisse gravida sapien quis risus tincidunt mollis. Quisque eget luctus justo, at facilisis ex. Donec pellentesque, dui sit amet finibus vestibulum, purus purus luctus ipsum, ac pellentesque sapien ante sed velit. Nulla nec enim eu ex malesuada condimentum a sit amet metus. Praesent volutpat diam non posuere maximus. Duis tempor luctus consectetur. Etiam tempus volutpat sollicitudin. Morbi finibus tortor ut sollicitudin imperdiet. Sed vitae diam id leo tristique dictum eu eget dui.</p>';
        $output .= '<p>Etiam convallis gravida risus, sit amet feugiat orci semper quis. Suspendisse elementum, nibh sit amet blandit porta, mauris dui mollis diam, non porttitor dolor tortor et nunc. Sed sit amet venenatis eros, ac vulputate est. Vivamus ullamcorper arcu nec ipsum ultricies tincidunt. Donec viverra enim a posuere porta. Morbi at mattis elit. Nam aliquet pulvinar faucibus. Maecenas nec lorem eget magna hendrerit dapibus. Pellentesque congue neque et ipsum imperdiet hendrerit. Aliquam ullamcorper aliquam elit a laoreet. Suspendisse sed dolor lectus. Donec enim sapien, faucibus eget enim vitae, cursus eleifend eros. Curabitur eu tempus odio. Aliquam nunc magna, faucibus a ex quis, semper varius arcu. Suspendisse nec velit nibh.</p>';
        $output .= '<p>Mauris sed iaculis turpis. Nunc sit amet ex et tellus pretium luctus vel vitae ante. Nullam in consequat erat, nec luctus lacus. Nulla porta egestas vehicula. Suspendisse sed rutrum ligula. Cras dictum sagittis neque, vitae ultrices dolor luctus vitae. Curabitur lobortis vehicula enim, at euismod ligula dapibus at. Nam eu leo vel leo feugiat imperdiet elementum id enim. Pellentesque at risus nec tortor tincidunt venenatis.</p>';
        $output .= '<p>Nullam dapibus dictum magna, id vulputate nulla suscipit vitae. Integer sem dolor, condimentum a pellentesque auctor, pharetra at orci. Pellentesque risus leo, sagittis sit amet pretium id, tincidunt faucibus massa. Nam nisi neque, molestie eget elit non, vehicula porttitor justo. Ut ut quam vel velit fermentum hendrerit. Nulla facilisi. Nulla non efficitur leo, in eleifend risus. Aenean tincidunt, dolor a laoreet hendrerit, libero erat pellentesque quam, sed cursus libero lectus eget neque.</p>';
        $output .= '<p>Ut consectetur orci quis enim pulvinar blandit. Curabitur aliquam, mauris ac ornare rutrum, lectus lacus egestas orci, quis lobortis eros diam non diam. Vivamus lacinia felis a nibh fringilla semper. In nec dictum mauris. Suspendisse ornare dignissim velit, vel lacinia dui efficitur non. Nunc tempus tellus id libero porta placerat. Nulla sed volutpat dolor, eget tempor nulla. Vestibulum sed accumsan sem. Curabitur venenatis laoreet nibh in convallis. Fusce erat dolor, aliquet eu sagittis eleifend, hendrerit quis ante. Pellentesque ut nulla viverra, ornare urna vel, rutrum sem. Ut luctus tristique aliquet. Vivamus non tempor orci. Aenean faucibus lorem enim, vel dignissim nulla consequat eu. Suspendisse eu urna nisi. Proin id sem a nibh pellentesque faucibus id nec quam.</p>';
        return $output;
    }
}