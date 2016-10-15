<?php

namespace CodeEmailMKT\Application\Action;

use CodeEmailMKT\Domain\Entity\Category;
use CodeEmailMKT\Domain\Entity\Customer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;

class TestePageAction
{
    private $template;
    /**
     * @var EntityManager
     */
    private $manager;
    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;

    public function __construct(CustomerRepositoryInterface $repository,TemplateRendererInterface $template = null)
    {
        $this->template = $template;
        $this->repository = $repository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $customer = new Customer();
        $customer->setName('Luiz Carlos')
                 ->setEmail('luiz@code.education');

        $this->repository->create($customer);

        //$categorias = $this->manager->getRepository(Category::class)->findAll();

        return new HtmlResponse($this->template->render("app::teste",[
            "data"=>'dados passados para o template',
            'categorias'=> [],
            'minhaClasse' => new \CodeEmailMKT\MinhaClasse()
        ]));

    }
}
