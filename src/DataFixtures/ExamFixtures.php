<?php
    namespace App\DataFixtures;

    use App\Entity\Category;
    use App\Entity\Exam;
    use App\Entity\User;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
    use Doctrine\Common\Persistence\ObjectManager;
    use Symfony\Component\DependencyInjection\ContainerAwareInterface;
    use Symfony\Component\DependencyInjection\ContainerInterface;

    class ExamFixtures /*implements ContainerAwareInterface*/
    {

//        private $container;
//
//        public function setContainer(ContainerInterface $container = null)
//        {
//            $this->container = $container;
//        }

//        public function load(ObjectManager $manager)
//        {
//
//            $em = $this->container->get('doctrine')->getEntityManager('default');
//
//            $repositoryUser = $em->getRepository(User::class);
//            $repositoryCategory = $em->getRepository(Category::class);
//            $user = $repositoryUser->find(2);
//            $category = $repositoryCategory->find(2);
//
//            for ($i = 0; $i < 5; $i++){
//                $exam = new Exam();
//                $exam->setDate(new \DateTime());
//                $exam->setCategory($category);
//                $exam->setCreator($user);
//
//                $manager->persist($exam);
//            }
//
//            $manager->flush();
//        }


    }