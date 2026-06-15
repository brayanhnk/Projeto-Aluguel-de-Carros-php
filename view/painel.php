<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/estilos/header.css">
    <link rel="stylesheet" href="view/estilos/admin.css">
    <title>Painel Admin — AutomóvelJá</title>
</head>
<body>

<div class="admin-wrapper">
    <div class="admin-header">
        <div>
            <h1 class="admin-titulo">Painel Admin</h1>
            <p class="admin-subtitulo">Gerencie o catálogo de veículos</p>
        </div>
        <a href="?p=cadastrar-veiculo" class="btn-primario">+ Novo veículo</a>
    </div>

    <?php if ($mensagem === 'cadastrado'): ?>
        <div class="alerta alerta-ok">Veículo cadastrado com sucesso.</div>
    <?php elseif ($mensagem === 'editado'): ?>
        <div class="alerta alerta-ok">Veículo atualizado com sucesso.</div>
    <?php elseif ($mensagem === 'deletado'): ?>
        <div class="alerta alerta-ok">Veículo removido com sucesso.</div>
    <?php elseif ($mensagem === 'nao_encontrado'): ?>
        <div class="alerta alerta-erro">Veículo não encontrado.</div>
    <?php elseif($mensagem === 'veiculo_com_historico'): ?>
        <div class="alerta alerta-erro">Este veículo tem alugueis vinculados a ele, não pode ser deletado.</div>
    <?php elseif($mensagem === 'sem_alteracao'): ?>
        <div class="alerta alerta-erro">O veiculo não foi alterado</div>
    <?php endif; ?>

    <div class="tabela-wrap">
        <table class="tabela-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Veículo</th>
                    <th>Tipo</th>
                    <th>Categoria</th>
                    <th>Placa</th>
                    <th>Diária</th>
                    <th>Disponível</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($veiculos)): ?>
                    <tr>
                        <td colspan="9" style="text-align:center; color:var(--cinza-med); padding:2rem;">
                            Nenhum veículo cadastrado.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($veiculos as $v): ?>
                        <tr>
                            <td class="td-id">#<?= $v->id ?></td>

                            <td>
                                <?php if ($v->imagem): ?>
                                    <img src="imagens/<?= htmlspecialchars($v->imagem) ?>"
                                         alt="<?= htmlspecialchars($v->modelo) ?>"
                                         class="tabela-img">
                                <?php else: ?>
                                    <span class="sem-imagem">—</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <strong><?= htmlspecialchars($v->marca) ?> <?= htmlspecialchars($v->modelo) ?></strong>
                                <small><?= htmlspecialchars($v->ano) ?> · <?= htmlspecialchars($v->cor) ?></small>
                            </td>

                            <td><?= ucfirst(htmlspecialchars($v->tipo)) ?></td>
                            <td><?= htmlspecialchars($v->categoria) ?></td>
                            <td class="td-placa"><?= htmlspecialchars($v->placa) ?></td>
                            <td>R$ <?= number_format($v->preco_diaria, 2, ',', '.') ?></td>

                            <td>
                                <span class="badge-disponivel <?= $v->disponivel ? 'sim' : 'nao' ?>">
                                    <?= $v->disponivel ? 'Sim' : 'Não' ?>
                                </span>
                            </td>

                            <td class="td-acoes">
                                <form method="get" action="?p=editar-veiculo">
                                    <input type="hidden" name="p" value="editar-veiculo">
                                    <input type="hidden" name="id" value="<?= $v->id ?>">
                                    <button type="submit" class="btn-acao editar" title="Editar">✏️</button>
                                </form>

                                <form method="post" action="?p=deletar-veiculo"
                                      onsubmit="return confirmarDelete('<?= htmlspecialchars($v->marca) ?> <?= htmlspecialchars($v->modelo) ?>')">
                                    <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                    <input type="hidden" name="id" value="<?= $v->id ?>">
                                    <button type="submit" class="btn-acao deletar" title="Deletar">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmarDelete(nome) {
        return confirm('Tem certeza que deseja remover "' + nome + '"?\nEsta ação não pode ser desfeita.');
    }
</script>

</body>
</html>