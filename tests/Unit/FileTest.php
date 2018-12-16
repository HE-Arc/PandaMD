<?php

namespace Tests\Unit;

use App\File;
use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class FileTest extends TestCase
{
    /*
     * Tools
     */
    private function logAsGetAssertStatusError(int $idUser, string $uri, int $idRoute, int $status, int $errorNb)
    {
        $response = $this->logAsGetAssertStatus($idUser, $uri, $idRoute, $status);
        $response->assertSessionHas('error', $errorNb);
        return $response;
    }

    private function getAssertStatusError(string $uri, int $idRoute, int $status, int $errorNb)
    {
        $response = $this->getAssertStatus($uri, $idRoute, $status);
        $response->assertSessionHas('error', $errorNb);
        return $response;
    }

    private function logAsGetAssertStatus(int $idUser, string $uri, int $idRoute, int $status)
    {
        $user = User::where('id', $idUser)->first();
        $this->be($user);
        $response = $this->getAssertStatus($uri, $idRoute, $status);
        return $response;
    }

    private function getAssertStatus(string $uri, int $idRoute, int $status)
    {
        $response = $this->get(route($uri, $idRoute));
        $response->assertStatus($status);
        return $response;
    }

    private $argsFilesOK = ['title' => "changed from test", 'date' => '11/11/2018', 'fileContent' => '#Titre',
        'right' => 'private', 'newFolder' => 1];

    private function logAsPatchAssertStatus(int $idUser, string $uri, int $idRoute, int $status, array $args)
    {
        $user = User::where('id', $idUser)->first();
        $this->be($user);
        return $this->patchAssertStatus($uri, $idRoute, $status, $args);
    }

    private function patchAssertStatus(string $uri, int $idRoute, int $status, array $args)
    {
        $response = $this->PATCH(route($uri, $idRoute), $args);
        $response->assertStatus($status);
        return $response;
    }

    /*
     * File show
     */
    public function testShowGuest()
    {
        $response = $this->getAssertStatusError('files.show', 1, 302, 3);
        $response->assertLocation(route('login'));
    }

    public function testShowLoggedOwner()
    {
        $this->logAsGetAssertStatus(1, 'files.show', 1, 200);
    }

    public function testShowLoggedUnauthorized()
    {
        $response = $this->logAsGetAssertStatusError(2, 'files.show', 1, 401, 1);
        $response->assertLocation(route('home'));
    }

    public function testShowNonExistent()
    {
        $response = $this->logAsGetAssertStatusError(1, 'files.show', 1000, 404,5);
        $response->assertLocation(route('home'));
    }

    /*
     * File edit
     */
    public function testEditGuest()
    {
        $response = $this->getAssertStatusError('files.edit', 1, 302, 3);
        $response->assertLocation(route('login'));
    }

    public function testEditLoggedOwner()
    {
        $this->logAsGetAssertStatus(1, 'files.edit', 1, 200);
    }

    public function testEditLoggedUnauthorized()
    {
        $response = $this->logAsGetAssertStatusError(2, 'files.edit', 1, 401, 1);
        $response->assertLocation(route('home'));
    }

    public function testEditLoggedNonExistent()
    {
        $response = $this->logAsGetAssertStatusError(1, 'files.edit', 1000, 404, 5);
        $response->assertLocation(route('home'));
    }

    /*
     * File update
     */
    public function testUpdateGuest()
    {
        $response = $this->patchAssertStatus('files.update', 1, 302, $this->argsFilesOK);
        $response->assertSessionHas('error', 3);
        $response->assertLocation(route('login'));
    }

    public function testUpdateLoggedGood()
    {
        $response = $this->logAsPatchAssertStatus(1, 'files.update', 1, 302, $this->argsFilesOK);
        $response->assertSessionMissing('error');
        $response->assertLocation(route('files.show', 1));
    }

    public function testUpdateUnauthorized()
    {
        $response = $this->logAsPatchAssertStatus(2, 'files.update', 1, 401, $this->argsFilesOK);
        $response->assertSessionHas('error', 1);
        $response->assertLocation(route('home'));
    }

    public function testUpdateNonExistent()
    {
        $response = $this->logAsPatchAssertStatus(1, 'files.update', 1000, 404, $this->argsFilesOK);
        $response->assertSessionHas('error', 5);
        $response->assertLocation(route('home'));
    }
}
