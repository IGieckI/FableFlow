<?php

use PHPUnit\Framework\TestCase;

require_once('resources/db/config.php');

final class DbTest extends TestCase {

    public function testConnectionToDatabase(): void {
        $dbhelper = new DbHelper(SERVER, USER, PASS, DB, PORT);
        $this->assertEquals(TRUE, $dbhelper->isConnectionAlive());
    }

    public function testDisconnectionToDatabase() : void {
        $dbhelper = new DbHelper(SERVER, USER, PASS, DB, PORT);
        $dbhelper->disconnect();
        $this->expectException(Error::class);
        $dbhelper->isConnectionAlive();
    }

}
