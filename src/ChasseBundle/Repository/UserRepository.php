<?php


namespace ChasseBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    //nb of male/female users > ok tested on workbench : SELECT gender, COUNT(gender) FROM mondialbdd.user group by gender
    public function countGender()
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.gender, count(u.gender) as nb')
            ->groupBy('u.gender')
            ->getQuery();

        return $qb->getScalarResult();
    }

    //list of email who subscribed newsletter > ok tested on workbench : SELECT email FROM mondialbdd.user WHERE newsletter = true
    public function getSubscribers()
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.email')
            ->where('u.newsletter=true')
            ->getQuery();

        return $qb->getScalarResult();
    }


    //classment of the most registered status among users (student, employee, etc.) > ok tested on workbench, SELECT status, COUNT(status) FROM mondialbdd.user group by status
    public function getMostRegStatus()
    {
        //attention: query not tested yet in dql
        $qb = $this->createQueryBuilder('u')
            ->select('u.status, count(u.status) as nb')
            ->groupBy('u.status')
            ->getQuery();

        return $qb->getScalarResult();
    }

    //classment by age category
    public function getAgeCategories($ageMin, $ageMax) {
        $qb = $this->createQueryBuilder('u')
            ->select('count(u.age)')
            ->where('u.age >= :ageMin')
            ->andWhere('u.age <= :ageMax')
            ->setParameter('ageMin', $ageMin)
            ->setParameter('ageMax', $ageMax)
            ->getQuery();

        return $qb->getSingleScalarResult();
    }

    public function checkSatisf($user){
        $qb = $this->createQueryBuilder('u')
            ->select('u.satisfaction')
            ->where('u.id = :user')
            ->setParameter('user', $user)
            ->getQuery();
        return $qb->getSingleScalarResult();
    }
}