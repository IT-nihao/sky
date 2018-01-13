<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
// use Phalcon\DI;

class ProductsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        // parent::add();die;
        // $di = new FactoryDefault();
        // print_r($this);die;
        $this->persistent->parameters = null;
    }

    /**
     * Searches for products
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Products',$_POST);
            // print_r($query);die;
            $this->persistent->parameters = $query->getParams();
        // echo 2;die;
        } else {
            // echo 4;die;
            $numberPage = $this->request->getQuery("page", "int");
            // var_dump($numberPage);die;
        }
        $parameters = $this->persistent->parameters;
        // print_r($parameters);die;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $products = Products::find($parameters);
        // print_r($products);die;
        if (count($products) == 0) {
            $this->flash->notice("The search did not find any products");
            $this->dispatcher->forward([
                "controller" => "products",
                "action" => "index"
            ]);
            return;
        }

        $paginator = new Paginator([
            'data' => $products,
            'limit'=> 10,
            'page' => $numberPage
        ]);
        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a product
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $product = Products::findFirstByid($id);
            if (!$product) {
                echo 1;die;
                $this->flash->error("product was not found");
                $this->dispatcher->forward([
                    'controller' => "products",
                    'action' => 'index'
                ]);
                return;
            }
            $this->view->id = $product->id;
            $this->tag->setDefault("id", $product->id);
            $this->tag->setDefault("name", $product->name);
            $this->tag->setDefault("pwd", $product->pwd);
            $this->tag->setDefault("email", $product->email);
            $this->tag->setDefault("img", $product->img);
            $this->tag->setDefault("time", $product->time);
            $this->tag->setDefault("sex", $product->sex);
            $this->tag->setDefault("address", $product->address);
        }
    }

    /**
     * Creates a new product
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "products",
                'action' => 'index'
            ]);

            return;
        }

        $product = new Products();
        $product->name = $this->request->getPost("name");
        $product->pwd = $this->request->getPost("pwd");
        $product->email = $this->request->getPost("email", "email");
        $product->img = $this->request->getPost("img");
        $product->time = $this->request->getPost("time");
        $product->sex = $this->request->getPost("sex");
        $product->address = $this->request->getPost("address");
        

        if (!$product->save()) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "products",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("product was created successfully");

        $this->dispatcher->forward([
            'controller' => "products",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a product edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "products",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $product = Products::findFirstByid($id);
        // print_r($product);die;
        if (!$product) {
            $this->flash->error("product does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "products",
                'action' => 'index'
            ]);

            return;
        }

        $product->name = $this->request->getPost("name");
        $product->pwd = $this->request->getPost("pwd");
        $product->email = $this->request->getPost("email", "email");
        $product->img = $this->request->getPost("img");
        $product->time = $this->request->getPost("time");
        $product->sex = $this->request->getPost("sex");
        $product->address = $this->request->getPost("address");
        

        if (!$product->save()) {
                echo 2;die;
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "products",
                'action' => 'edit',
                'params' => [$product->id]
            ]);

            return;
        }

        $this->flash->success("product was updated successfully");

        $this->dispatcher->forward([
            'controller' => "products",
            'action' => 'search'
        ]);
    }

    /**
     * Deletes a product
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $product = Products::findFirstByid($id);
        if (!$product) {
            $this->flash->error("product was not found");

            $this->dispatcher->forward([
                'controller' => "products",
                'action' => 'index'
            ]);

            return;
        }

        if (!$product->delete()) {

            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "products",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("product was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "products",
            'action' => "index"
        ]);
    }

}
