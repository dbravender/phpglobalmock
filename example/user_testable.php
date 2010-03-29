<?
require_once('../global_mock.php');
$gm = GlobalMock::getInstance();

$gm->mysql_connect('localhost', 'root', '');
$gm->mysql_select_db('test');

function get_uid($username) {
    $gm = GlobalMock::getInstance();
    $query = sprintf("select uid from users where username='%s' limit 0,1",
                     $gm->mysql_real_escape_string($username));
    $result = $gm->mysql_query($query);
    if (!$result) {
        return false;
    }
    list($uid) = $gm->mysql_fetch_array($result);
    return $uid;
}

function create_user($username) {
    $gm = GlobalMock::getInstance();
    $query = sprintf("insert into users (username) values ('%s')",
                     $gm->mysql_real_escape_string($username));
    $result = $gm->mysql_query($query);
}
?>
