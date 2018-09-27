<?php
    namespace App\DataFixtures;

    use App\Entity\Category;
    use App\Entity\User;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Doctrine\Common\Persistence\ObjectManager;
    use Symfony\Component\DependencyInjection\ContainerAwareInterface;
    use Symfony\Component\DependencyInjection\ContainerInterface;

    class AppFixtures extends Fixture implements ContainerAwareInterface, OrderedFixtureInterface
    {

        private $container;

        public function setContainer(ContainerInterface $container = null)
        {
            $this->container = $container;
        }

        public function load(ObjectManager $manager)
        {

            $em = $this->container->get('doctrine')->getEntityManager('default');
            $subjects = [
                'math', 'physics', 'biology', 'geography', 'english'
            ];

            // create 20 products! Bam!
            for ($i = 0; $i < 20; $i++) {
                $user = new User();
                $user->setUsername('name'.$i);
                $user->setEmail('email_'.mt_rand(10, 100).'@school.com');
                $user->setTeacher(random_int(0,1));
                $user->setPassword(password_hash( 'root', PASSWORD_BCRYPT));
                $manager->persist($user);
            }

            for ($i = 0; $i < count($subjects); $i++) {
                $category = new Category();
                $category->setName($subjects[$i]);
                $category->setDescription('This is the subject: ' . $subjects[$i]);
                $manager->persist($category);
            }

            $manager->flush();
        }

        function getOrder()
        {
            return 1;
        }
    }