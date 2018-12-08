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
    }

    private function getAssertStatusError(string $uri, int $idRoute, int $status, int $errorNb)
    {
        $response = $this->getAssertStatus($uri, $idRoute, $status);
        $response->assertSessionHas('error', $errorNb);
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

    /*
     * File show
     */
    public function testShowGuest()
    {
        $this->getAssertStatusError('files.show', 1, 302, 3);
    }

    public function testShowLoggedOwner()
    {
        $this->logAsGetAssertStatus(1, 'files.show', 1, 200);
    }

    public function testShowLoggedUnauthorized()
    {
        $this->logAsGetAssertStatusError(2, 'files.show', 1, 401,  1);
    }

    public function testShowNonExistent()
    {
        $this->logAsGetAssertStatus(1, 'files.show', 1000, 404, 5);
    }

    /*
     * File edit
     */
    public function testEditGuest()
    {
        $this->getAssertStatusError('files.edit', 1, 302, 3);
    }

    public function testEditLoggedOwner()
    {
        $this->logAsGetAssertStatus(1, 'files.edit', 1,200);
    }

    public function testEditLoggedUnauthorized()
    {
        $this->logAsGetAssertStatusError(2, 'files.edit', 1,401, 1);
    }

    public function testEditLoggedNonExistent()
    {
        $this->logAsGetAssertStatusError(1, 'files.edit', 1000, 404, 5);
    }

    /*
     * File update
     */
    public function testUpdateLogged()
    {
        $user = User::where('id', 1)->first();
        $file = File::where('id', 1)->first();
        $this->be($user);
        $response = $this->PATCH(route(
            'files.update', $file), [
            'title' => "changed from test", 'date'=> '11/11/2018', 'fileContent'=> '#Titre']);
        $response->assertStatus(302);
        $response->assertSessionMissing('error');
        $response->assertLocation(route('files.show', 1));
    }
}
