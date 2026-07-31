<?php
/**
 * Set keys inside the serialized ccsm_settings option on the local test site.
 * Usage: php setopt.php key=value [key=value ...]
 *        php setopt.php --show
 */
$sock = getenv('HOME') . '/Library/Application Support/Local/run/X6odgxrlw/mysql/mysqld.sock';
$db   = new mysqli(null, 'root', 'root', 'local', null, $sock);
if ($db->connect_error) { fwrite(STDERR, "connect failed: {$db->connect_error}\n"); exit(1); }

$res = $db->query("SELECT option_value FROM wp_options WHERE option_name='ccsm_settings'");
$row = $res->fetch_row();
$opts = $row ? unserialize($row[0]) : array();
if (!is_array($opts)) { $opts = array(); }

$args = array_slice($argv, 1);

if (in_array('--show', $args, true)) {
    foreach (array('colorlib_coming_soon_activation','colorlib_coming_soon_mode',
                   'colorlib_coming_soon_noindex','colorlib_coming_soon_bypass_token') as $k) {
        printf("%-40s %s\n", $k, isset($opts[$k]) ? var_export($opts[$k], true) : '(unset)');
    }
    exit(0);
}

foreach ($args as $pair) {
    list($k, $v) = array_pad(explode('=', $pair, 2), 2, '');
    $opts[$k] = $v;
    echo "set $k = " . var_export($v, true) . "\n";
}

$stmt = $db->prepare("UPDATE wp_options SET option_value=? WHERE option_name='ccsm_settings'");
$ser  = serialize($opts);
$stmt->bind_param('s', $ser);
$stmt->execute();
echo "saved (" . count($opts) . " keys)\n";
