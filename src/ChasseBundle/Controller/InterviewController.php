<?php

namespace ChasseBundle\Controller;

use ChasseBundle\Entity\Interview;
use ChasseBundle\Entity\Job;
use ChasseBundle\Repository\JobRepository;
use ChasseBundle\Repository\AnswerRepository;
use ChasseBundle\Repository\InterviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Interview controller.
 *
 */
class InterviewController extends Controller
{
    /**
     * Ajax request to display jobs once domain is chosen.
     * @param Request $request
     * @param $domain
     * @return JsonResponse
     */
    public function jobchooseAction(Request $request, $domain)
    {
        if ($request->isXmlHttpRequest()){

            /**
             * @var $repository JobRepository
             */
            $repository = $this->getDoctrine()->getRepository('ChasseBundle:Job');
            $datas = $repository->getJobsName($domain);
            $datas2=[];
            foreach($datas as $value){
                $datas2[$value['id']]=$value['name'];
            }

            /**
             * @var $repository2 InterviewRepository
             */
            $user = $this->getUser();
            $repository2 = $this->getDoctrine()->getRepository('ChasseBundle:Interview');
            $data = $repository2->getJobsDone($user);
            $data2 = [];
            foreach($data as $value){
                $data2[$value['id']]=$value['name'];
            }

            $treated = array_diff($datas2, $data2);

            $treated2 = [];
            foreach($treated as $key=>$value){
                $treated2[] = ['id'=>$key, 'name'=>$value];
            }

            return new JsonResponse(array("data" => json_encode($treated2)));
        } else {
            throw new HttpException('500', 'Invalid call');
        }
    }

    public function jobsearchAction(Request $request, $word)
    {
        if ($request->isXmlHttpRequest()){
            /**
             * @var $repository AnswerRepository
             */
            $repository = $this->getDoctrine()->getRepository('ChasseBundle:Answer');
            $data = $repository->searchWords($word);
            return new JsonResponse(array("data" => json_encode($data)));
        } else {
            throw new HttpException('500', 'Invalid call');
        }
    }

    public function searchhelpAction(Request $request, $domain)
    {
        if ($request->isXmlHttpRequest()){
            /**
             * @var $repository AnswerRepository
             */
            $repository = $this->getDoctrine()->getRepository('ChasseBundle:Answer');
            $data = $repository->searchRecommend($domain);
            return new JsonResponse(array("data" => json_encode($data)));
        } else {
            throw new HttpException('500', 'Invalid call');
        }
    }

    /**
     * Lists all domains.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function jobselectAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $domains = $em->getRepository('ChasseBundle:Job')->getDomains();
        $dom = [];

        foreach($domains as $value){
            $dom[$value['domain']]=$value['domain'];
        }
        $job = new Job();

        $form = $this->createForm('ChasseBundle\Form\JobType', $job, array('domains' => $dom));
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $jobchos = $job->getName();
            $jobchosen = $this->getDoctrine()
                ->getRepository('ChasseBundle:Job')->find($jobchos);

          /*  return $this->redirectToRoute('index', array()); */
            return $this->redirectToRoute('interview_new', array('job' => $jobchosen));

        }

        return $this->render('interview/jobselect.html.twig', array(
            'job' => $job,
            'form' => $form->createView(),
        ));
    }

    /**
     * Lists all interview entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $interviews = $em->getRepository('ChasseBundle:Interview')->findAll();

        return $this->render('interview/index.html.twig', array(
            'interviews' => $interviews,
        ));
    }

    /**
     * Creates a new interview entity.
     *
     */
    public function newAction(Request $request, $job)
    {
        $interview = new Interview();
        $user = $this->getUser();
    /*    $jobchosen = intval($job); */
        $jobchosen = $this->getDoctrine()->getRepository('ChasseBundle:Job')->find($job);

        $form = $this->createForm('ChasseBundle\Form\InterviewType', $interview);
        $form->get('user')->setData($user);
        $form->get('job')->setData($jobchosen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interview);
            $em->flush();

            return $this->redirectToRoute('votevalid');
        }

        return $this->render('interview/new.html.twig', array(
            'interview' => $interview,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a interview entity.
     *
     */
    public function showAction(Interview $interview)
    {
        $deleteForm = $this->createDeleteForm($interview);

        return $this->render('interview/show.html.twig', array(
            'interview' => $interview,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing interview entity.
     *
     */
    public function editAction(Request $request, Interview $interview)
    {
        $deleteForm = $this->createDeleteForm($interview);
        $editForm = $this->createForm('ChasseBundle\Form\InterviewType', $interview);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('interview_edit', array('id' => $interview->getId()));
        }

        return $this->render('interview/edit.html.twig', array(
            'interview' => $interview,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a interview entity.
     *
     */
    public function deleteAction(Request $request, Interview $interview)
    {
        $form = $this->createDeleteForm($interview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($interview);
            $em->flush();
        }

        return $this->redirectToRoute('interview_index');
    }

    /**
     * Creates a form to delete a interview entity.
     *
     * @param Interview $interview The interview entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Interview $interview)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('interview_delete', array('id' => $interview->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
