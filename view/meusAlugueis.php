<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/estilos/header.css">
    <link rel="stylesheet" href="view/estilos/meusAlugueis.css">
    <title>Meus Aluguéis — AutomóvelJá</title>
</head>
<body>

<?php include_once __DIR__ . "/componentes/header.php"; ?>

<div class="alugueis-wrapper">

    <div class="alugueis-header">
        <div>
            <h1 class="alugueis-titulo">Meus Aluguéis</h1>
            <p class="alugueis-subtitulo">Acompanhe e gerencie todas as suas locações</p>
        </div>
        <a href="?p=veiculos" class="btn-primario">+ Alugar veículo</a>
    </div>

    <?php if ($mensagem === 'devolvido'): ?>
        <div class="alerta alerta-ok">Veículo devolvido com sucesso. Obrigado!</div>
    <?php elseif ($mensagem === 'alterado'): ?>
        <div class="alerta alerta-ok">Aluguel atualizado com sucesso.</div>
    <?php elseif ($mensagem === 'cancelado'): ?>
        <div class="alerta alerta-ok">Aluguel cancelado com sucesso.</div>
    <?php elseif ($mensagem === 'erro'): ?>
        <div class="alerta alerta-erro">Não foi possível realizar a operação. Tente novamente.</div>
    <?php elseif ($mensagem === 'datas_invalidas'): ?>
        <div class="alerta alerta-erro">Datas inválidas. A retirada deve ser hoje ou depois, e a devolução deve ser após a retirada.</div>
    <?php elseif ($mensagem === 'nao_permitido'): ?>
        <div class="alerta alerta-erro">Esta operação não é permitida para o status atual do aluguel.</div>
    <?php endif; ?>

    <?php if (empty($alugueis)): ?>

        <div class="estado-vazio">
            <div class="estado-vazio-icone">🚗</div>
            <h2>Nenhum aluguel encontrado</h2>
            <p>Você ainda não fez nenhuma locação. Explore nosso catálogo!</p>
            <a href="?p=veiculos" class="btn-primario">Ver veículos disponíveis</a>
        </div>

    <?php else: ?>

        <div class="tabela-wrap">
            <table class="tabela-admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Veículo</th>
                        <th>Retirada</th>
                        <th>Devolução</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alugueis as $a): ?>
                        <tr>
                            <td class="td-id">#<?= $a->id ?></td>

                            <td>
                                <strong><?= htmlspecialchars($a->marca) ?> <?= htmlspecialchars($a->modelo) ?></strong>
                                <small><?= ucfirst(htmlspecialchars($a->tipo)) ?></small>
                            </td>

                            <td><?= date('d/m/Y', strtotime($a->data_inicio)) ?></td>
                            <td><?= date('d/m/Y', strtotime($a->data_fim)) ?></td>

                            <td>R$ <?= number_format($a->total, 2, ',', '.') ?></td>

                            <td>
                                <span class="badge-status <?= htmlspecialchars($a->status) ?>">
                                    <?php
                                        $labels = [
                                            'pendente'   => '⏳ Pendente',
                                            'ativo'      => '✅ Ativo',
                                            'finalizado' => '📦 Finalizado',
                                            'cancelado'  => '❌ Cancelado',
                                        ];
                                        echo $labels[$a->status] ?? ucfirst($a->status);
                                    ?>
                                </span>
                            </td>

                            <td class="td-acoes">
                                <?php if (in_array($a->status, ['pendente', 'ativo'])): ?>

                                    <!-- Botão Editar datas (abre modal) -->
                                    <button
                                        class="btn-acao editar"
                                        onclick="abrirModalEditar(
                                            <?= $a->id ?>,
                                            '<?= $a->data_inicio ?>',
                                            '<?= $a->data_fim ?>',
                                            '<?= htmlspecialchars($a->marca . ' ' . $a->modelo) ?>'
                                        )"
                                        title="Alterar datas"
                                    >✏️ Alterar</button>

                                    <!-- Botão Devolver -->
                                    <form method="post" action="?p=devolver-aluguel"
                                          onsubmit="return confirm('Confirmar devolução do <?= htmlspecialchars($a->marca . ' ' . $a->modelo) ?>?')">
                                        <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                        <input type="hidden" name="aluguel_id" value="<?= $a->id ?>">
                                        <button type="submit" class="btn-acao devolver" title="Devolver veículo">
                                            🔑 Devolver
                                        </button>
                                    </form>

                                    <!-- Botão Cancelar -->
                                    <form method="post" action="?p=cancelar-aluguel"
                                          onsubmit="return confirm('Tem certeza que deseja cancelar este aluguel?')">
                                        <input type="hidden" name="csrf_token" value="<?= $token ?>">
                                        <input type="hidden" name="aluguel_id" value="<?= $a->id ?>">
                                        <button type="submit" class="btn-acao cancelar" title="Cancelar aluguel">
                                            ✖ Cancelar
                                        </button>
                                    </form>

                                <?php else: ?>
                                    <span style="color:var(--cinza-med); font-size:0.8rem;">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>

<!-- Modal de edição de datas -->
<div class="modal-overlay" id="modal-editar">
    <div class="modal-caixa">
        <h2 class="modal-titulo">Alterar datas</h2>
        <p class="modal-sub" id="modal-veiculo-nome">—</p>

        <form method="post" action="?p=alterar-aluguel" id="form-editar">
            <input type="hidden" name="csrf_token" value="<?= $token ?>">
            <input type="hidden" name="aluguel_id" id="modal-aluguel-id" value="">

            <div class="form-grupo">
                <label for="modal-data-inicio">Data de retirada</label>
                <input type="date" id="modal-data-inicio" name="data_inicio" required>
            </div>

            <div class="form-grupo">
                <label for="modal-data-fim">Data de devolução</label>
                <input type="date" id="modal-data-fim" name="data_fim" required>
            </div>

            <div class="modal-acoes">
                <button type="button" class="btn-secundario" onclick="fecharModal()">Cancelar</button>
                <button type="submit" class="btn-primario">Salvar alterações</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModalEditar(id, dataInicio, dataFim, nomeVeiculo) {
        document.getElementById('modal-aluguel-id').value  = id;
        document.getElementById('modal-data-inicio').value = dataInicio;
        document.getElementById('modal-data-fim').value    = dataFim;
        document.getElementById('modal-veiculo-nome').textContent = nomeVeiculo;
        document.getElementById('modal-editar').classList.add('aberto');
    }

    function fecharModal() {
        document.getElementById('modal-editar').classList.remove('aberto');
    }

    // Fecha modal ao clicar fora da caixa
    document.getElementById('modal-editar').addEventListener('click', function(e) {
        if (e.target === this) fecharModal();
    });
</script>

</body>
</html>
