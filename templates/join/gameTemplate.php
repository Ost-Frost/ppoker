<a class="list-group-item list-group-item-action p-4 ps-5 pe-auto" onclick="expand(event)">
    <div class="d-flex w-100 align-items-center justify-content-between pe-none">
        <strong class="mb-1 pe-none">Spiel von <?= $templateProperties["hostName"] ?></strong>
    </div>
    <div class="col-10 mb-1 small pe-none d-flex align-items-center">
        <span><?= $templateProperties["gameTask"] ?></span>&nbsp;&nbsp;
        <img src="IMG/chevron-right.svg" alt="chevron down" width="16" height="16">
        <img src="IMG/chevron-down.svg" alt="chevron down" width="16" height="16" class="d-none">
    </div>
    <br>
    <div class="pe-none d-none">Beschreibung:<br>
        <div class="col-10 mb-1 small pe-none" style="margin-bottom: 1%;">
            <?= $templateProperties["gameDescription"] ?>
        </div>
        <button class="btn btn-lg btn-success pe-auto" href="#">Beitreten</button>
        <button class="btn btn-lg btn-danger pe-auto" href="#"
            style="margin-left: 10px;">Ablehnen</button>
    </div>
</a>