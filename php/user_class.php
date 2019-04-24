<?php

function printUsers () {
    global $db;
    $users = $db->get ("users");
    if ($db->count == 0) {
        echo "<td align=center colspan=4>No users found</td>";
        return;
    }
    foreach ($users as $u) {
        echo "<tr>
            <td>{$u['id']}</td>
            <td>{$u['login']}</td>
            <td>{$u['firstName']} {$u['lastName']}</td>
            <td>
                <a href='index.php?action=rm&id={$u['id']}'>rm</a> ::
                <a href='index.php?action=mod&id={$u['id']}'>ed</a>
            </td>
        </tr>";
    }
}
function action_adddb () {
    global $db;
    $data = Array(
        'login' => $_POST['login'],
        'customerId' => 1,
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'password' => $db->func('SHA1(?)',Array ($_POST['password'] . 'salt123')),
        'createdAt' => $db->now(),
        'expires' => $db->now('+1Y')
    );
    $id = $db->insert ('users', $data);
    header ("Location: index.php");
    exit;
}
function action_moddb () {
    global $db;
    $data = Array(
        'login' => $_POST['login'],
        'customerId' => 1,
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
    );
    $id = (int)$_POST['id'];
    $db->where ("customerId",1);
    $db->where ("id", $id);
    $db->update ('users', $data);
    header ("Location: index.php");
    exit;
}
?>