<?php

namespace UserLoginService\Application;
use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\FacebookSessionManager;
use Exception;

class UserLoginService
{
    private array $loggedUsers = [];
    private FacebookSessionManager $apiCaller;

    public function __construct($apiCaller = FacebookSessionManager::class)
    {
        if(is_string($apiCaller)){
            $this->apiCaller = new $apiCaller();
        }else{
            $this->apiCaller = $apiCaller;
        }
    }

    public function manualLogin(User $user): void
    {
        if(in_array($user,$this->loggedUsers,$strict=true)){
            throw new Exception("User already logged in");
        }
        array_push($this->loggedUsers, $user);
    }

    public function getLoggedUsers(): array
    {
        return $this->loggedUsers;
    }

    public function addLoggedUserManuallyInList(User $user): void
    {
        array_push($this->loggedUsers, $user);
    }

    public function getExternalSessions(): int
    {
        return $this->apiCaller->getSessions();
    }
}