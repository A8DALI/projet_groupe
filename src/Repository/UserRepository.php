<?php

	namespace App\Repository;

	use App\Entity\User;
	use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
	use Doctrine\Persistence\ManagerRegistry;

	/**
	 * @method User|null find($id, $lockMode = null, $lockVersion = null)
	 * @method User|null findOneBy(array $criteria, array $orderBy = null)
	 * @method User[]    findAll()
	 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
	 */
	class UserRepository extends ServiceEntityRepository
	{
		public function __construct(ManagerRegistry $registry)
		{
			parent::__construct($registry, User::class);
		}

		// /**
		//  * @return Users[] Returns an array of Users objects
		//  */
		/*
		public function findByExampleField($value)
		{
			return $this->createQueryBuilder('u')
				->andWhere('u.exampleField = :val')
				->setParameter('val', $value)
				->orderBy('u.id', 'ASC')
				->setMaxResults(10)
				->getQuery()
				->getResult()
			;
		}
		*/

		/*
		public function findOneBySomeField($value): ?Users
		{
			return $this->createQueryBuilder('u')
				->andWhere('u.exampleField = :val')
				->setParameter('val', $value)
				->getQuery()
				->getOneOrNullResult()
			;
		}
		*/

		public function findByVilleEtGenre($user)
		{

			$query = $this->createQueryBuilder('u')
//				->select('u.pseudo, u.email, u.ville, u. genre')

				->andWhere('u.id !=' . $user->getId())
				->andWhere('u.ville = :ville')
				->andWhere('u.genre = :genre')
				->setParameter('ville', $user->getVille())
				->setParameter('genre', $user->getGenre())
				->orderBy('u.id', 'DESC')
				->setMaxResults(3);

			return $query->getQuery()->getResult();

		}

	}
