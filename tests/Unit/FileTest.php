<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileTest extends TestCase
{
    private function logAsGetURIAssertStatusError(int $idUser, string $uri, int $idRoute, int $status, int $errorNb)
    {
        $response = $this->logAsGetURIAssertStatus($idUser, $uri, $idRoute, $status);
        $response->assertSessionHas('error', $errorNb);
    }

    private function getURIAssertStatusError(string $uri, int $idRoute, int $status, int $errorNb)
    {
        $response = $this->getURIAssertStatus($uri, $idRoute, $status);
        $response->assertSessionHas('error', $errorNb);
    }

    private function logAsGetURIAssertStatus(int $idUser, string $uri, int $idRoute, int $status)
    {
        $user = User::where('id', $idUser)->first();
        $this->be($user);
        $response = $this->getURIAssertStatus($uri, $idRoute, $status);
        return $response;
    }

    private function getURIAssertStatus(string $uri, int $idRoute, int $status)
    {
        $response = $this->get(route($uri, $idRoute));
        $response->assertStatus($status);
        return $response;
    }

    /*
     * File show
     */
    public function testURIShowGuest()
    {
        $this->getURIAssertStatusError('files.show', 1, 302, 3);
    }

    public function testURIShowLoggedOwner()
    {
        $this->logAsGetURIAssertStatus(1, 'files.show', 1, 200);
    }

    public function testURIShowLoggedUnauthorized()
    {
        $this->logAsGetURIAssertStatusError(2, 'files.show', 1, 404,  1);
    }

    public function testURIShowNonExistent()
    {
        $this->logAsGetURIAssertStatus(1, 'files.show', 1000, 404, 5);
    }

    /*
     * File edit
     */
    public function testURIEditGuest()
    {
        $this->getURIAssertStatusError('files.edit', 1, 302, 3);
    }

    public function testURIEditLoggedOwner()
    {
        $this->logAsGetURIAssertStatus(1, 'files.edit', 1,200);
    }

    public function testURIEditLoggedUnauthorized()
    {
        $this->logAsGetURIAssertStatusError(2, 'files.edit', 1,404, 1);
    }

    public function testURIEditLoggedNonExistent()
    {
        $this->logAsGetURIAssertStatusError(1, 'files.edit', 1000, 404, 5);
    }

    /*
     * File store
     */
}
