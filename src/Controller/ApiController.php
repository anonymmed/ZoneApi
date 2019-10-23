<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Variation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;


class ApiController extends AbstractFOSRestController
{

    /**
     * @Route("/version", name="version")
     */
    public function home()
    {
        return $this->json(["response" => "1.0"]);
    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->redirect($this->generateUrl('version'));
    }

    /**
     * @Rest\Post("/create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     */
    public function createProduct(Request $request)
    {
        if (
            null === $request->request->get('name')  ||
            null === $request->request->get('price') ||
            null === $request->request->get('rating')
        ) {
            return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));
        }
        $product = new Product();
        $product->setName(($request->request->get('name')));
        $product->setPrice($request->request->get('price'));
        $product->setRating($request->request->getAlnum('rating'));

        $variation = new Variation();

        $variations = (array)($request->request->get('variations'));
        $variation->setColor($variations['color']);
        $variation->setQuantity($variations['quantity']);
        $variation->setSize($variations['size']);
        $variation->setProduct($product);
        $em = $this->getDoctrine()->getManager();
        $em->persist($variation);
        $em->persist($product);
        $em->flush();
        return $this->json([
            'response' => 'product has been added successfully'
        ]);
    }

    /**
     * @Rest\Get("/list")
     */
    public function listProducts()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('App\Entity\Product')->findAll();
        $response = [];
        foreach ($products as $key => $p) {
            $response[$key]['name'] = $p->getName();
            $response[$key]['price'] = $p->getPrice();
            $response[$key]['rating'] = $p->getRating();

            $response[$key]['variation'] = json_encode([
                'color' => $p->getVariation()->getColor(),
                'size' => $p->getVariation()->getSize(),
                'quantity' => $p->getVariation()->getQuantity()
            ], true);

        }
        return $this->handleView($this->view($response, Response::HTTP_OK));
    }

    /**
     * @Rest\Put("/update")
     * @param Request $request
     * @return Response
     */
    public function updateProduct(Request $request)
    {
        if (
            null === $request->request->get('name')  ||
            null === $request->request->get('price') ||
            null === $request->request->get('rating')
        ) {
            return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));
        }

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($request->get('id'));
        $product->setName($request->get('name'));
        $product->setPrice($request->get('price'));
        $product->setRating($request->get('rating'));
        $variation = $product->getVariation();
        $variations = $request->get('variation');
        $variation->setColor($variations['color']);
        $variation->setSize($variations['size']);
        $variation->setQuantity($variations['quantity']);
        $em->flush();
        return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));

    }

    /**
     * @Rest\Patch("/updateName")
     * @param Request $request
     * @return Response
     */
    public function updateProductName(Request $request)
    {
        if (null === $request->request->get('name')) {
            return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));
        }
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($request->get('id'));
        $product->setName($request->get('name'));
        $em->flush();
        return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));

    }

    /**
     * @Rest\Patch("/updatePrice")
     * @param Request $request
     * @return Response
     */
    public function updateProductPrice(Request $request)
    {
        if (null === $request->request->get('price')) {
            return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));
        }
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($request->get('id'));
        $product->setPrice($request->get('price'));
        $em->flush();
        return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));

    }

    /**
     * @Rest\Patch("/updateRating")
     * @param Request $request
     * @return Response
     */
    public function updateProductRating(Request $request)
    {
        if (null === $request->request->get('rating')) {
            return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));
        }
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($request->get('id'));
        $product->setRating($request->get('rating'));
        $em->flush();
        return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));

    }

    /**
     * @Rest\Patch("/updateVariation")
     * @param Request $request
     * @return Response
     */
    public function updateProductVariation(Request $request)
    {
        if ($request->get('id') !== null) {
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository(Product::class)->find(intval($request->get('id')));
            $product->getVariation()->setQuantity($request->get('quantity'));
            $product->getVariation()->setSize($request->get('size'));
            $product->getVariation()->setColor($request->get('color'));
            $em->flush();
            return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));
        }
        return $this->handleView($this->view(['response' => Response::HTTP_BAD_REQUEST], Response::HTTP_OK));

    }

    /**
     * @Rest\Delete("/delete")
     * @param Request $request
     * @return Response
     */
    public function deleteProduct(Request $request)
    {
        if ($request->get('id') !== null) {
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository(Product::class)->find($request->get('id'));
            if ($product !== null) {
                $em->remove($product);
                $em->flush();
                return $this->handleView($this->view(['response' => Response::HTTP_OK], Response::HTTP_OK));
            }
        }
        return $this->handleView($this->view(['response' => Response::HTTP_BAD_REQUEST], Response::HTTP_OK));
    }

    /**
     * @Rest\Get("/Api/list")
     */
    public function customizedListProducts()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('App\Entity\Product')->findAll();
        $response = [];
        foreach ($products as $key => $p) {
            $response[$key]['name'] = $p->getName();

            $response[$key]['variation'] = json_encode([
                'quantity' => $p->getVariation()->getQuantity()
            ], true);

        }
        return $this->handleView($this->view($response, Response::HTTP_OK));
    }



}

