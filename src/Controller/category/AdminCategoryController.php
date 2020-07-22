<?php

namespace App\Controller\category;

use App\Entity\Category;
use App\Entity\CategoryActuality;
use App\Entity\CategoryProduct;
use App\Form\CategoryType;
use App\Repository\CategoryActualityRepository;
use App\Repository\CategoryProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Exception\UnexpectedValueException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/dump", name="category_init")
     */
    public function dump(EntityManagerInterface $em, CategoryRepository $repo, CategoryActualityRepository $categoryActuality, CategoryProductRepository $categoryProduct){

        dump($categoryProduct->findAll());
        dump($categoryActuality->findAll());
        dd($repo->findAll());
        return new JsonResponse($repo->findAll(), 200);
    }
    /**
     * @Route("/{slug}", name="category_list", methods={"GET"})
     */
    public function list(Category $category, CategoryRepository $repo)
    {

        return $this->render('category/list.html.twig', [
            'arrayTree' => $repo->childrenHierarchy($category),
            'root' => $category
        ]);
    }

    /**
     * @Route("/{slug}/add",name="category_add", methods={"GET","POST"})
     */
    public function add(Category $parent, Request $request, EntityManagerInterface $em){

        if($parent instanceof CategoryProduct ){
            $category = new CategoryProduct();
        }elseif ( $parent instanceof CategoryActuality ){
            $category = new CategoryActuality();
        }else{
            return $this->redirectToRoute('admin');
        }

        $form = $this->createForm(CategoryType::class, $category, ['attr' => ['category' => $parent]]);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $em->persist($category);
            $em->flush();
            $this->addFlash('success','la catégorie à bien été ajoutée');
            return $this->redirectToRoute('category_list',['slug' => $parent->getSlug()]);
        }

        return $this->render('category/edit.html.twig', array(
            'form' => $form->createView(),
            'catParent'=> $parent,
            'action' => 'ajouter'
        ));
    }
//
//    /**
//     * @route("/edit/{categoryId}", name="category_edit")
//     * @Route("/add/{rootId}", name="category_add")
//     */
//    public function edit(Request $request, CategoryRepository $repo)
//    {
//        $category = new Category();
//        $message = "La catégorie a été ajoutée avec succès.";
//        $action = 'Ajouter';
//        $rootId = null;
//
//        if ($request->attributes->get('categoryId') > 0) {
//            $category = $repo->findOneById($request->attributes->get('categoryId'));
//            $message = "La catégorie a été modifié avec succès.";
//            $action = 'Modifier';
//            $rootId = $category->getRoot()->getId();
//        }
//        dump($category);
//
//        if ($request->attributes->get('rootId')) {
//            $rootId = $request->attributes->get('rootId');
//        }
//
//        $form = $this->createForm(CategoryType::class, $category, ['attr' => ['categoryId' => $rootId]]);
//        $form->handleRequest($request);
//
//        $arrayTree = $repo->childrenHierarchy();
//
//
//        //formulaire d'ajout
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($category);
//
//            try {
//                $em->flush();
//                $this->addFlash('success', $message);
//            } catch (UnexpectedValueException $e) {
//                $this->addFlash('warning', $e->getMessage());
//            }
//
//
//            return $this->redirectToRoute('category_list', ['id' => $category->getRoot()->getId()]);
//        }
//
//
//        return $this->render('category/edit.html.twig', array(
//            'form' => $form->createView(),
//            'arrayTree' => $arrayTree,
//            'action' => $action
//        ));
//
//
//    }
//
    /**
     * @route("/delete/{id}", name="category_delete",methods={"Delete"})
     */
    public function delete(Category $category, EntityManagerInterface $em): JsonResponse
    {
        try {
            $em->remove($category);
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            $exception_message = $e->getPrevious()->getCode();
            return new JsonResponse(['error' => $exception_message], 500);
        }

        return new JsonResponse(['success' => 'Object deleted'], 200);
    }
}
