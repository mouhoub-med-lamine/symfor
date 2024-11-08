<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use App\Form\IngredientType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IngredientsController extends AbstractController
{
    #[Route('/ingredients', name: 'app_ingredients' ,methods:['GET'])]
    public function index(IngredientRepository  $repository , PaginatorInterface  $paginator , Request  $request): Response
    {   
        $ingredients = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            12 
        );

        return $this->render('ingredients/index.html.twig', [
            'ingredients' => $ingredients,
            ]);
    }

    #[Route('/ingredients/add', name: 'app_ingredient_add' ,methods:['GET' , 'POST'])]
    public function add(Request  $request , EntityManagerInterface $manager): Response
    {   
        $ingredients = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredients);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ingredients);
            $manager->flush();
            $this->addFlash(
                'success',
                'Ingredient ajouté avec succès'
            );

            return $this->redirectToRoute('app_ingredients');

        }
        return $this->render('ingredients/add_ingredients.html.twig', [
            'form' => $form->createView(),
            ]);
    }

    #[Route('/ingredients/{id}', name: 'app_ingredient_preview' )]
    public function show(
        IngredientRepository  $repository , 
        int $id ): Response
    {   
        // $product = $manager->getRepository(className: Ingredient::class)->find($id);
        $ingredient = $repository->findOneBy(['id' => $id]);


        if (!$ingredient) {
            throw $this->createNotFoundException(
                'No ingredient found for id '.$id
            );
        }

        return $this->render('ingredients/preview_ingredients.html.twig', [
            'ingredient' => $ingredient,
            ]);
    }



    #[Route('/ingredients/{id}/edit', name: 'app_ingredient_edit', methods: ['GET', 'POST'])]
    public function edit(
        Ingredient $ingredient,
        Request $request, 
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'ingrédient nommé ' . $ingredient->getName() . ' a été modifié avec succès.'
            );

            return $this->redirectToRoute('app_ingredients');
        }

        return $this->render('ingredients/edit_ingredients.html.twig', [
            'form' => $form->createView(),
            'ingredient' => $ingredient,
        ]);
    }

    #[Route('/ingredients/{id}/delete', name: 'app_ingredient_delete', methods: ['GET', 'POST'])]
    public function delete(
        Ingredient $ingredient,
        EntityManagerInterface $manager
    ): Response {

        if(!$ingredient){
            $this->addFlash(
                'danger',
                'L\'ingrédient n\'existe pas.'
            );
            
            return $this->redirectToRoute('app_ingredients');
        }
        
        $manager->remove($ingredient);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\'ingrédient nommé ' . $ingredient->getName() . ' a été modifié avec succès.'
        );

        return $this->redirectToRoute('app_ingredients');
    }

}
