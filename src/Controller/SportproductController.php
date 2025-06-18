<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Sportproduct;
use App\Repository\ColorRepository;
use App\Repository\SportproductRepository;
use App\Repository\SportRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportproductController extends AbstractController
{
    #[Route('/admin/sportproduct', name: 'sportproduct_index')]
    public function index(SportproductRepository $repo, SportRepository $sportRepo, ColorRepository $colorRepo): Response
    {
        $sportproducts = $repo->findAllWithExistingProduct();
        $sports = $sportRepo->findAll();
         $usedProductIds = array_map(fn($sp) => $sp->getIdProduct(), $sportproducts);
         $colors = $colorRepo->findAll();

        return $this->render('sportproduct/index.html.twig', [
            'sportproducts' => $sportproducts,
            'sports' => $sports,
            'usedProductIds' => $usedProductIds,
             'colors' => $colors, 
        ]);
    }

    #[Route('/admin/sportproduct/add', name: 'sportproduct_add', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $em, SportRepository $sportRepo): Response
    {
        $idSport = $request->request->get('id_sport');
        $idProduct = $request->request->get('id_product');
        $name = $request->request->get('name');
        $type = $request->request->get('type');
        $hasCollar = $request->request->get('has_collar');
        $hasNumber = $request->request->get('has_number');
        $hasPictures = $request->request->get('has_pictures');
        $hasText = $request->request->get('has_text');
        $colorNumber = $request->request->get('color_number');
        $defaultColor1 = $request->request->get('default_color_1');
        $defaultColor2 = $request->request->get('default_color_2');
        $defaultColor3 = $request->request->get('default_color_3');
        $defaultColor4 = $request->request->get('default_color_4');
        $defaultColor5 = $request->request->get('default_color_5');

        if ($idSport && $idProduct && $name) {
            // Création du produit avec l'id choisi
            $product = new Product();
            $product->setIdProduct((int)$idProduct);
            $product->setName($name);
            $product->setType((int)$type);
            $product->setHasCollar((int)$hasCollar);
            $product->setHasNumber((int)$hasNumber);
            $product->setHasPictures((int)$hasPictures);
            $product->setHasText((int)$hasText);
            $product->setColorNumber((int)$colorNumber);
            $product->setDefaultColor1((int)$defaultColor1);
            $product->setDefaultColor2((int)$defaultColor2);
            $product->setDefaultColor3((int)$defaultColor3);
            $product->setDefaultColor4((int)$defaultColor4);
            $product->setDefaultColor5((int)$defaultColor5);

            $em->persist($product);
            $em->flush();

            // Création de la liaison sportproduct
            $sportproduct = new Sportproduct();
            $sportproduct->setIdSport((int)$idSport);
            $sportproduct->setIdProduct((int)$idProduct);
            $sport = $sportRepo->find($idSport);
            if ($sport) {
                $sportproduct->setSport($sport);
            }
            $sportproduct->setProduct($product);
            $em->persist($sportproduct);
            $em->flush();


            // === AJOUTE CE BLOC ICI ===
            $hasCollars = $request->request->get('has_multiple_collars');
            $productDir = $this->getParameter('kernel.project_dir') . '/public/storage/app/public/pictures/products/' . $idProduct;

            if (!file_exists($productDir)) {
                mkdir($productDir, 0777, true);
            }

            // Ajout de l'image du carrousel
            $carouselDir = $this->getParameter('kernel.project_dir') . '/public/storage/app/public/pictures/products/';
            if (!file_exists($carouselDir)) {
                mkdir($carouselDir, 0777, true);
            }
            $carouselImage = $request->files->get('carousel_image');
            if ($carouselImage instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                $carouselImage->move(
                    $carouselDir,
                    $idProduct . '.png'
                );
            }



            // Vérifie si le produit a des cols

            if ($hasCollars) {
                for ($i = 1; $i <= 4; $i++) {
                    $collarDir = $productDir . '/' . $i;
                    if (!file_exists($collarDir)) {
                        mkdir($collarDir, 0777, true);
                    }
                    $files = $request->files->get("images_col_$i", []);
                    $fileIndex = 0;
                    foreach ($files as $image) {
                        if ($image instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                            $image->move($collarDir, $fileIndex . '.png');
                            $fileIndex++;
                        }
                    }
                }
            } else {
                $files = $request->files->get('images', []);
                $fileIndex = 0;
                foreach ($files as $image) {
                    if ($image instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                        $image->move($productDir, $fileIndex . '.png');
                        $fileIndex++;
                    }
                }
            }
            // === FIN DU BLOC ===


        }
        return $this->redirectToRoute('sportproduct_index');
    }

    #[Route('/admin/sportproduct/delete/{id_sport}/{id_product}', name: 'sportproduct_delete', methods: ['POST'])]
public function delete(
    int $id_sport,
    int $id_product,
    SportproductRepository $repo,
    ProductRepository $productRepo,
    EntityManagerInterface $em
): Response {
    $sportproduct = $repo->findOneBy(['idSport' => $id_sport, 'idProduct' => $id_product]);
    if ($sportproduct) {
        $product = $sportproduct->getProduct();
        $em->remove($sportproduct);
        if ($product) {
            $em->remove($product);
        }
        $em->flush();
    }
    return $this->redirectToRoute('sportproduct_index');
}



    #[Route('/admin/sportproduct/edit/{id_sport}/{id_product}', name: 'sportproduct_edit')]
    public function edit(
        int $id_sport,
        int $id_product,
        Request $request,
        SportproductRepository $repo,
        SportRepository $sportRepo,
        EntityManagerInterface $em,
        ProductRepository $productRepo,
        ColorRepository $colorRepo
    ): Response {
        $sportproduct = $repo->findOneBy(['idSport' => $id_sport, 'idProduct' => $id_product]);
        if (!$sportproduct) {
            throw $this->createNotFoundException('Liaison non trouvée.');
        }
        $product = $sportproduct->getProduct();
        $colors = $colorRepo->findAll();

        if ($request->isMethod('POST')) {
            $newIdSport = (int)$request->request->get('id_sport');
            $newIdProduct = (int)$request->request->get('id_product');
            $name = $request->request->get('name');
            $type = (int)$request->request->get('type');
            $hasCollar = (int)$request->request->get('has_collar');
            $hasNumber = (int)$request->request->get('has_number');
            $hasPictures = (int)$request->request->get('has_pictures');
            $hasText = (int)$request->request->get('has_text');
            $colorNumber = (int)$request->request->get('color_number');
            $defaultColor1 = (int)$request->request->get('default_color_1');
            $defaultColor2 = (int)$request->request->get('default_color_2');
            $defaultColor3 = (int)$request->request->get('default_color_3');
            $defaultColor4 = (int)$request->request->get('default_color_4');
            $defaultColor5 = (int)$request->request->get('default_color_5');

            // Si l'ID produit ou sport change, il faut créer de nouveaux objets
            if ($newIdSport !== $id_sport || $newIdProduct !== $id_product) {
                // Vérifier si un produit avec le nouvel ID existe déjà
                $newProduct = $productRepo->find($newIdProduct);
                if (!$newProduct) {
                    $newProduct = new \App\Entity\Product();
                    $newProduct->setIdProduct($newIdProduct);
                }
                $newProduct->setName($name);
                $newProduct->setType($type);
                $newProduct->setHasCollar($hasCollar);
                $newProduct->setHasNumber($hasNumber);
                $newProduct->setHasPictures($hasPictures);
                $newProduct->setHasText($hasText);
                $newProduct->setColorNumber($colorNumber);
                $newProduct->setDefaultColor1($defaultColor1);
                $newProduct->setDefaultColor2($defaultColor2);
                $newProduct->setDefaultColor3($defaultColor3);
                $newProduct->setDefaultColor4($defaultColor4);
                $newProduct->setDefaultColor5($defaultColor5);

                $em->persist($newProduct);

                // Créer la nouvelle liaison
                $newSportproduct = new \App\Entity\Sportproduct();
                $newSportproduct->setIdSport($newIdSport);
                $newSportproduct->setIdProduct($newIdProduct);
                $sport = $sportRepo->find($newIdSport);
                if ($sport) {
                    $newSportproduct->setSport($sport);
                }
                $newSportproduct->setProduct($newProduct);
                $em->persist($newSportproduct);

                // Supprimer l'ancienne liaison
                $em->remove($sportproduct);

                // Optionnel : supprimer l'ancien produit s'il n'est plus utilisé
                // (à adapter selon ton besoin)

                $em->flush();

                return $this->redirectToRoute('sportproduct_index');
            } else {
                // Mise à jour simple
                $product->setName($name);
                $product->setType($type);
                $product->setHasCollar($hasCollar);
                $product->setHasNumber($hasNumber);
                $product->setHasPictures($hasPictures);
                $product->setHasText($hasText);
                $product->setColorNumber($colorNumber);
                $product->setDefaultColor1($defaultColor1);
                $product->setDefaultColor2($defaultColor2);
                $product->setDefaultColor3($defaultColor3);
                $product->setDefaultColor4($defaultColor4);
                $product->setDefaultColor5($defaultColor5);

                $em->flush();

                return $this->redirectToRoute('sportproduct_index');
            }
        }

        return $this->render('sportproduct/edit.html.twig', [
            'sportproduct' => $sportproduct,
            'product' => $product,
            'colors' => $colors,
        ]);
    }


    #[Route('/admin/sportproduct/{id_sport}/{id_product}', name: 'sportproduct_show')]
    public function show($id_sport, $id_product, SportproductRepository $repo, ColorRepository $colorRepo): Response
    {
        $sportproduct = $repo->findOneBy(['idSport' => $id_sport, 'idProduct' => $id_product]);
        if (!$sportproduct) {
            throw $this->createNotFoundException('Liaison non trouvée.');
        }
        $colors = $colorRepo->findAll();
        return $this->render('sportproduct/show.html.twig', [
            'sportproduct' => $sportproduct,
            'colors' => $colors,
        ]);
    }
}
