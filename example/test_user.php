<?
require_once('../test/simpletest/autorun.php');
require_once('../global_mock.php');

class TestUser extends UnitTestCase {
    function testInitialization() {
        $gm = GlobalMock::getInstance();
        $gm->testing();
        $gm->add_expected('mysql_connect',
                          new GlobalMockIgnore(),
                          true);
        $gm->add_expected('mysql_select_db',
                          array('test'),
                          true);
        require_once('user_testable.php');
    }

    function testGetUid() {
        $gm = GlobalMock::getInstance();
        $gm->testing();
        $gm->add_expected('mysql_real_escape_string',
                          array('angelo_luis_martin'),
                          'angelo_luis_martin');
        $gm->add_expected('mysql_query',
                          array("select uid from users where username='angelo_luis_martin' limit 0,1"),
                          'results_of_search');
        $gm->add_expected('mysql_fetch_array',
                          array('results_of_search'),
                          array('1'));
        $this->assertEqual(get_uid('angelo_luis_martin'), '1');
    }

    function testCreateUser() {
        $gm = GlobalMock::getInstance();
        $gm->testing();
        $gm->add_expected('mysql_real_escape_string',
                          array('dan'),
                          'dan');
        $gm->add_expected('mysql_query',
                          array("insert into users (username) values ('dan')"),
                          null);
        create_user('dan');
    }
}
?>
