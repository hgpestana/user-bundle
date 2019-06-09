<?php


namespace HGPestana\UserBundle\Tests\Entity;


use HGPestana\UserBundle\Entity\User;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    /** @var array */
    private $fixtures;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fixtures = $this->loadFixtureFiles(
            [
                $this->pathToFixture('user.yml'),
                $this->pathToFixture('token.yml'),
            ]
        );
    }

    public function testGetEmail()
    {
        /** @var User $sut */
        $sut = $this->fixtures['user1'];
        $this->assertNotEmpty($sut->getEmail());

    }


    private function pathToFixture(string $filename): string
    {
        return sprintf('@HGPestanaUserBundle/Tests/Data/%s', $filename);
    }

}