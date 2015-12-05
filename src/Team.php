<?php

namespace App;

use App\Exceptions\TeamIsFull;
use App\Exceptions\UserIsAlreadyOnTeam;

class Team
{

    protected $name;

    protected $size;

    protected $users = [ ];


    public function __construct( $name, $size )
    {
        $this->name = $name;
        $this->size = $size;
    }

    public function name()
    {
        return $this->name;
    }

    public function size()
    {
        return $this->size;
    }

    public function count()
    {
        return count($this->users);
    }

    public function addMany( array $users )
    {
        foreach ( $users as $user )
        {
            $this->add($user);
        }
    }

    public function add( User $user )
    {
        if( $this->atCapacity() )
        {
            throw new TeamIsFull;
        }

        if($user->isOnTeam())
        {
            throw new UserIsAlreadyOnTeam;
        }


        $this->users[] = $user;
    }

    public function members()
    {
        return $this->users;
    }

    protected function atCapacity()
    {
        return $this->count() == $this->size();
    }



}