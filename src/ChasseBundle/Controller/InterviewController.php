<?php

namespace ChasseBundle\Controller;

use ChasseBundle\Entity\Interview;
use ChasseBundle\Repository\JobRepository;
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
            $data = $repository->getJobsName($domain);
            return new JsonResponse(array("data" => json_encode($data)));
        } else {
            throw new HttpException('500', 'Invalid call');
        }
    }

    /**
     * Lists all domains.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function jobselectAction(){
        $em = $this->getDoctrine()->getManager();
        $jobs = $em->getRepository('ChasseBundle:Job')->getDomains();

        return $this->render('interview/jobselect.html.twig', array(
            'jobs' => $jobs,
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
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em-> createQuery(
            'SELECT a 
            FROM ChasseBundle:Answer a');

        $products = $query->getResult();

        $answers=[];
        foreach ($products as $product) {
            array_push($answers, $product->getWord());
        }

        $interview = new Interview();
        $form = $this->createForm('ChasseBundle\Form\InterviewType', $interview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interview);
            $em->flush($interview);

            return $this->redirectToRoute('votevalid', array('id' => $interview->getId()));
        }

        return $this->render('interview/new.html.twig', array(
            'interview' => $interview,
            'answers' => $answers,
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
            $em->flush($interview);
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
