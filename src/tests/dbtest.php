<?php

use PHPUnit\Framework\TestCase;

require_once('resources/db/config.php');

final class DbTest extends TestCase {

    public function testConnectionToDatabase(): void {
        $db = new DbHelper(SERVER, USER, PASS, DB, PORT);
        $this->assertEquals(TRUE, $db->isConnectionAlive());
    }

    public function testDisconnectionToDatabase() : void {
        $db = new DbHelper(SERVER, USER, PASS, DB, PORT);
        $db->disconnect();
        $this->expectException(Error::class);
        $db->isConnectionAlive();
    }

}
