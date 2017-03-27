<?php
    require_once("env.php");
    $conn = new mysqli($dbr[0], $dbr[1], $dbr[2], $dbr[3]); // New DB Connection

    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    if ( isset( $_GET['word'] ) ) {
        // var_dump($_GET['word']);
        // /sigh
        $stmt = $conn->prepare("SELECT * FROM entries WHERE word = ?");
        $stmt->bind_param('s', $_GET['word'] );
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
    }
?>

<style>
    h1{
        text-align: center;
    }

    word {
        font-weight: bold;
        font-size: 24px;
        margin-right: 50px;
    }

    word_type {
        font-weight: bold;
        font-size: 20px;
        margin-right: 50px;
    }

    #search, #def{
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
        position: static;
        width: 400px;
    }

    #search_form {
        width: 100%;
    }
</style>

<h1>Dictionary</h1>
<div id="search">
    <form method="get">
            <input id="search_form" type="search" name="word" placeholder=" <?= ( isset( $_GET['word'] ) ? "Word: " .  $_GET['word'] : 'Enter A Word' ) ?> "/>
    </form>
</div>

<div id='def'>
    <word><?= $row[0] ?></word>
    <word_type><?= $row[1] ?></word_type>
    <definition><?= $row[2] ?></definition>
</div>