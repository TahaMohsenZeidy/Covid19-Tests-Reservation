<?php
namespace App\Controller;
use App\Entity\Rdv;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/appointment")
 */
class AppointmentController extends AbstractController
{
    /**
     * @Route("/{page}", name="appointment_list", defaults={"page": 10}, requirements={"page":"\d+"})
     */
    public function list($page = 1, Request $request){
        $limit = $request->get('limit', 10);
        $repository = $this->getDoctrine()->getRepository(Rdv::class);
        $items = $repository->findAll();
        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function (Rdv $item){
                return $this->generateUrl('appointment_by_date', ['date' =>$item->getDate()->format('Y-m-d H:i:s')]);
            }, $items)
        ]);
    }

    /**
     * @Route("/app/{id}", name="appointment_by_id", requirements={"id":"\d+"}, methods={"GET"})
     * @ParamConverter("rdv", class="App:Rdv")
     */
    public function appointment($rdv){
        return $this->json($rdv);
    }

    /**
     * @Route("/app/{date}", name="appointment_by_date", methods={"GET"})
     */
    public function appointmentByDate($date){
        $startDate = $date.' 00:00:00';
        $endDate = $date.' 23:59:59';
        $em = $this->getDoctrine()->getManager()->getRepository(Rdv::class);
        $qb = $em->createQueryBuilder("q");
        $qb
            ->where('q.date BETWEEN :from AND :to')
            ->setParameter('from', $startDate)
            ->setParameter('to', $endDate);
        $result = $qb->getQuery()->getResult();
        return $this->json($result);
    }

    /**
     * @Route("/add", name="appointment_add", methods={"POST"})
     */
    public function add(Request $request){
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');
        $app = $serializer->deserialize($request->getContent(), Rdv::class, 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($app);
        $em->flush();
        return $this->json($app);
    }

    /**
     * @Route("/app/{id}", name="appointment_delete", methods={"DELETE"})
     */
    public function delete(Rdv $rdv){
        $em = $this->getDoctrine()->getManager();
        $em->remove($rdv);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}