<?

// Any parameter that is a GlobalMockIgnore will be ignored
class GlobalMockIgnore {
}

class GlobalMock {
    public $testing = false;
    private $expecting = array();

    function __construct($testing) {
        $this->testing = $testing;
    }

    public function add_expected($name, $arguments, $return) {
        $this->expecting[] = array($name, $arguments, $return);
    }

    public function __call($name, $arguments) {
        if (!$this->testing) {
            // If we are not testing, call the global function
            return call_user_func_array($name, $arguments);
        } else {
            list($e_name,
                 $e_arguments,
                 $e_return) = array_shift($this->expecting);
            if (((gettype($e_name) != 'object' &&
                  get_class($e_name) != 'GlobalMockIgnore') ||
                 $e_name != $name) ||
                ((gettype($e_arguments) != 'object' &&
                  get_class($e_arguments) != 'GlobalMockIgnore') ||
                 $e_arguments != $arguments)) {
                die('Expecting call to "'. $e_name .'" with arguments: '.
                     print_r($e_arguments, true) ."\n".
                     'However "'. $name .'" was called with arguments: '.
                     print_r($arguments, true) ."\n");
            }
            return $e_return;
        }
    }
}

?>