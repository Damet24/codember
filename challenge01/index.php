<?php


function normalizeUsers($str)
{
    $data = explode(PHP_EOL, $str);

    $_data = [];
    $tmp = "";
    foreach ($data as $i) {
        if ($i[0] == "") {
            $_data[] = $tmp;
            $tmp = "";
        } else {
            $tmp .= " " . $i;
        }
    }

    $data = $_data;
    unset($_data);

    $users = [];
    foreach ($data as $item) {
        if ($item != "") {
            $r = [];
            foreach (explode(" ", $item) as $i) {
                $t = explode(":", $i);
                $r[$t[0]] = $t[1];
            }
            $users[] = $r;
        }
    }

    return $users;
}


$file = fopen(__DIR__ . "/users.txt", "r");
$str = fread($file, filesize(__DIR__ . "/users.txt"));
$users = normalizeUsers($str);

$requiredField = [
    'usr',
    'eme',
    'psw',
    'age',
    'loc',
    'fll',
];

$invalid_users = [];

for ($i = 0; $i < count($users); $i++) {
    foreach ($requiredField as $field) {
        if (!isset($users[$i][$field])) {
            echo "Falta el campo " . $field . " en el usuario numero " . $i . PHP_EOL;
            $invalid_users[] = $i;
            continue;
        }
    }
}

foreach($invalid_users as $i) {
    unset($users[$i]);
}

$a = end($users)['usr'];
$n = count($users);

echo "============================================" . PHP_EOL;
echo "        usuario: " . $n . $a . "             " . PHP_EOL;
echo "============================================" . PHP_EOL;
