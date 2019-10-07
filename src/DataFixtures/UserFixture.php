<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixture.
 */
class UserFixture extends BaseFixture
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /**
     * UserFixture constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 10, function(User $user, $i) use ($manager) {
            $user
                ->setNickname(sprintf('user%d', $i))
                ->setFirstName($this->faker->firstName)
                ->setLastName($this->faker->lastName)
                ->setAge($this->faker->numberBetween(20,40))
                ->setPassword('password');
        });

        $manager->flush();
    }
}
