<div class="starter-template">
    <?php if ($exception && $env == \Phalcony\Application::ENV_DEVELOPMENT) : ?>
        <?php
            $prettyException = new \Phalcon\Utils\PrettyExceptions();
            $prettyException->setTheme('minimalist');
            $prettyException->handle($exception);
            die();
        ?>
    <?php else: ?>
        Error: <?php echo $error; ?>
    <?php endif; ?>
</div>