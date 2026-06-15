<header>
    <div class="header-inner">

        <a href="?p=home" class="logo">Automóvel<span>Já</span></a>

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
                    <?php if ($_SESSION['perfil'] == 'admin'): ?>
                        Olá, <strong><a href="?p=painel"><?=htmlspecialchars($_SESSION['usuario'])?></a></strong>
                    <?php else: ?>
                        Olá, <strong><?= htmlspecialchars($_SESSION['usuario'])?></strong>
                    <?php endif; ?>
                </span>
                <a href="?p=logout" class="btn-logout">Sair</a>
            <?php else: ?>
                <a href="?p=fazer-login" class="btn-login">Entrar</a>
            <?php endif; ?>
        </div>

    </div>
</header>