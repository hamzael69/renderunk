<?php


namespace App\Controller;

use App\Entity\Product;
use App\Entity\Categoryproduct;
use App\Repository\ColorRepository;
use App\Repository\CategoryproductRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryproductController extends AbstractController
{
    #[Route('/admin/categoryproduct', name: 'categoryproduct_index')]
    public function index(CategoryproductRepository $repo, CategoryRepository $categoryRepo, ColorRepository $colorRepo): Response
    {
        $categoryproducts = $repo->findAllWithExistingProduct();
        $categories = $categoryRepo->findAll();
        $usedProductIds = array_map(fn($cp) => $cp->getIdProduct(), $categoryproducts);
        $colors = $colorRepo->findAll();

        return $this->render('categoryproduct/index.html.twig', [
            'categoryproducts' => $categoryproducts,
            'categories' => $categories,
            'usedProductIds' => $usedProductIds,
            'colors' => $colors,
        ]);
    }

    #[Route('/admin/categoryproduct/add', name: 'categoryproduct_add', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepo): Response
    {
        $idCategory = $request->request->get('id_category');
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

        if ($idCategory && $idProduct && $name) {
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

            $categoryproduct = new Categoryproduct();
            $categoryproduct->setIdCategory((int)$idCategory);
            $categoryproduct->setIdProduct((int)$idProduct);
            $category = $categoryRepo->find($idCategory);
            if ($category) {
                $categoryproduct->setCategory($category);
            }
            $categoryproduct->setProduct($product);
            $em->persist($categoryproduct);
            $em->flush();

            // Gestion des images
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

            // Gestion des images de cols ou classiques
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
        }
        return $this->redirectToRoute('categoryproduct_index');
    }

    #[Route('/admin/categoryproduct/delete/{id_category}/{id_product}', name: 'categoryproduct_delete', methods: ['POST'])]
    public function delete(
        int $id_category,
        int $id_product,
        CategoryproductRepository $repo,
        ProductRepository $productRepo,
        EntityManagerInterface $em
    ): Response {
        $categoryproduct = $repo->findOneBy(['idCategory' => $id_category, 'idProduct' => $id_product]);
        if ($categoryproduct) {
            $product = $categoryproduct->getProduct();
            $em->remove($categoryproduct);
            if ($product) {
                $em->remove($product);
            }
            $em->flush();
        }
        return $this->redirectToRoute('categoryproduct_index');
    }

    #[Route('/admin/categoryproduct/edit/{id_category}/{id_product}', name: 'categoryproduct_edit')]
    public function edit(
        int $id_category,
        int $id_product,
        Request $request,
        CategoryproductRepository $repo,
        CategoryRepository $categoryRepo,
        EntityManagerInterface $em,
        ProductRepository $productRepo,
        ColorRepository $colorRepo
    ): Response {
        $categoryproduct = $repo->findOneBy(['idCategory' => $id_category, 'idProduct' => $id_product]);
        if (!$categoryproduct) {
            throw $this->createNotFoundException('Liaison non trouvée.');
        }
        $product = $categoryproduct->getProduct();
        $colors = $colorRepo->findAll();

        if ($request->isMethod('POST')) {
            $newIdCategory = (int)$request->request->get('id_category');
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

            if ($newIdCategory !== $id_category || $newIdProduct !== $id_product) {
                $newProduct = $productRepo->find($newIdProduct);
                if (!$newProduct) {
                    $newProduct = new Product();
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

                $newCategoryproduct = new Categoryproduct();
                $newCategoryproduct->setIdCategory($newIdCategory);
                $newCategoryproduct->setIdProduct($newIdProduct);
                $category = $categoryRepo->find($newIdCategory);
                if ($category) {
                    $newCategoryproduct->setCategory($category);
                }
                $newCategoryproduct->setProduct($newProduct);
                $em->persist($newCategoryproduct);

                $em->remove($categoryproduct);

                $em->flush();

                return $this->redirectToRoute('categoryproduct_index');
            } else {
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

                return $this->redirectToRoute('categoryproduct_index');
            }
        }

        return $this->render('categoryproduct/edit.html.twig', [
            'categoryproduct' => $categoryproduct,
            'product' => $product,
            'colors' => $colors,
        ]);
    }

    #[Route('/admin/categoryproduct/{id_category}/{id_product}', name: 'categoryproduct_show')]
    public function show($id_category, $id_product, CategoryproductRepository $repo, ColorRepository $colorRepo): Response
    {
        $categoryproduct = $repo->findOneBy(['idCategory' => $id_category, 'idProduct' => $id_product]);
        if (!$categoryproduct) {
            throw $this->createNotFoundException('Liaison non trouvée.');
        }
        $colors = $colorRepo->findAll();
        return $this->render('categoryproduct/show.html.twig', [
            'categoryproduct' => $categoryproduct,
            'colors' => $colors,
        ]);
    }
}
