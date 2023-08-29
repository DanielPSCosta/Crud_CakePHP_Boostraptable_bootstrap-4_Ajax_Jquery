<div class="container-fluid">
    <div id="toolbar">
        <button type="button" class="btn btn-primary" onclick="ModCadEstoque(1)">Cadastrar</button>
    </div>
    <div class="row">
        <!-- Tabela principal -->
        <table id="table" class="table" data-toolbar="#toolbar" data-toggle="table" data-search="true" data-show-columns-toggle-all="true" data-pagination="true">
            <thead>
                <tr>
                    <th data-halign="center" data-align="center" data-field="id_produto">ID Produto</th>
                    <th data-halign="center" data-align="center" data-field="qtde">Quantidade</th>
                    <th data-halign="center" data-align="center" data-field="produto">Produto</th>
                    <th data-halign="center" data-align="center" data-field="validade">Validade</th>
                    <th data-halign="center" data-align="center" data-field="id" data-formatter="editar">Editar</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal para editar e para cadastrar -->
<div class="modal fade" id="ModalCadEstoque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="htexto">PRODUTO</h5>
                <button class="btn btn-outline-light" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#ModalCadEstoque').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditCad">
                    <input type="text" id="idDeVerificacao" class="d-none">
                    <input type="text" id="idProd" class="d-none">
                    <div class="form-group">
                        <label class="text-dark">ID Produto:</label>
                        <input type="number" class="form-control" id="txtIdProd" placeholder="Insira o número do produto">
                    </div>
                    <div class="form-group">
                        <label class="text-dark">Produto:</label>
                        <input type="text" class="form-control" id="txtproduto" placeholder="Insira o nome do produto">
                    </div>
                    <div class="form-group">
                        <label class="text-dark">Quantidade:</label>
                        <input type="number" class="form-control" id="numQtde" placeholder="Insira a quantidade do produto">
                    </div>
                    <div class="form-group">
                        <label class="text-dark">Validade:</label>
                        <input type="date" class="form-control" id="txtValidade">
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-dark">
                <button type="button" class="btn btn-secondary" onclick="$('#ModalCadEstoque').modal('hide')">Fechar</button>
                <button id="cadastrarPro" type="button" class="btn btn-primary" onclick="Cadastrar()">Cadastrar</button>
                <button id="editarPro" type="button" class="btn btn-success" onclick="Editar()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Executa assim que abre a pagina
    window.onload = function() {
        tabela()
    }

    // Popula a tabela no inicio da pagina
    function tabela() {
        $.ajax({
            url: "http://localhost/Estoque/Estoques/tabela",
            type: "POST",
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: "Aguarde!",
                    text: "Buscando dados...",
                    imageUrl: 'http://localhost/Estoque/app/webroot/img/5.gif',
                    imageWidth: 100,
                    imageHeight: 80,
                    showConfirmButton: false
                })
            },
            error: function(data_error) {
                sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
            },
            success: function(result) {

                // Retirando a coluna 'Estoque' do array com 'map e push'
                var output = [];
                $.map(result, function(arrayVect, index) {
                    output.push(arrayVect['Estoque']);
                });

                console.log(output)
                $("#table").bootstrapTable('removeAll');
                $("#table").bootstrapTable('append', output);

                Swal.fire({
                    timer: 100,
                    title: "Aguarde!",
                    text: "Buscando dados...",
                    imageUrl: 'http://localhost/Estoque/app/webroot/img/5.gif',
                    imageWidth: 100,
                    imageHeight: 80,
                    showConfirmButton: false
                })
            },
        });
    }

    // é executado quando se clica no botão de editar na tabela
    function ModCadEstoque(cod, value, id_produto, produto, qtde, validade) {
        if (cod == 1) {
            $('#formEditCad')[0].reset();
            $('#ModalCadEstoque').modal('show');
            $('#idDeVerificacao').val('1');

            $('#htexto').text('CADASTRO DE PRODUTO');

            $('#editarPro').addClass('d-none');
            $('#cadastrarPro').removeClass('d-none');
            tabela();

        } else {
            Swal.fire({
                title: "Aguarde!",
                text: "Buscando dados...",
                imageUrl: 'http://localhost/Estoque/app/webroot/img/5.gif',
                imageWidth: 100,
                imageHeight: 80,
                showConfirmButton: false
            })
            $('#formEditCad')[0].reset();
            $('#ModalCadEstoque').modal('show');
            $('#idDeVerificacao').val('2');
            $('#htexto').text('EDITAR DE PRODUTO');
            $('#cadastrarPro').addClass('d-none');
            $('#editarPro').removeClass('d-none');

            $('#idProd').val(value);
            $('#txtIdProd').val(id_produto);
            $('#txtproduto').val(produto);
            $('#numQtde').val(qtde);
            $('#txtValidade').val(validade);

            Swal.fire({
                timer: 100,
                title: "Aguarde!",
                text: "Buscando dados...",
                imageUrl: 'http://localhost/Estoque/app/webroot/img/5.gif',
                imageWidth: 100,
                imageHeight: 80,
                showConfirmButton: false
            })
        }
    }

    // Botões que aparecem na coluna 'Editar' da tabela
    function editar(value, row) {
        return '<button class="btn btn-outline-primary" onclick="ModCadEstoque(2,\'' + value + '\',\'' + row.id_produto + '\',\'' + row.produto + '\',\'' + row.qtde + '\',\'' + row.validade + '\')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>\n\
                <button class="btn btn-outline-danger" onclick="DelProd(\'' + value + '\')"><i class="fa fa-trash" aria-hidden="true"></i></button>'
    }

    // Função para cadastrar produtos
    function Cadastrar() {
        $.ajax({
            url: "http://localhost/Estoque/Estoques/Cadastrar",
            type: "POST",
            dataType: 'json',
            data: {
                id_produto: $('#txtIdProd').val(),
                produto: $('#txtproduto').val(),
                qtde: $('#numQtde').val(),
                validade: $('#txtValidade').val()

            },
            beforeSend: function() {
                Swal.fire({
                    title: "Aguarde!",
                    text: "Buscando dados...",
                    imageUrl: 'http://localhost/Estoque/app/webroot/img/5.gif',
                    imageWidth: 100,
                    imageHeight: 80,
                    showConfirmButton: false
                })
            },
            error: function(data_error) {
                sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
            },
            success: function(result) {
                if (result.result['now'] == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cadastrado com sucesso!',
                        showConfirmButton: true,
                    })
                    $('#ModalCadEstoque').modal('hide')
                    tabela()

                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Não foi possivel cadastrar, aguarde alguns minutos antes de tentar novamente!',
                        showConfirmButton: true,
                    })
                }
            },
        });
    }

    // Função para editar produto
    function Editar() {
        $.ajax({
            url: "http://localhost/Estoque/Estoques/Editar",
            type: "POST",
            dataType: 'json',
            data: {
                id: $('#idProd').val(),
                id_produto: $('#txtIdProd').val(),
                produto: $('#txtproduto').val(),
                qtde: $('#numQtde').val(),
                validade: $('#txtValidade').val()

            },
            beforeSend: function() {
                Swal.fire({
                    title: "Aguarde!",
                    text: "Buscando dados...",
                    imageUrl: 'http://localhost/Estoque/app/webroot/img/5.gif',
                    imageWidth: 100,
                    imageHeight: 80,
                    showConfirmButton: false
                })
            },
            error: function(data_error) {
                sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
            },
            success: function(result) {
                if (result.result['now'] == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Editado com sucesso!',
                        showConfirmButton: true,
                    })
                    $('#ModalCadEstoque').modal('hide')
                    tabela()

                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Não foi possivel editar, aguarde alguns minutos antes de tentar novamente!',
                        showConfirmButton: true,
                    })
                }
            },
        });
    }




    // Função para deletar produto
    function DelProd(id) {
        $.ajax({
            url: "http://localhost/Estoque/Estoques/DelProd",
            type: "POST",
            dataType: 'json',
            data: {
                id: id
            },
            beforeSend: function() {
                Swal.fire({
                    title: "Aguarde!",
                    text: "Buscando dados...",
                    imageUrl: 'http://localhost/Estoque/app/webroot/img/5.gif',
                    imageWidth: 100,
                    imageHeight: 80,
                    showConfirmButton: false
                })
            },
            error: function(data_error) {
                sweetAlert("Oops...", "Aguarde alguns minutos antes de tentar novamente!", "info");
            },
            success: function(result) {
                if (result.result['now'] == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deletado com sucesso!',
                        showConfirmButton: true,
                    })
                    $('#ModalCadEstoque').modal('hide')
                    tabela()
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Não foi possivel deletar, aguarde alguns minutos antes de tentar novamente!',
                        showConfirmButton: true,
                    })
                }
            },
        });
    }
</script>