<?

// Any parameter that is a GlobalMockIgnore will be ignored
class GlobalMockIgnore {
}

// raised when a global function is called out of turn
class GlobalMockUnexpectedException extends Exception {
}

// GlobalMock is a Singleton 
// see http://php.net/manual/en/language.oop5.patterns.php
class GlobalMock {
    private $expecting = array();

    // Can't clone singletons
    final private function __clone() {}

    // Can't directly construct singletons
    protected function __construct() {}

    // There can be only one instance of GlobalMock
    public function getInstance() {
        static $instance = null;
        return $instance ? $instance : $instance = new GlobalMock();
    }

    public function testing() {
        putenv('GLOBALMOCK_TESTING=true');
    }

    public function add_expected($name, $arguments, $return) {
        $this->expecting[] = array($name, $arguments, $return);
    }

    public function __call($name, $arguments) {
        if (!getenv('GLOBALMOCK_TESTING')) {
            // If we are not testing, call the global function
            return call_user_func_array($name, $arguments);
        } else {
            list($e_name,
                 $e_arguments,
                 $e_return) = array_shift($this->expecting);
            if (($e_name != $name &&
                 (gettype($e_name) != 'object' ||
                  get_class($e_name) != 'GlobalMockIgnore')) ||
                ($e_arguments != $arguments &&
                 (gettype($e_arguments) != 'object' ||
                  get_class($e_arguments) != 'GlobalMockIgnore'))) {
                throw new GlobalMockUnexpectedException(
                    'Expecting call to "'. $e_name .'" with arguments: '.
                     print_r($e_arguments, true) ."\n".
                     'However "'. $name .'" was called with arguments: '.
                     print_r($arguments, true) ."\n");
            }
            return $e_return;
        }
    }
}

?>
