<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Form\ProdutoType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class ProdutoController extends AbstractController
{
    /**
     * @Route("/produto", name="listar.produto")
     * @Template("/produto/index.html.twig")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $produtos = $em->getRepository(Produto::class)->findAll();
        
        /*return $this->render('produto/index.html.twig', [
            'produtos' => $produtos
        ]);*/

        return [
            'produtos' => $produtos
        ];
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @Route("/produto/cadastrar", name="cadastrar.produto")
     */
    public function create(Request $request)
    {
        $produto = new Produto();

        $form = $this->createForm(ProdutoType::class, $produto);

        $form->handleRequest($request);
        //print_r($form);die;
        

        if ($form->isSubmitted() && $form->isValid())
        {
            
            $produto = $form->getData();

            $em = $this->getDoctrine()->getManager();
            //Caso necessite alterar algum valor do objeto
            //$produto->setNome('ovalornovo');
            $em->persist($produto);
            $em->flush();

            //$this->get('session')->getFlashBag()->set('success', "Produto foi salvo com sucesso");
            $this->addFlash("success", "Produto ".$produto->getNome()." com sucesso!");

            return $this->redirectToRoute('listar.produto');

        }

        return $this->render("produto/create.html.twig", [
            'form' => $form->createView()
        ]);

    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @Route("/produto/editar/{id}", name="editar.produto")
     */
    public function update(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($id);

        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $produto = $form->getData();
            $em->persist($produto);
            $em->flush();

            $this->get("session")->getFlashBag()->set('success', "O produto ".$produto->getNome()." foi alteraro com sucesso!");
            return $this->redirectToRoute('listar.produto');
        }

        return $this->render("produto/update.html.twig", [
            'produto'   => $produto,
            'form'      => $form->createView()
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Request $requed
     * @Route("/produto/visualizar/{id}", name="visualizar.produto")
     * 
     * @return Response
     */
    public function view(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($id);
        
        return $this->render("produto/visualizar.html.twig", [
            'produto' => $produto
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @Route("/produto/apagar/{id}", name="apagar.produto")
     */
    public function delete(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($id);

        if(!$produto)
        {
            $mensagem = "Produto não foi encontrato!"; 
            $tipo = "warning";
        }else{
            $em->remove($produto);
            $em->flush();

            $mensagem = "O Produto foi excluido com sucesso!";    
            $tipo = "success";
        }
        $this->get("session")->getFlashBag()->set($tipo, $mensagem);

        return $this->redirectToRoute('listar.produto');
    }
}
