<link rel="stylesheet" href="./css/contato.css">

<div class="contato-wrapper">
    <div class="contato-info">
        <h2>Fale Conosco</h2>
        <p>Tem dúvidas sobre as categorias dos nossos veículos, formas de pagamento ou precisa de suporte durante a sua locação? Nossa equipe está pronta para te atender.</p>
        <ul>
            <li>📍 <strong>Endereço:</strong> Av. Principal, 1000 - Centro</li>
            <li>📞 <strong>Telefone:</strong> (41) 3000-0000</li>
            <li>✉️ <strong>E-mail:</strong> atendimento@automovelja.com.br</li>
            <li>🕒 <strong>Atendimento:</strong> Seg. a Sex. das 08h às 18h</li>
        </ul>
    </div>
    <div class="contato-form-box">
        <h2>Envie uma Mensagem</h2>

        <?php if (!empty($mensagemErro)): ?>
            <div class="auth-alert auth-alert-erro"><?= htmlspecialchars($mensagemErro) ?></div>
        <?php endif; ?>

        <?php if (!empty($mensagemSucesso)): ?>
            <div class="auth-alert auth-alert-sucesso"><?= htmlspecialchars($mensagemSucesso) ?></div>
        <?php endif; ?>

        <form action="?p=contato" method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome" value="<?= htmlspecialchars($nome) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="seu@email.com" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="form-group">
                <label for="assunto">Assunto</label>
                <input type="text" id="assunto" name="assunto" placeholder="Ex: Dúvida sobre locação" value="<?= htmlspecialchars($assunto) ?>" required>
            </div>
            <div class="form-group">
                <label for="mensagem">Mensagem</label>
                <textarea id="mensagem" name="mensagem" placeholder="Escreva sua mensagem aqui..." required><?= htmlspecialchars($mensagemUsuario) ?></textarea>
            </div>
            <button type="submit" class="btn-enviar">Enviar Mensagem</button>
        </form>
    </div>
</div>