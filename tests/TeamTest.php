<?php

use App\Team;
use App\User;

class TeamTest extends PHPUnit_Framework_TestCase
{

    /** @test */
    function a_team_has_a_name_and_size()
    {
        $team = $this->newTeam();

        $this->assertEquals('Acme', $team->name());
        $this->assertEquals(2, $team->size());
    }

    /** @test */
    function a_team_can_add_a_user()
    {
        $team = $this->newTeam();

        $team->add(new User('Joe'));

        $this->assertCount(1, $team->members());
    }

    /** @test */
    function a_team_can_add_multiple_users()
    {
        $team = $this->newTeam();

        $team->addMany([
            new User('Joe'),
            new User('Jane')
        ]);

        $this->assertCount(2, $team->members());
    }

    /**
     * @test
     * @expectedException App\Exceptions\TeamIsFull
     */
    function it_does_not_allow_new_members_once_the_maximum_size_has_been_reached()
    {
        $this->newTeam()->addMany([
            new User('Joe'),
            new User('Jane'),
            new User('Jill')
        ]);

    }

    /**
     * @test
     * @expectedException App\Exceptions\UserIsAlreadyOnTeam
     */
    function a_user_may_not_join_a_team_if_they_are_already_on_one()
    {
    	// Bill is already part of a team
        $bill = new User('Bill');
        $bill->joinTeam($this->newTeam());

        // So if we try to add Bill to a different team, it shouldn't work
        $this->newTeam('New Team')->add($bill);
    }


    protected function newTeam( $name = 'Acme', $size = 2 )
    {
        return new Team($name, $size);
    }


}
