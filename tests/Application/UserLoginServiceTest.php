<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use Exception;
use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\FacebookSessionManager;

final class UserLoginServiceTest extends TestCase
{
    /**
     * @test
     */
    public function whenUserIsNotLoggedInThenAddUserToList()
    {
        $userLoginService = new UserLoginService();
        $user = new User("pepe");
        $userLoginService->manualLogin($user);
        $this->assertTrue(in_array($user, $userLoginService->getLoggedUsers(),$strict = true));
    }

    /**
     * @test
     */
    public function whenUserIsAlreadyLoggedInThenRaiseException()
    {
        $user = new User("pepe");
        $userLoginService = new UserLoginService();
        $userLoginService->addLoggedUserManuallyInList($user);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("User already logged in");
        $userLoginService->manualLogin($user);
    }

    /**
     * @test
     */
    public function whenGettingNumberSessionsThenReturnsNumber()
    {
        $stub = $this->createMock(FacebookSessionManager::class);
        $stub->method('getSessions')->willReturn(5);
        $userLoginService = new UserLoginService($stub);
//        print("NUMERO DE SESIONES: ".$userLoginService->getExternalSessions());
        $this->assertEquals($userLoginService->getExternalSessions(),5);
    }
}
