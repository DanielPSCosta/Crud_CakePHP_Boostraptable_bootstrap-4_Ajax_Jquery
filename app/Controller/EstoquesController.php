<?php


class EstoquesController extends AppController
{

    public function index()
    {
        $this->set('estoques', $this->Estoque->find('all'));
    }

    // Busca a tabela Estoques no banco e retorna para a view na função 'tabela'
    public function tabela()
    {
        $resultJ = json_encode($this->Estoque->find('all'));
        $this->response->body($resultJ);
        return $this->response;
    }

    // Cadastrar os itens que são enviados via Ajax pela view e retorna com 0 e 1
    public function Cadastrar()
    {
        //na classe PessoaController
        /*a variável $data recebe o array do post que fica armazenado no array data de requeste */
        $data = array(
            'id_produto'  => $_POST["id_produto"],
            'produto' => $_POST["produto"],
            'qtde' => $_POST["qtde"],
            'validade' => $_POST["validade"]
        );

        if ($this->request->is(array('ajax'))) {
            // the order of these three lines is very important !!!
            if ($this->Estoque->save($data)) {
                $resultJ = json_encode(array('result' => array('now' => '1')));
            } else {
                $resultJ = json_encode(array('result' => array('now' => '2')));
            }

            $this->response->type('json');
            $this->response->body($resultJ);
            return $this->response;
        }
    }

    // Edita os itens que são enviados via Ajax pela view e retorna com 0 e 1
    public function editar()
    {
        //na classe PessoaController
        /*a variável $data recebe o array do post que fica armazenado no array data de requeste */
        $id = $_POST["id"];

        $data = array(
            'id_produto'  => $_POST["id_produto"],
            'produto' => $_POST["produto"],
            'qtde' => $_POST["qtde"],
            'validade' => $_POST["validade"],
        );

        if ($this->request->is(array('ajax'))) {

            // Inicio do update "set id = $id"
            $this->Estoque->id = $id;

            // inserção do update e os dados atualizados em $data
            if ($this->Estoque->save($data)) {

                $resultJ = json_encode(array('result' => array('now' => '1')));
            } else {
                $resultJ = json_encode(array('result' => array('now' => '2')));
            }

            $this->response->type('json');
            $this->response->body($resultJ);
            return $this->response;
        }
    }

    // Deleta os itens que são enviados via Ajax pela view e retorna com 0 e 1
    public function DelProd()
    {
        $data = array(
            'id'  => $_POST["id"],
        );

        if ($this->request->is(array('ajax'))) {
            // the order of these three lines is very important !!!
            if ($this->Estoque->delete($data)) {
                $resultJ = json_encode(array('result' => array('now' => '1')));
            } else {
                $resultJ = json_encode(array('result' => array('now' => '2')));
            }

            $this->response->type('json');
            $this->response->body($resultJ);
            return $this->response;
        }
    }
}
