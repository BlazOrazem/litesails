<footer class="container">
    <hr>

    <p class="text-center">
        &copy; <a href="https://orazem.si" target="_blank" rel="noopener noreferrer">Orazem.si</a> <?= date('Y') ?>. All rights reserved.
    </p>

    <p class="text-center">
        <i class="github-icon"></i>
        <a href="https://github.com/BlazOrazem/litesails" target="_blank" rel="noopener noreferrer">
            Lite Sails on Github.
        </a>
    </p>
</footer>

<div id="js-a2hs" class="a2hs" style="display: none;">
    <span class="a2hs__text">Install Lite Sails on your device</span>
    <button type="button" id="js-a2hs-add" class="btn btn-success btn-sm">Add to home screen</button>
    <button type="button" id="js-a2hs-close" class="a2hs__close" aria-label="Dismiss">&times;</button>
</div>

<div class="modal fade" id="js-ios-install" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                <h4 class="modal-title">Add to Home Screen</h4>
            </div>
            <div class="modal-body">
                <p>Install Lite Sails as an app on your iPhone or iPad:</p>
                <ol class="a2hs__steps">
                    <li>Tap the <strong>Share</strong> button in Safari's toolbar.</li>
                    <li>Choose <strong>Add to Home Screen</strong>.</li>
                    <li>Tap <strong>Add</strong>.</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<script src="/dist/app.min.js?v=<?= @filemtime(__DIR__ . '/dist/app.min.js') ?>"></script>

</body>

</html>
