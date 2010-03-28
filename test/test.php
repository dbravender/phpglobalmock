<?php

require_once('simpletest/autorun.php');
require_once('../global_mock.php');

function call_global_function() {
    return 'called_global_function';
}

class TestGlobalMock extends UnitTestCase {
    function testPassCallThrough() {
        $gm = new GlobalMock(false);
        $this->assertTrue($gm->call_global_function(),
                          'called_global_function');
    }

    function testUnexpectedCall() {
        $gm = new GlobalMock(true);
        try {
            $gm->call_global_function();
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEqual(get_class($e), 
                               'GlobalMockUnexpectedException');
        }
    }

    function testExpectedCall() {
        $gm = new GlobalMock(true);
        $gm->add_expected('call_global_function',
                          array(),
                          'not the global return');
        $this->assertEqual($gm->call_global_function(),
                           'not the global return');
    }

    function testCallWithIgnoredParameters() {
        $gm = new GlobalMock(true);
        $gm->add_expected('call_global_function',
                          new GlobalMockIgnore(),
                          'return value');
        $this->assertEqual($gm->call_global_function('any', 'params'),
                           'return value');
    }

    function testCallWithIgnoredName() {
        $gm = new GlobalMock(true);
        $gm->add_expected(new GlobalMockIgnore(),
                          array('these', 'params'),
                          'return this');
        $this->assertEqual($gm->call_global_function('these', 'params'),
                           'return this');
    }

    function testCallWithBothIgnored() {
        $gm = new GlobalMock(true);
        $gm->add_expected(new GlobalMockIgnore(),
                          new GlobalMockIgnore(),
                          'both ignored');
        $this->assertEqual($gm->any_function('any', 'params'),
                           'both ignored');
    }
}
?>
