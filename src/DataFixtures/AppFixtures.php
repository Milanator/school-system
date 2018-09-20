<?php
    namespace App\DataFixtures;

    use App\Entity\User;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\Persistence\ObjectManager;

    class AppFixtures extends Fixture
    {
        public function load(ObjectManager $manager)
        {
            // create 20 products! Bam!
            for ($i = 0; $i < 20; $i++) {
                $user = new User();
                $user->setUsername('name'.$i);
                $user->setEmail('email_'.mt_rand(10, 100).'@school.com');
                $user->setTeacher(random_int(0,1));
                $user->setPassword(password_hash( 'root', PASSWORD_BCRYPT));
                $manager->persist($user);
            }

            $manager->flush();
        }
    }