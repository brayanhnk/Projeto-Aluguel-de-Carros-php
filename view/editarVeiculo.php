<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/estilos/header.css">
    <link rel="stylesheet" href="view/estilos/admin.css">
    <title>Editar Veículo - AutomóvelJá</title>
</head>
<body>

<div class="admin-wrapper">
    <div class="admin-header">
        <div>
            <h1 class="admin-titulo">Editar Veículo</h1>
            <p class="admin-subtitulo"><?= htmlspecialchars($dados['marca'] ?? '') ?> <?= htmlspecialchars($dados['modelo'] ?? '') ?></p>
        </div>
    </div>

    <?php if (!empty($erros)): ?>
        <div class="alerta alerta-erro">
            <?php foreach ($erros as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form method="post" action="?p=editar-veiculo&id=<?= (int)($dados['id'] ?? 0) ?>" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $token ?>">

            <div class="form-grid">

                <div class="form-grupo">
                    <label for="tipo">Tipo *</label>
                    <select name="tipo" id="tipo" required>
                        <option value="">Selecione...</option>
                        <option value="carro" <?= ($dados['tipo'] ?? '') === 'carro' ? 'selected' : '' ?>>Carro</option>
                        <option value="moto"  <?= ($dados['tipo'] ?? '') === 'moto'  ? 'selected' : '' ?>>Moto</option>
                    </select>
                </div>

                <div class="form-grupo">
                    <label for="categoria">Categoria *</label>
                    <select name="categoria" id="categoria" required>
                        <option value="">Selecione...</option>
                        <?php
                        foreach ($categorias as $cat):
                            $sel = ($dados['categoria'] ?? '') === $cat ? 'selected' : '';
                        ?>
                            <option value="<?= $cat ?>" <?= $sel ?>><?= $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-grupo">
                    <label for="marca">Marca *</label>
                    <input type="text" name="marca" id="marca" required
                           value="<?= htmlspecialchars($dados['marca'] ?? '') ?>"
                           placeholder="Ex: Toyota">
                </div>

                <div class="form-grupo">
                    <label for="modelo">Modelo *</label>
                    <input type="text" name="modelo" id="modelo" required
                           value="<?= htmlspecialchars($dados['modelo'] ?? '') ?>"
                           placeholder="Ex: Corolla">
                </div>

                <div class="form-grupo">
                    <label for="ano">Ano *</label>
                    <input type="number" name="ano" id="ano" required
                           min="1900" max="<?= date('Y') + 1 ?>"
                           value="<?= htmlspecialchars($dados['ano'] ?? '') ?>"
                           placeholder="<?= date('Y') ?>">
                </div>

                <div class="form-grupo">
                    <label for="cor">Cor</label>
                    <input type="text" name="cor" id="cor"
                           value="<?= htmlspecialchars($dados['cor'] ?? '') ?>"
                           placeholder="Ex: Prata">
                </div>

                <div class="form-grupo">
                    <label for="placa">Placa *</label>
                    <input type="text" name="placa" id="placa" required
                           value="<?= htmlspecialchars($dados['placa'] ?? '') ?>"
                           placeholder="Ex: BRA2E23"
                           style="text-transform: uppercase">
                </div>

                <div class="form-grupo">
                    <label for="preco_diaria">Preço por diária (R$) *</label>
                    <input type="number" name="preco_diaria" id="preco_diaria" required
                           min="0.01" step="0.01"
                           value="<?= htmlspecialchars($dados['preco_diaria'] ?? '') ?>"
                           placeholder="Ex: 150.00">
                </div>

                <div class="form-grupo">
                    <label for="quilometragem">Quilometragem</label>
                    <input type="number" name="quilometragem" id="quilometragem"
                           min="0"
                           value="<?= htmlspecialchars($dados['quilometragem'] ?? '0') ?>"
                           placeholder="Ex: 25000">
                </div>

                <div class="form-grupo">
                    <label for="imagem">Imagem do veículo</label>

                    <?php if (!empty($dados['imagem'])): ?>
                        <div style="margin-bottom: 0.5rem;">
                            <img src="imagens/<?= htmlspecialchars($dados['imagem']) ?>"
                                 alt="Imagem atual"
                                 style="max-width: 160px; border-radius: 8px; border: 1px solid var(--borda);">
                            <br>
                            <small class="form-hint">Imagem atual: <strong><?= htmlspecialchars($dados['imagem']) ?></strong></small>
                        </div>
                    <?php endif; ?>

                    <input type="file" name="imagem" id="imagem" accept="image/png, image/jpeg, image/webp">
                    <small class="form-hint">Deixe em branco para manter a imagem atual. Formatos: PNG, JPG, WEBP. Máx: 2MB</small>
                </div>

                <div class="form-grupo form-grupo-check">
                    <label class="label-check">
                        <input type="checkbox" name="disponivel" value="1" <?= !empty($dados['disponivel']) ? 'checked' : '' ?>> Disponível para aluguel
                    </label>
                </div>

            </div>

            <div class="form-acoes">
                <a href="?p=painel" class="btn-secundario">Cancelar</a>
                <button type="submit" class="btn-primario">Salvar alterações</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>