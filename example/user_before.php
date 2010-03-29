<?
mysql_connect('localhost', 'root', '');
mysql_select_db('test');

function get_uid($username) {
    $query = sprintf("select uid from users where username='%s' limit 0,1",
                     mysql_real_escape_string($username));
    $result = mysql_query($query);
    if (!$result) {
        return false;
    }
    list($uid) = mysql_fetch_array($result);
    return $uid;
}

function create_user($username) {
    $query = sprintf("insert into users (username) values ('%s')",
                     mysql_real_escape_string($username));
    $result = mysql_query($query);
}
?>
