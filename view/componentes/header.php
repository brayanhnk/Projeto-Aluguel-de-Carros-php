<header>
    <div class="header-inner">

        <a href="?p=home" class="logo">Carro<span>Já</span></a>

        <nav id="nav-menu">
            <a href="?p=home"     <?= ($_GET['p'] ?? '') === 'home'     ? 'class="ativo"' : '' ?>>Início</a>
            <a href="?p=veiculos" <?= ($_GET['p'] ?? '') === 'veiculos' ? 'class="ativo"' : '' ?>>Veículos</a>
            <a href="?p=contato"  <?= ($_GET['p'] ?? '') === 'contato'  ? 'class="ativo"' : '' ?>>Contato</a>
            <a href="?p=sobre"    <?= ($_GET['p'] ?? '') === 'sobre'    ? 'class="ativo"' : '' ?>>Sobre</a>

            <?php if (isset($_SESSION['usuario'])): ?>
                <div class="nav-sep"></div>
                <a href="?p=meus-alugueis" <?= ($_GET['p'] ?? '') === 'meus-alugueis' ? 'class="ativo"' : '' ?>>Meus Aluguéis</a>
            <?php endif; ?>
        </nav>

        <div class="usuario-area">
            <?php if (isset($_SESSION['usuario'])): ?>
                <span class="usuario-nome">
                    Olá, <strong><?= htmlspecialchars($_SESSION['usuario']['nome']) ?></strong>
                </span>
                <a href="?p=logout" class="btn-logout">Sair</a>
            <?php else: ?>
                <a href="?p=login" class="btn-login">Entrar</a>
            <?php endif; ?>
        </div>

    </div>
</header>